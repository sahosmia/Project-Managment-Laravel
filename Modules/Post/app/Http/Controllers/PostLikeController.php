<?php

namespace Modules\Post\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Post\Models\PostLike;

class PostLikeController extends Controller
{




    public function toggle(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'type' => 'required|in:like,love,dislike'
        ]);

        $userId = auth()->id();
        $postId = $request->post_id;
        $type = $request->type;

        $existing = PostLike::where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();

        $currentType = null;

        if ($existing) {
            if ($existing->type === $type) {
                // Same reaction clicked: Un-react
                $existing->delete();
                $currentType = null;
            } else {
                // Different reaction clicked: Switch
                $existing->update(['type' => $type]);
                $currentType = $type;
            }
        } else {
            // No reaction: Create new
            PostLike::create([
                'post_id' => $postId,
                'user_id' => $userId,
                'type' => $type
            ]);
            $currentType = $type;
        }

        // Get updated counts for all reaction types
        $counts = PostLike::where('post_id', $postId)
            ->selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        // Ensure all types are present in the response for consistency
        $allTypes = ['like', 'love', 'dislike'];
        $finalCounts = [];
        foreach ($allTypes as $t) {
            $finalCounts[$t] = $counts[$t] ?? 0;
        }

        return response()->json([
            'success' => true,
            'current_type' => $currentType,
            'counts' => $finalCounts
        ]);
    }
}
