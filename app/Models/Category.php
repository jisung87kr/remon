<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function campaigns()
    {
        return $this->morphedByMany(Campaign::class, 'categoryable');
    }

    public function getChildIds($categoryId)
    {
        // 재귀적인 CTE 쿼리를 생성
        $recursiveQuery = "
        WITH RECURSIVE category_tree AS (
            SELECT id, parent_id
            FROM categories
            WHERE id = $categoryId
            UNION ALL
            SELECT c.id, c.parent_id
            FROM categories c
            JOIN category_tree ct ON c.parent_id = ct.id
        )
        SELECT id FROM category_tree
        ";

        // 원시 SQL 쿼리 실행
        $result = DB::select($recursiveQuery);

        // 결과에서 id 값만 추출
        return array_map(function($row) {
            return $row->id;
        }, $result);
    }

    public function getRouteKey()
    {
        return $this->name;
    }

    public function scopeFilter(Builder $query, $filter)
    {

        $query->when($filter['id'] ?? false, function($query, $id){
            $query->where('id', $id);
        });

        $query->when($filter['name'] ?? false, function($query, $name){
            $query->where('name', $name);
        });
    }
}
