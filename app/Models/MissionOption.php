<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionOption extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function campaign()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_mission_option', 'mission_option_id', 'campaign_id')->withPivot('id');;
    }

    public function campaignMissionOptions()
    {
        return $this->hasMany(CampaignMissionOption::class, 'mission_option_id', 'id');
    }

    public function missionName(): Attribute
    {
        return Attribute::make(
            get: function (){
                return $this->option_value ? "{$this->option_name}({$this->option_value})" : $this->option_name;
            },
        );
    }
}
