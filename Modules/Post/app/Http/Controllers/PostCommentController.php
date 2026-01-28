<?php

namespace Modules\Post\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Post\Models\PostComment;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('post::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:1000',
        ]);

        $comment = PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'parent_id' => $request->parent_id // 🔥 important

        ]);

        return response()->json([
            'status' => true,
            'total_count' => PostComment::where('post_id', $request->post_id)->count(),
            'data' => [
                'id' => $comment->id,
                'user' => auth()->user()->name,
                'comment' => $comment->comment,
                'time' => $comment->created_at->diffForHumans(),
                'is_owner' => true,
            ]
        ]);
    }

    public function update(Request $request, PostComment $comment)
    {
        abort_if($comment->user_id !== auth()->id(), 403);

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment->update([
            'comment' => $request->comment
        ]);

        return response()->json([
            'status' => true,
            'comment' => $comment->comment
        ]);
    }

    public function destroy(PostComment $comment)
    {
        abort_if($comment->user_id !== auth()->id(), 403);

        $postId = $comment->post_id;
        $comment->replies()->delete();
        $comment->delete();

        return response()->json([
            'status' => true,
            'total_count' => PostComment::where('post_id', $postId)->count()
        ]);

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
}
