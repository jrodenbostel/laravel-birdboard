<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Project $project)
    {
        return $user->id == $project->owner->id;
    }

    public function update(User $user, Project $project)
    {
        return $user->id == $project->owner->id;
    }

}
