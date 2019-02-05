<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{   
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_create_projects() {
        $attributes = factory('App\Project')->raw();

        $this->post('/projects', $attributes)->assertRedirect('login');
    } 

    /** @test */
    public function guests_cannot_view_projects() {
        factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login');
    } 

    /** @test */
    public function guests_cannot_view_a_single_project() {
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertRedirect('login');
    } 

    /** @test */
    public function authenticated_users_cannot_view_other_projects() {
        $this->be(factory('App\User')->create());

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    } 

    /** @test */
    public function a_user_can_create_a_project()  {        

        //turn off default exception handling
        $this->withoutExceptionHandling();

        $attributes = ['title' => $this->faker->sentence(), 'description' => $this->faker->paragraph()];

        $this->actingAs(factory('App\User')->create());
        
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_view_their_project() {
        $this->be(factory('App\User')->create());

        $this->withoutExceptionHandling();

        //factory->create creates AND persists an object
        //auth()->id() same as auth()->user()->id
        $project = factory('App\Project')->create(['owner_id'=>auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_project_requires_a_title() {
        $this->actingAs(factory('App\User')->create());

        //factory->create creates an object as an array of key value pairs
        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }    

    /** @test */
    public function a_project_requires_a_description() {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    } 
}
