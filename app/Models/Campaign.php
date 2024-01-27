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
        'applicant_start_at' => 'datetime',
        'applicant_end_at' => 'datetime',
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

    public function type()
    {
        return $this->belongsTo(CampaignType::class, 'campaign_type_id', 'id');
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
        return $this->hasMany(CampaignMeta::class)->where("meta_key", Meta::MEDIA)->from('campaign_metas');
    }

    public function titleKeyword()
    {
        return $this->hasMany(CampaignMeta::class)->where("meta_key", Meta::TITLE_KEYWORD)->from('campaign_metas');
    }

    public function contentKeyword()
    {
        return $this->hasMany(CampaignMeta::class)->where("meta_key", Meta::CONTENT_KEYWORD)->from('campaign_metas');
    }

    public function links()
    {
        return $this->hasMany(CampaignMeta::class)->where("meta_key", Meta::LINK)->from('campaign_metas');
    }

    public function metas()
    {
        return $this->hasMany(CampaignMeta::class);
    }
}
