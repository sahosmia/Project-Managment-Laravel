<?php

namespace Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Post\Database\Factories\PostAttachmentFactory;

class PostAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'type', 'file_path', 'link_url'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
