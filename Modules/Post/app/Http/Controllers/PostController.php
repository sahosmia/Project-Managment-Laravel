<?php

namespace Modules\Post\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Post\Models\Post;
use Modules\Post\Models\PostAttachment;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with([
            'user',
            'project',
            'likes',
            'comments.user'
        ])
            ->orderByDesc('is_pinned')
            ->latest()
            ->get();
        return view('post::index', compact(['posts']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $project = Project::find($request->project_id) ?? Project::first();

        if (!$project) {
            return redirect()->route('posts.index')->with('error', 'No project found to post in.');
        }

        return view('post::create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'content' => 'required_without_all:attachments,link_url',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'link_url' => 'nullable|url',
        ]);

        $post = Post::create([
            'project_id' => $request->project_id,
            'user_id'    => auth()->id(),
            'content'    => $request->content,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('posts', 'public');

                PostAttachment::create([
                    'post_id' => $post->id,
                    'type' => str_contains($file->getMimeType(), 'pdf') ? 'pdf' : 'image',
                    'file_path' => $path
                ]);
            }
        }

        if ($request->link_url) {
            PostAttachment::create([
                'post_id' => $post->id,
                'type' => 'link',
                'link_url' => $request->link_url
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('post::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);
        $post->load('project', 'attachments');
        return view('post::edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);

        $request->validate([
            'content' => 'required_without_all:attachments,link_url',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'link_url' => 'nullable|url',
        ]);

        $post->update([
            'content' => $request->content,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('posts', 'public');

                PostAttachment::create([
                    'post_id' => $post->id,
                    'type' => str_contains($file->getMimeType(), 'pdf') ? 'pdf' : 'image',
                    'file_path' => $path
                ]);
            }
        }

        if ($request->link_url) {
            PostAttachment::create([
                'post_id' => $post->id,
                'type' => 'link',
                'link_url' => $request->link_url
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);

        foreach ($post->attachments as $attachment) {
            if ($attachment->file_path) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
