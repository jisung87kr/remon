<?php

namespace App\Models;

use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => PostStatusEnum::class,
    ];

    protected $with = ['user'];

    protected static function booted()
    {
        static::addGlobalScope('withCommentsCount', function ($query) {
            $query->withCount('comments');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function board()
    {
        return $this->belongsTo(Post::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function scopePublished(Builder $query)
    {
        $query->where('status', PostStatusEnum::PUBLISHED)->latest();
    }

    public function scopeFilter(Builder $query, $filter)
    {
        $query->when($filter['keyword'] ?? false, function($query, $keyword){
            $query->where(function($query) use ($keyword) {
                $query->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        });
    }
}
