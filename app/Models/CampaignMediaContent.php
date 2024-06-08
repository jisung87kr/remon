<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignMediaContent extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsTo(CampaignMedia::class, 'campaign_media_id', 'id');
    }

    public function bannerLogs()
    {
        return $this->hasMany(BannerLog::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function campaignMedia()
    {
        return $this->belongsTo(CampaignMedia::class, 'campaign_media_id', 'id');
    }
}
