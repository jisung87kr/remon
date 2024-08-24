<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;

//class CampaignApplication extends Pivot
class CampaignApplication extends Model
{
    use HasFactory;

//    protected $table = 'campaign_applications';
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope('base', function(Builder $builder){
            $query = "
                SELECT 
                    *,
                    YEAR(CURDATE()) - YEAR(birthdate) - (RIGHT(CURDATE(), 5) < RIGHT(birthdate, 5)) AS age,
                    floor((YEAR(CURDATE()) - YEAR(birthdate) - (RIGHT(CURDATE(), 5) < RIGHT(birthdate, 5))) / 10) * 10 AS age_group
                FROM campaign_applications AS CA
            ";
            $builder->fromSub($query, "campaign_applications");
        });
    }

    public function applicationValues()
    {
        return $this->hasMany(CampaignApplicationValue::class, 'campaign_application_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mediaContents(){
        return $this->hasMany(CampaignMediaContent::class);
    }

    public function parcel()
    {
        return $this->hasOne(CampaignApplicationParcel::class);
    }

    public function scopeFilter(Builder $query, array $filter)
    {
        $query->when($filter['status'] ?? false, function($query, $status){
            $query->where('status', $status);
        });
    }

    public function scopeActiveCount(Builder $query)
    {
        return $query->selectRaw('count(*)')
            ->whereIn('campaign_applications.status', ['applied', 'posted', 'completed']);
    }
}
