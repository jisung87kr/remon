<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('logCount', function(Builder $query){
            $subQuery = "
            SELECT 
                *
                , @enrolled_count := (SELECT COUNT(*) FROM link_logs WHERE link_id = links.id) AS log_count
            FROM links
            ";
            $query->fromSub($subQuery, 'links');
        });
    }

    public function logs()
    {
        return $this->hasMany(LinkLog::class, 'link_id', 'id');
    }

    public function redirectUrl(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => request()->getSchemeAndHttpHost()."/redirects/{$attributes['id']}",
        );
    }
}
