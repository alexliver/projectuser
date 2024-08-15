<?php

namespace App\Process;

use App\Exceptions\DomainException;
use App\Models\User;
use App\Models\Timesheet;
use App\Models\Project;

class UserProjectProcess 
{
    /**
     * Join a user to a project.
     * Throws DomainException if the project is inactive 
     * Does nothing if the user has already joined
     */
    public static function joinProject(User $user, Project $project)
    {
        $exists = $user->projects()->where('project_id', $project->id)->exists();
        if ($exists)
            return;
        if (!$project->isActive())
            throw new DomainException("Project not active");
        $user->projects()->attach($project->id); 
    }

    /**
     * logs timesheet for a user.
     * throws DomainException if the user hasn't joined the project
     * throws DomainException if the project is not active for the date
     */
    public static function logTimesheet(User $user, Project $project, $task_name, $date, $hours)
    {
        $exists = $user->projects()->where('project_id', $project->id)->exists();
        if (!$exists)
            throw new DomainException("The user is not in the project");
        if (!$project->isActive($date))
            throw new DomainException("Project not active");
        $timesheet = Timesheet::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'task_name' => $task_name,
            'date' => $date,
            'hours' => $hours,
        ]);
        return $timesheet;
    }
}
