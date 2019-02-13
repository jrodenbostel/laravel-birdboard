<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function it_has_an_owner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function a_project_has_tasks()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf(Collection::class, $project->tasks);
    }
}
