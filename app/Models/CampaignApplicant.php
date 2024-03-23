<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;

//class CampaignApplicant extends Pivot
class CampaignApplicant extends Model
{
    use HasFactory;

    protected $table = 'campaign_applicants';
    protected $guarded = [];

    public function applicationValues()
    {
        return $this->hasMany(CampaignApplicationValue::class, 'campaign_applicant_id', 'id');
    }

    public function hasApplication()
    {

    }

    public function scopeFilter(Builder $query, array $filter)
    {
        $query->when($filter['status'] ?? false, function($query, $status){
            $query->where('status', $status);
        });
    }
}
