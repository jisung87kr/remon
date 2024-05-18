<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mediaContent()
    {
        return $this->belongsTo(CampaignMediaContent::class);
    }
}
