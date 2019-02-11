@extends('layouts.app')

@section('content')
    <h3>Create a Project</h3>
    <form method="POST" action="/projects">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="textHelp" placeholder="Enter title">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" rows="5" id="description" name="description" ></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/projects" class="btn">Cancel</a>
    </form>
@endsection