<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignApplicationValue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campaginApplication()
    {
        return $this->belongsTo(CampaignApplication::class, 'campaign_application_id', 'id');
    }

    public function campaginApplicationField()
    {
        return $this->belongsTo(CampaignApplicationField::class);
    }
}
