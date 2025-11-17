<?php

namespace App\Models;

use App\Enums\User\WithdrawalStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointWithdrawalRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => WithdrawalStatusEnum::class,
        'processed_at' => 'datetime',
    ];

    /**
     * 사용자 관계
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 처리한 관리자 관계
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Scope: 대기 중인 요청
     */
    public function scopePending(Builder $query)
    {
        return $query->where('status', WithdrawalStatusEnum::PENDING);
    }

    /**
     * Scope: 승인된 요청
     */
    public function scopeApproved(Builder $query)
    {
        return $query->where('status', WithdrawalStatusEnum::APPROVED);
    }

    /**
     * Scope: 거절된 요청
     */
    public function scopeRejected(Builder $query)
    {
        return $query->where('status', WithdrawalStatusEnum::REJECTED);
    }

    /**
     * Scope: 완료된 요청
     */
    public function scopeCompleted(Builder $query)
    {
        return $query->where('status', WithdrawalStatusEnum::COMPLETED);
    }

    /**
     * 필터링 스코프
     */
    public function scopeFilter(Builder $query, array $filter)
    {
        $query->when($filter['status'] ?? false, function($query, $status){
            $query->where('status', $status);
        });

        $query->when($filter['user_id'] ?? false, function($query, $userId){
            $query->where('user_id', $userId);
        });

        $query->when($filter['date_from'] ?? false, function($query, $dateFrom){
            $query->whereDate('created_at', '>=', $dateFrom);
        });

        $query->when($filter['date_to'] ?? false, function($query, $dateTo){
            $query->whereDate('created_at', '<=', $dateTo);
        });
    }
}
