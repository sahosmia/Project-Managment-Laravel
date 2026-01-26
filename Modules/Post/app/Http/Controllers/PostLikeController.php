<?php

namespace Modules\Post\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Post\Models\PostLike;

class PostLikeController extends Controller
{




    public function toggle(Request $request)
    {
        $like = PostLike::updateOrCreate(
            [
                'post_id' => $request->post_id,
                'user_id' => auth()->id(),
            ],
            [
                'type' => $request->type
            ]
        );

        return response()->json(['success' => true]);
    }
}
