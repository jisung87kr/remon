<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\Campaign\Media;
use App\Enums\Campaign\Meta;

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
    protected $with = ['options', 'locations', 'missions', 'media'];

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function options()
    {
        $categoryModel = new Category();
        $categoryIds = $categoryModel->getChildIds(75);

        return $this->morphToMany(Category::class, 'categoryable')
            ->whereIn('category_id', $categoryIds)
            ->from('categories');
    }

    public function locations()
    {
        $categoryModel = new Category();
        $categoryIds = $categoryModel->getChildIds(11);

        return $this->morphToMany(Category::class, 'categoryable')
            ->whereIn('category_id', $categoryIds)
            ->from('categories');
    }

    public function missions()
    {
        $categoryModel = new Category();
        $categoryIds = $categoryModel->getChildIds(63);

        return $this->morphToMany(Category::class, 'categoryable')
            ->whereIn('category_id', $categoryIds)
            ->from('categories');
    }

    public function media()
    {
        return $this->hasMany(CampaginMeta::class)->where("meta_key", Meta::MEDIA)->from('campagin_metas');
    }

    public function metas()
    {
        return $this->hasMany(CampaginMeta::class);
    }
}
