<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignMissionOptionItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campaginMissionOption()
    {
        return $this->belongsTo(CampaignMissionOption::class, 'campaign_mission_option_id', 'id');
    }
}
