<?php

namespace Modules\Post\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
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
    public function create()
    {
        $project = Project::find(3);
        return view('post::create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = Post::create([
            'project_id' => $request->project_id,
            'user_id'    => auth()->id(),
            'content'    => $request->content,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('posts');

                PostAttachment::create([
                    'post_id' => $post->id,
                    'type' => $file->getClientOriginalExtension() === 'pdf' ? 'pdf' : 'image',
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

        return back();
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
    public function edit($id)
    {
        return view('post::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
