<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index() {
        $projects = auth()->user()->projects;
    
        return view('projects.index', compact('projects'));
    }

    //this method uses implicit route/model binding
    public function show(Project $project) {
        //$project = Project::findOrFail(request('project'));

        // if(auth()->id() !== $project->owner_id) {
        //     abort(403);
        // }

        //updated from above to read a little easier
        if(auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        return view('projects.show', compact('project'));
    }

    public function store() {
        $attributes = request()->validate([
            'title' => 'required', 
            'description' => 'required'
            ]);

        //this retrieves the current logged in user and always associates the project with that user.
        //the validation code above just makes sure it's not null (which would let someone post
        //any user id)
        //$attributes['owner_id'] = auth()->id();

        auth()->user()->projects()->create($attributes);

        return redirect('/projects');
    }
}
