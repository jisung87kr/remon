<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
