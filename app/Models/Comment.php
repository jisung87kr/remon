<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['user', 'children'];
    protected $appends = ['can_update'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function canUpdate(): Attribute
    {
        return Attribute::make(get: function($value, $attributes){
            return request()->user() && Gate::allows('update', $this);
        });
    }
}
