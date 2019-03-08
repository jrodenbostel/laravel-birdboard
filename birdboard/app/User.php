<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function projects()
    {
        //adding 'owner_id to the end of this overrides the default foreign key name 'user_id's
        //return $this->hasMany(Project::class, 'owner_id')->orderByDesc();
        return $this->hasMany(Project::class, 'owner_id')->latest('updated_at');
    }
}
