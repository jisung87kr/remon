<?php

namespace App\Models;

use App\Enums\Campaign\ImageType;
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
    protected $with = ['locations', 'options'];

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function type()
    {
        return $this->belongsTo(CampaignType::class, 'campaign_type_id', 'id');
    }

    public function missionOptions()
    {
        return $this->belongsToMany(MissionOption::class, 'campaign_mission_option', 'campaign_id', 'mission_option_id')->withPivot('id');
    }

    public function locations()
    {
        $categoryModel = new Category();
        $categoryIds = $categoryModel->getChildIds(11);

        return $this->morphToMany(Category::class, 'categoryable')
            ->whereIn('category_id', $categoryIds)
            ->from('categories');
    }

    public function media()
    {
        return $this->hasMany(CampaignMedia::class)->orderBy('media');
    }

    public function options()
    {
        $categoryModel = new Category();
        $categoryIds = $categoryModel->getChildIds(63);

        return $this->morphToMany(Category::class, 'categoryable')
            ->whereIn('category_id', $categoryIds)
            ->from('categories');
    }

    public function campaginMissionOptions()
    {
        return $this->hasMany(CampaignMissionOption::class);
    }

    public function keywords()
    {
        $keywordMissionId = Mission::where('name', '키워드')->first()->options->pluck('id')->toArray();
        return $this->hasMany(CampaignMissionOption::class)->whereIn('mission_option_id', $keywordMissionId);
    }

    public function links()
    {
        $keywordMissionId = Mission::where('name', '링크삽입')->first()->options->pluck('id')->toArray();
        return $this->hasMany(CampaignMissionOption::class)->whereIn('mission_option_id', $keywordMissionId);
    }

    public function thumbnails()
    {
        return $this->hasMany(CampaignImage::class)->where('type', ImageType::THUMBNAIL)->orderBy('order_seq')->get();
    }

    public function detailimages()
    {
        return $this->hasMany(CampaignImage::class)->where('type', ImageType::DETAIL)->orderBy('order_seq')->get();
    }

    public function images()
    {
        return $this->hasMany(CampaignImage::class)->orderBy('order_seq');
    }
}
