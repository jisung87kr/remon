<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function options()
    {
        return $this->hasMany(MissionOption::class);
    }
}
