<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;

class TasksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function create(Project $project)
    {
        $this->authorize('update', $project);

        $attributes = request()->validate([
            'body' => 'required',
        ]);

        //updated from above to read a little easier
        //$this->authorize('create', $project);

        $project->tasks()->create($attributes);

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task);

        request()->validate([
            'body' => 'required',
        ]);

        $task->update([
            'body' => request('body'),
            'isComplete' => request()->has('isComplete')
        ]);

        return redirect($project->path());
    }

}
