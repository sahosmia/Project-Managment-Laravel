<?php

namespace Modules\Post\Models;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Post\Database\Factories\PostFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'user_id', 'content', 'is_pinned'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function attachments()
    {
        return $this->hasMany(PostAttachment::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class)->whereNull('parent_id');
    }
}
