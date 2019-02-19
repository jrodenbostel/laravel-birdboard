<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{
    public function create(Project $project)
    {

        $attributes = request()->validate([
            'body' => 'required',
        ]);

        //updated from above to read a little easier
        $this->isOwner($project);

        $project->tasks()->create($attributes);

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        $this->isOwner($project);

        $task->update([
            'body' => request('body'),
            'isComplete' => request()->has('isComplete')
        ]);

        return redirect($project->path());
    }

    /**
     * @param Project $project
     */
    public function isOwner(Project $project): void
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }
    }
}
