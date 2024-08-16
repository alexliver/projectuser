<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Gender;
use Laravel\Passport\Passport;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserProjectManagementTest extends TestCase
{
    use RefreshDatabase;


    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', 'http://localhost'
        );

        $this->user = User::create([
            'first_name' => 'test',
            'last_name' => 'test',
            'date_of_birth' => '2000-01-01',
            'gender' => Gender::Male->value,
            'email' => 'a@a.cn',
            'password' => '88888888',
        ]);
        Passport::actingAs($this->user);
        $this->token = $this->user->createToken('TestToken', [])->accessToken;
    }

    /**
     * successfully joining a project
     */
    public function testJoinProject1(): void
    {        
        $project = $this->createProject();
        $response = $this->joinProject($project);
        $response->assertStatus(200);
        $myProjects = $this->getMyProjects();
        assert(count($myProjects) == 1);
        assert($myProjects[0]['id'] == $project->id);
    }

    /**
     * do nothing when joining the project again
     */
    public function testJoinProject2(): void
    {        
        $project = $this->createProject();
        $response = $this->joinProject($project);
        $response->assertStatus(200);
        $response = $this->joinProject($project);
        $response->assertStatus(200);
        $myProjects = $this->getMyProjects();
        assert(count($myProjects) == 1);
        assert($myProjects[0]['id'] == $project->id);
    }

    /**
     * fail to join a project because the project has already finished
     */
    public function testJoinProjectFail1(): void
    {        
        $startDate = Carbon::now()->subDay(3);
        $endDate = Carbon::now()->subDay(1);
        $project = $this->createProject($startDate, $endDate, ProjectStatus::InProgress->value);
        $response = $this->joinProject($project);
        $response->assertStatus(400);
    }

    /**
     * fail to join a project because the project has not started yet
     */
    public function testJoinProjectFail2(): void
    {        
        $startDate = Carbon::now()->addDay(3);
        $endDate = Carbon::now()->addDay(10);
        $project = $this->createProject($startDate, $endDate, ProjectStatus::InProgress->value);
        $response = $this->joinProject($project);
        $response->assertStatus(400);
    }

    /**
     * fail to join a project because the project has finished
     */
    public function testJoinProjectFail3(): void
    {        
        $project = $this->createProject(status: ProjectStatus::Finished->value);
        $response = $this->joinProject($project);
        $response->assertStatus(400);
    }

    /**
     * successfully logging a timesheet to a project
     */
    public function testLogTimesheet() 
    {
        $project = $this->createProject();
        $this->joinProject($project);
        $response = $this->logTimesheet($project);
        $response->assertStatus(201);
        $timesheets = $this->getTimesheets($project);
        assert(count($timesheets) == 1);
    }

    /**
     * failed to log a timesheet because the user hasn't joined the project yet
     */
    public function testLogTimesheetFail1() 
    {
        $project = $this->createProject();
        $response = $this->logTimesheet($project);
        $response->assertStatus(400);
    }

    /**
     * failed to log a timesheet because the date is not within the project's start/end date
     */
    public function testLogTimesheetFail2() 
    {
        $project = $this->createProject();
        $response = $this->logTimesheet($project, Carbon::now()->subDay(10));
        $response->assertStatus(400);
    }

    /**
     * failed to log a timesheet because the date is not within the project's start/end date
     */
    public function testLogTimesheetFail3() 
    {
        $project = $this->createProject();
        $response = $this->logTimesheet($project, Carbon::now()->addDay(10));
        $response->assertStatus(400);
    }
    /**
     * failed to log a timesheet because the project is finished
     */
    public function testLogTimesheetFail4() 
    {
        $project = $this->createProject(status: ProjectStatus::Finished->value);
        $response = $this->logTimesheet($project);
        $response->assertStatus(400);
    }

    private function logTimesheet($project, $date=null) 
    {
        if ($date == null)
            $date = Carbon::now();
        $data = [
            'task_name' => 'test',
            'date' => $date,
            'hours' => 1,
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('/api/user-project-management/log-timesheet/' . $project->id, $data);
        return $response;
    }

    private function joinProject($project) 
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/user-project-management/join-project/' . $project->id);
        return $response;
    }

    private function createProject($startDate=null, $endDate=null, 
        $status=ProjectStatus::InProgress->value) 
    {
        if ($startDate == null)
            $startDate = Carbon::now()->subDay();
        if ($endDate == null)
            $endDate = Carbon::now()->addDay();
        return Project::create([
            'name' => 'test',
            'department' => 'test',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
        ]);
    }

    private function getMyProjects()
    {        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/user-project-management/my-projects/');
        $response->assertStatus(200);
        return $response->json();
    }

    private function getTimesheets($project)
    {        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/user-project-management/my-timesheets/' . $project->id);
        $response->assertStatus(200);
        return $response->json();
    }
}
