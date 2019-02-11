@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <h3>{{ $project->title }}</h3>
        </div>
        <div class="col-2">
            <a href="/projects">Back</a>
        </div>
    </div>
    <div>{{ $project->description }}</div>
@endsection