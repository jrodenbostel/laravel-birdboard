<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    //helper method for redirects
    public function path()
    {
        //concatenation
        //return '/projects/' . $this->id;

        //interpolation
        return "/projects/{$this->id}";
    }

    public function owner()
    {

        return $this->belongsTo(User::class);
    }
}
