<?php

namespace Modules\Post\Tests\Feature;

use App\Models\User;
use App\Models\Project;
use Modules\Post\Models\Post;
use Modules\Post\Models\PostComment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCommentTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $project = Project::create([
            'title' => 'Test Project',
            'created_by' => $this->user->id
        ]);
        $this->post = Post::create([
            'project_id' => $project->id,
            'user_id' => $this->user->id,
            'content' => 'Test content'
        ]);
    }

    public function test_user_can_add_comment()
    {
        $response = $this->actingAs($this->user)->post(route('comments.store'), [
            'post_id' => $this->post->id,
            'comment' => 'This is a comment'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'total_count' => 1
        ]);

        $this->assertDatabaseHas('post_comments', [
            'post_id' => $this->post->id,
            'comment' => 'This is a comment'
        ]);
    }

    public function test_user_can_add_reply()
    {
        $comment = PostComment::create([
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'comment' => 'Parent comment'
        ]);

        $response = $this->actingAs($this->user)->post(route('comments.store'), [
            'post_id' => $this->post->id,
            'parent_id' => $comment->id,
            'comment' => 'This is a reply'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'total_count' => 2
        ]);

        $this->assertDatabaseHas('post_comments', [
            'post_id' => $this->post->id,
            'parent_id' => $comment->id,
            'comment' => 'This is a reply'
        ]);
    }

    public function test_user_can_delete_comment_and_replies()
    {
        $comment = PostComment::create([
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'comment' => 'Parent comment'
        ]);

        PostComment::create([
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'parent_id' => $comment->id,
            'comment' => 'Reply 1'
        ]);

        $this->assertEquals(2, PostComment::where('post_id', $this->post->id)->count());

        $response = $this->actingAs($this->user)->delete("/comments/{$comment->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'total_count' => 0
        ]);

        $this->assertDatabaseMissing('post_comments', ['post_id' => $this->post->id]);
    }
}
