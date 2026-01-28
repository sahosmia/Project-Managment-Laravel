<?php

namespace Modules\Post\Tests\Feature;

use App\Models\User;
use App\Models\Project;
use Modules\Post\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostEditDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $project;
    protected $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->project = Project::create([
            'title' => 'Test Project',
            'created_by' => $this->user->id
        ]);
        $this->post = Post::create([
            'project_id' => $this->project->id,
            'user_id' => $this->user->id,
            'content' => 'Original content'
        ]);
    }

    public function test_user_can_access_edit_page()
    {
        $response = $this->actingAs($this->user)->get(route('posts.edit', $this->post));
        $response->assertStatus(200);
        $response->assertSee('Original content');
    }

    public function test_user_can_update_post()
    {
        $response = $this->actingAs($this->user)->put(route('posts.update', $this->post), [
            'content' => 'Updated content'
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'id' => $this->post->id,
            'content' => 'Updated content'
        ]);
    }

    public function test_user_can_delete_post()
    {
        $response = $this->actingAs($this->user)->delete(route('posts.destroy', $this->post));

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', [
            'id' => $this->post->id
        ]);
    }

    public function test_other_user_cannot_edit_post()
    {
        $otherUser = User::factory()->create();
        $response = $this->actingAs($otherUser)->get(route('posts.edit', $this->post));
        $response->assertStatus(403);
    }

    public function test_other_user_cannot_update_post()
    {
        $otherUser = User::factory()->create();
        $response = $this->actingAs($otherUser)->put(route('posts.update', $this->post), [
            'content' => 'Malicious update'
        ]);
        $response->assertStatus(403);
    }

    public function test_other_user_cannot_delete_post()
    {
        $otherUser = User::factory()->create();
        $response = $this->actingAs($otherUser)->delete(route('posts.destroy', $this->post));
        $response->assertStatus(403);
    }
}
