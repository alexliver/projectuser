<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Process\UserProjectProcess;

/**
 * For a hypothetical user app interacting with projects
 */
class UserProjectManagementController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user-project-management/join-project/{id}",
     *     summary="Join a project",
     *     tags={"User Project Management"},
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project details",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     * )
     */
    public function joinProject(Request $request, $id)
    {
        $user = $request->user();
        $project = Project::findOrFail($id);
        UserProjectProcess::joinProject($user, $project);
        return response()->json($project, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user-project-management/my-projects",
     *     summary="Get a list of the current user's projects",
     *     tags={"User Project Management"},
     *     security={{ "bearer": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="List of projects",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Project"))
     *     )
     * )
     */
    public function myProjects(Request $request)
    {
        $user = $request->user();
        return response()->json($user->projects);
    }

    /**
     * @OA\Post(
     *     path="/api/user-project-management/log-timesheet/{id}",
     *     summary="Create a new timesheet",
     *     tags={"User Project Management"},
     *     security={{ "bearer": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"task_name", "date", "hours"},
     *             @OA\Property(property="task_name", type="string", example="task"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="hours", type="int"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Timesheet created",
     *         @OA\JsonContent(ref="#/components/schemas/Timesheet")
     *     )
     * )
     */
    public function logTimesheet(Request $request, $id)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|integer|min:1|max:24'
        ]);
        $user = $request->user();
        $project = Project::findOrFail($id);
        $timesheet = UserProjectProcess::logTimesheet($user, $project, $request->task_name, 
            $request->date, $request->hours);
        return response()->json($timesheet, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/user-project-management/my-timesheets/{id}",
     *     summary="Get a list of timesheets of the current user",
     *     tags={"User Project Management"},
     *     security={{ "bearer": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of timesheets",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Timesheet"))
     *     )
     * )
     */
    public function myTimesheets(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $user = $request->user();
        $timesheets = Timesheet::where('user_id', $user->id)
                     ->where('project_id', $id)
                     ->get();
        return response()->json($timesheets);
    }
}

