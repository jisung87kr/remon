<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaignApplicant extends Pivot
{
    use HasFactory;

    protected $table = 'campaign_applicants';

    public function applicationValues()
    {
        return $this->hasMany(CampaignApplicationValue::class);
    }
}
