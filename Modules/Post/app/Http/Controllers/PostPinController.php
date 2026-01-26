<?php

namespace Modules\Post\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostPinController extends Controller
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
public function toggle(Post $post)
    {
        abort_unless(auth()->user()->role === 'supervisor', 403);

        $post->update([
            'is_pinned' => !$post->is_pinned
        ]);

        return back();
    }
}
