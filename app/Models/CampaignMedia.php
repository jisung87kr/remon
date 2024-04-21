<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignMedia extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function contents()
    {
        return $this->hasMany(CampaignMediaContent::class, 'campaigns_media_id', 'id');
    }

    public function contentsByUser()
    {
        return $this->hasMany(CampaignMediaContent::class, 'campaigns_media_id', 'id')->where('user_id', auth()->user()->id)->orderBy('id', 'desc');
    }
}
