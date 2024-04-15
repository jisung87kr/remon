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

    public function applicationValues()
    {
        return $this->hasMany(CampaignApplicationValue::class, 'campaign_application_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeFilter(Builder $query, array $filter)
    {
        $query->when($filter['status'] ?? false, function($query, $status){
            $query->where('status', $status);
        });
    }
}
