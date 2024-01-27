<?php

namespace App\Models;

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
        return $this->belongsToMany(Campaign::class, 'campaign_mission_option', 'mission_option_id', 'campaign_id');
    }
}
