<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Support\Facades\Log;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        //$projects = auth()->user()->projects()->orderBy('updated_at', 'desc')->get();
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function create()
    {

        return view('projects.create');
    }

    //this method uses implicit route/model binding
    public function show(Project $project)
    {
        $this->authorize('show', $project);

        return view('projects.show', compact('project'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'nullable'
        ]);

        $project = auth()->user()->projects()->create($attributes);

        Log::info($project);

        return redirect($project->path());
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project->update([
            'notes' => request('notes'),
        ]);

        return redirect($project->path());
    }
}
