<?php

namespace Modules\Post\Tests\Feature;

use App\Models\User;
use App\Models\Project;
use Modules\Post\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostCreateTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $project;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->project = Project::create([
            'title' => 'Test Project',
            'created_by' => $this->user->id
        ]);
    }

    public function test_user_can_access_create_page()
    {
        $response = $this->actingAs($this->user)->get(route('posts.create', ['project_id' => $this->project->id]));
        $response->assertStatus(200);
        $response->assertSee($this->project->title);
    }

    public function test_user_can_create_post_with_content()
    {
        $response = $this->actingAs($this->user)->post(route('posts.store'), [
            'project_id' => $this->project->id,
            'content' => 'New post content'
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'content' => 'New post content',
            'project_id' => $this->project->id,
            'user_id' => $this->user->id
        ]);
    }

    public function test_user_can_create_post_with_attachments()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->actingAs($this->user)->post(route('posts.store'), [
            'project_id' => $this->project->id,
            'attachments' => [$file]
        ]);

        $response->assertRedirect(route('posts.index'));

        $post = Post::first();
        $this->assertCount(1, $post->attachments);
        $this->assertEquals('image', $post->attachments->first()->type);
        Storage::disk('public')->assertExists($post->attachments->first()->file_path);
    }

    public function test_user_can_create_post_with_link()
    {
        $response = $this->actingAs($this->user)->post(route('posts.store'), [
            'project_id' => $this->project->id,
            'link_url' => 'https://google.com'
        ]);

        $response->assertRedirect(route('posts.index'));

        $post = Post::first();
        $this->assertCount(1, $post->attachments);
        $this->assertEquals('link', $post->attachments->first()->type);
        $this->assertEquals('https://google.com', $post->attachments->first()->link_url);
    }

    public function test_post_creation_requires_at_least_one_field()
    {
        $response = $this->actingAs($this->user)->post(route('posts.store'), [
            'project_id' => $this->project->id,
            'content' => ''
        ]);

        $response->assertSessionHasErrors(['content']);
    }
}
