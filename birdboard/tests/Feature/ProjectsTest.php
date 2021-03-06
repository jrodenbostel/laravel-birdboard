<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_control_projects()
    {
        $project = factory('App\Project')->create();

        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function authenticated_users_cannot_view_other_projects()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function authenticated_users_cannot_update_other_projects()
    {
        $notes = $this->faker->paragraph();

        $attributes = ['notes' => $notes];

        $this->signIn();
        $project = factory('App\Project')->create();

        $this->patch($project->path(), $attributes)->assertStatus(403);
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $attributes = ['title' => $this->faker->sentence(), 'description' => $this->faker->paragraph(), 'notes' => $this->faker->paragraph()];

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $response = $this->post('/projects', $attributes);
        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $notes = $this->faker->paragraph();

        $attributes = ['notes' => $notes];

        $this->signIn();
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(), $attributes)->assertStatus(302);
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'notes' => $notes]);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee(str_limit($project->description, 100));
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());

        //factory->create creates an object as an array of key value pairs
        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
