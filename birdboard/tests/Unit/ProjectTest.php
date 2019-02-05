<?php

namespace Tests\Unit;

use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    /** @test */
    public function it_has_a_path() {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function it_has_an_owner() {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }
}
