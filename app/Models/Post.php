<?php

namespace App\Models;

use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => PostStatusEnum::class,
    ];


    public function board()
    {
        return $this->belongsTo(Post::class);
    }

    public function comments()
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }


    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }
}
