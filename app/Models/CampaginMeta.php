<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaginMeta extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
