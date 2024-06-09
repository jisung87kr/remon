<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignApplicationParcel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function CampaignApplication()
    {
        return $this->belongsTo(CampaignApplication::class);
    }
}
