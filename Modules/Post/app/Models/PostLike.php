<?php

namespace Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Post\Database\Factories\PostLikeFactory;

class PostLike extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'type'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
