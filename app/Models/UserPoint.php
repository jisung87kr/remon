<?php

namespace App\Models;

use App\Enums\User\PointTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => PointTypeEnum::class,
        'expired_at' => 'datetime',
    ];

    /**
     * 사용자 관계
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 캠페인 관계 (선택)
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Scope: 만료되지 않은 포인트 (유효한 포인트)
     */
    public function scopeActive(Builder $query)
    {
        return $query->where(function($query) {
            $query->whereNull('expired_at')
                ->orWhere('expired_at', '>', now());
        });
    }

    /**
     * Scope: 만료된 포인트
     */
    public function scopeExpired(Builder $query)
    {
        return $query->whereNotNull('expired_at')
            ->where('expired_at', '<=', now());
    }

    /**
     * Scope: 적립 포인트만
     */
    public function scopeIncrement(Builder $query)
    {
        return $query->where('type', PointTypeEnum::INCREMENT->value);
    }

    /**
     * Scope: 차감 포인트만
     */
    public function scopeDecrement(Builder $query)
    {
        return $query->where('type', PointTypeEnum::DECREMENT->value);
    }
}
