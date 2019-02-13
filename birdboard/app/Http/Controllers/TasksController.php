<?php

namespace App\Http\Controllers;

use App\Project;

class TasksController extends Controller
{
    public function create(Project $project)
    {

        $attributes = request()->validate([
            'body' => 'required',
        ]);

        //updated from above to read a little easier
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        $project->tasks()->create($attributes);

        return redirect($project->path());
    }
}
