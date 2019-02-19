@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal no-underline hover:underline">My Projects</a> / {{ $project->title }}
            </p>

            <a href="/projects/create" class="button">New Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>

                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{$project->path().$task->path()}}">
                                @method('PATCH')
                                @csrf
                                <input class="w-4/5 {{ $task->isComplete ? 'text-grey' : 'text-normal' }}" type="text" name="body" value="{{ $task->body }}" />
                                <input name="isComplete" type="checkbox" onChange="this.form.submit()" {{ $task->isComplete ? 'checked' : '' }}/>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{$project->path()}} . /tasks" method="POST">
                            @csrf
                            <input name="body" placeholder="Add a new task" class="w-full"/>
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg text-grey px-3 font-normal mb-3">General Notes</h2>

                    <textarea class="card w-full" style="min-height: 200px">{{ $project->description }}</textarea>
                </div>
            </div>

            <div class="lg:w-1/4 px-3 lg:py-8">
                @include ('projects.card')
            </div>
        </div>
    </main>


@endsection