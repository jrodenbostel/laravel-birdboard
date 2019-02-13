<div class="card" style="height: 200px;">
    <a href="{{ $project->path() }}" class="  no-underline text-black"><h3
                class="font-normal txt-xl mb-4 -ml-5 mb-3 py-4 border-l-4 border-blue-light pl-4">{{ $project->title }}</h3>
    </a>
    <div class="text-grey">{{ str_limit($project->description, 100) }}</div>
</div>