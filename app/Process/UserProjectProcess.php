<?php

namespace App\Process;

use App\Exceptions\DomainException;
use App\Models\User;
use App\Models\Project;

class UserProjectProcess 
{
    public static function joinProject(User $user, Project $project)
    {
        $exists = $user->projects()->where('project_id', $project->id)->exists();
        if ($exists)
            return;
        if (!$project->isActive())
            throw new DomainException("Project not active");
        $user->projects()->attach($project->id); 
    }
}
