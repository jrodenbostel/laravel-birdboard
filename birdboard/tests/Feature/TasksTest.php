<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_project_has_tasks()
    {
        //turn off default exception handling
        $this->withoutExceptionHandling();

        $this->signIn();
        $sentence = $this->faker->sentence();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => $sentence]);

        $this->get($project->path())->assertSee($sentence);
    }

    /** @test */
    public function a_task_owner_can_complete_a_task()
    {
        $this->withoutExceptionHandling();

        $sentence = $this->faker->sentence();
        $attributes = ['body' => $sentence, 'isComplete' => true];

        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $task = factory('App\Task')->create(['project_id' => $project->id]);

        $this->patch($project->path().$task->path(), $attributes)->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'isComplete' => 1, 'body' => $sentence]);
    }

    /** @test */
    public function any_user_cannot_complete_any_task()
    {
        $sentence = $this->faker->sentence();
        $attributes = ['body' => $sentence, 'isComplete' => true];

        $this->signIn();

        $project = factory('App\Project')->create();
        $task = factory('App\Task')->create(['project_id' => $project->id]);

        $this->patch($project->path().$task->path(), $attributes)->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id, 'isComplete' => 1, 'body' => $sentence]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => ''])->assertSessionHasErrors('body');
    }

    /** @test */
    public function only_the_owner_can_add_tasks_to_projects()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $sentence = $this->faker->sentence();

        $this->post($project->path() . '/tasks', ['body' => $sentence])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => $sentence]);
    }
}
