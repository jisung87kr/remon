<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'application_start_at' => 'datetime',
        'application_end_at' => 'datetime',
        'announcement_at' => 'datetime',
        'registration_start_date_at' => 'datetime',
        'registration_end_date_at' => 'datetime',
        'result_announcement_date_at' => 'datetime',
    ];

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function attributes()
    {
        $subquery = DB::table('categoryables')
            ->select(['id', 'category_id'])
            ->whereColumn('categoryable_id', '=', 'categoryables.categoryable_id')
            ->where('categoryable_type', Campaign::class)
            ->where('category_id', '75');

        return $this->morphToMany(Category::class, 'categoryable')->fromSub($subquery, 'categories');
    }
}
