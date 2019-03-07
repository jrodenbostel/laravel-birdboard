<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    //updates 'updated_at' on Project if a related Task is updated
    protected $touches = ['project'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/tasks/{$this->id}";
    }
}
