<?php

namespace Modules\Post\Tests\Feature;

use App\Models\User;
use App\Models\Project;
use Modules\Post\Models\Post;
use Modules\Post\Models\PostLike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostReactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_react_to_post()
    {
        $user = User::factory()->create();
        $project = Project::create([
            'title' => 'Test Project',
            'created_by' => $user->id
        ]);
        $post = Post::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'content' => 'Test content'
        ]);

        $response = $this->actingAs($user)->post(route('post.like'), [
            'post_id' => $post->id,
            'type' => 'like'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'current_type' => 'like',
            'counts' => ['like' => 1, 'love' => 0, 'dislike' => 0]
        ]);

        $this->assertDatabaseHas('post_likes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'type' => 'like'
        ]);
    }

    public function test_user_can_switch_reaction()
    {
        $user = User::factory()->create();
        $project = Project::create([
            'title' => 'Test Project',
            'created_by' => $user->id
        ]);
        $post = Post::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'content' => 'Test content'
        ]);

        PostLike::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'type' => 'like'
        ]);

        $response = $this->actingAs($user)->post(route('post.like'), [
            'post_id' => $post->id,
            'type' => 'love'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'current_type' => 'love',
            'counts' => ['like' => 0, 'love' => 1, 'dislike' => 0]
        ]);

        $this->assertDatabaseHas('post_likes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'type' => 'love'
        ]);
        $this->assertDatabaseMissing('post_likes', ['type' => 'like']);
    }

    public function test_user_can_unreact()
    {
        $user = User::factory()->create();
        $project = Project::create([
            'title' => 'Test Project',
            'created_by' => $user->id
        ]);
        $post = Post::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'content' => 'Test content'
        ]);

        PostLike::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'type' => 'like'
        ]);

        $response = $this->actingAs($user)->post(route('post.like'), [
            'post_id' => $post->id,
            'type' => 'like'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'current_type' => null,
            'counts' => ['like' => 0, 'love' => 0, 'dislike' => 0]
        ]);

        $this->assertDatabaseMissing('post_likes', [
            'post_id' => $post->id,
            'user_id' => $user->id
        ]);
    }
}
