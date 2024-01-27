<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaignMissionOption extends Pivot
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(CampaignMissionOptionItem::class, 'campaign_mission_option_id', 'id');
    }
}
