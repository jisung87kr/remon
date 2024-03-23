<?php

namespace App\Models;

use App\Enums\Campaign\ApplicationFieldEnum;
use App\Enums\Campaign\ImageTypeEnum;
use App\Enums\Campaign\MissionOptionEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\Campaign\MediaEnum;
use App\Enums\Campaign\MetaEnum;

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
    protected $with = ['locationCategories', 'options'];

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

    public function applicants()
    {
        return $this->belongsToMany(User::class, 'campaign_applicants', 'campaign_id', 'user_id');
    }

    public function applicationFields()
    {
        return $this->hasMany(CampaignApplicationField::class);
    }

    public function customOptions()
    {
        return $this->hasMany(CampaignApplicationField::class)->where('name', ApplicationFieldEnum::CUSTOM_OPTION);
    }

    public function productCategories()
    {
        $categoryModel = new Category();
        $categoryIds = $categoryModel->getChildIds(1);

        return $this->morphToMany(Category::class, 'categoryable')
            ->whereIn('category_id', $categoryIds)
            ->from('categories');
    }

    public function typeCategories()
    {
        $categoryModel = new Category();
        $categoryIds = $categoryModel->getChildIds(54);

        return $this->morphToMany(Category::class, 'categoryable')
            ->whereIn('category_id', $categoryIds)
            ->from('categories');
    }

    public function locationCategories()
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
        $categoryIds = $categoryModel->getChildIds(62);

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

    public function titleKeyword()
    {
        return $this->hasMany(CampaignMissionOption::class)->where('mission_option_id', MissionOptionEnum::TITLE_KEYWORD_ID_OF_MISSION_OPTION->value);
    }

    public function contentKeyword()
    {
        return $this->hasMany(CampaignMissionOption::class)->where('mission_option_id', MissionOptionEnum::CONTENT_KEYWORD_ID_OF_MISSION_OPTION->value);
    }

    public function link()
    {
        return $this->hasMany(CampaignMissionOption::class)->where('mission_option_id', MissionOptionEnum::LINK_ID_OF_MISSION_OPTION->value);
    }

    public function hashtag()
    {
        return $this->hasMany(CampaignMissionOption::class)->where('mission_option_id', MissionOptionEnum::HASHTAG_ID_OF_MISSION_OPTION->value);
    }

    public function links()
    {
        $keywordMissionId = Mission::where('name', '링크삽입')->first()->options->pluck('id')->toArray();
        return $this->hasMany(CampaignMissionOption::class)->whereIn('mission_option_id', $keywordMissionId);
    }

    public function thumbnails()
    {
        return $this->hasMany(CampaignImage::class)->where('type', ImageTypeEnum::THUMBNAIL)->orderBy('order_seq');
    }

    public function detailimages()
    {
        return $this->hasMany(CampaignImage::class)->where('type', ImageTypeEnum::DETAIL)->orderBy('order_seq');
    }

    public function images()
    {
        return $this->hasMany(CampaignImage::class)->orderBy('order_seq');
    }

    public function campaignType()
    {
        return $this->belongsTo(CampaignType::class);
    }

    public function scopeFilter(Builder $query, $filter)
    {
        $query->when($filter['title'] ?? false, function($query, $id){
            $query->where('title', $id);
        });

        $query->when($filter['keyword'] ?? false, function($query, $keyword){
            $query->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('product_name', 'LIKE', "%{$keyword}%");
        });

        $query->when($filter['campaign_type'] ?? false, function($query, $campaignType){
            $query->whereHas('campaignType', function($query) use ($campaignType){
                $query->where('name', $campaignType);
            });
        });

        $query->when($filter['type'] ?? false, function($query, $type){
            $query->whereHas('typeCategories', function($query) use ($type){
                $query->whereIn('categories.id', function ($query) use ($type) {
                    $query->select('id')
                        ->from('categories')
                        ->whereIn('name', $type)
                        ->orWhereIn('parent_id', function($query) use ($type) {
                            $query->select('id')
                                ->from('categories')
                                ->whereIn('name', $type);
                        });
                });
            });
        });

        $query->when($filter['product'] ?? false, function($query, $product){
            $query->whereHas('productCategories', function($query) use ($product){
                $query->whereIn('categories.id', function ($query) use ($product) {
                    $query->select('id')
                        ->from('categories')
                        ->whereIn('name', $product)
                        ->orWhereIn('parent_id', function($query) use ($product) {
                            $query->select('id')
                                ->from('categories')
                                ->whereIn('name', $product);
                        });
                });
            });
        });

        $query->when($filter['location'] ?? false, function($query, $location){
            $query->whereHas('locationCategories', function($query) use ($location){
                $query->whereIn('categories.id', function ($query) use ($location) {
                    if($location == '전체'){
                        $categoryModel = new Category();
                        $locationIds = $categoryModel->getChildIds(11);
                        $query->select('id')
                            ->from('categories')
                            ->whereIn('id', $locationIds);
                    } else {
                        $query->select('id')
                            ->from('categories')
                            ->where('name', $location)
                            ->orWhereIn('parent_id', function($query) use ($location) {
                                $query->select('id')
                                    ->from('categories')
                                    ->where('name', $location);
                            });
                    }
                });
            });
        });

        $query->when($filter['media'] ?? false, function($query, $media){
            $query->whereHas('media', function($mediaQuery) use ($media){
                $mediaQuery->where('media', $media);
            });
        });

        $query->when($filter['applicant_status'] ?? false, function($query, $status){
            $query->whereHas('applicants', function($query) use ($status){
                $query->where('campaign_applicants.status', $status);
            });
        });
    }

    public function scopeSort(Builder $query, $sort)
    {
        $query->when($sort ?? false, function($query, $sort){
            if($sort == 'latest'){
                $query->orderBy('id', 'desc');
            } elseif($sort == 'popular'){
                $query->orderBy('id', 'desc');
            } elseif($sort == 'deadline'){
                $query->orderBy('applicant_end_at', 'asc');
            }
        });
    }

    public function useShipping() : Attribute
    {
        return Attribute::make(
            get: function(){
                return $this->type->id === 2;
            },
        );
    }

    public function hasPortraitRightConsent() : Attribute
    {
        //$campaign->applicationFields->pluck('name')->toArray()
        return Attribute::make(
            get: function(){
                return in_array(ApplicationFieldEnum::IS_FACE_VISIBLE->value, $this->applicationFields->pluck('name')->toArray());
            },
        );
    }
}
