<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignApplicationValue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campaginApplicant()
    {
        return $this->belongsTo(CampaignApplicant::class, 'campaign_applicant_id', 'id');
    }

    public function campaginApplicationField()
    {
        return $this->belongsTo(CampaignApplicationField::class);
    }
}
