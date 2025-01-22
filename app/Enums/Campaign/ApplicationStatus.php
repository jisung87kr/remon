<?php
namespace App\Enums\Campaign;

enum ApplicationStatus: string
{
    case APPLIED = 'applied';
    case APPROVED = 'approved';
    case PROCESSING = 'processing';
    case POSTED = 'posted';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
    case REJECTED = 'rejected';
    case PENDING = 'pending';

    public function label(): string
    {
        return match ($this){
            ApplicationStatus::APPLIED => '신청됨',
            ApplicationStatus::APPROVED => '승인됨',
            ApplicationStatus::PROCESSING => '진행중',
            ApplicationStatus::POSTED => '등록됨',
            ApplicationStatus::COMPLETED => '완료됨',
            ApplicationStatus::CANCELED => '취소됨',
            ApplicationStatus::REJECTED => '거절됨',
            ApplicationStatus::PENDING => '대기중',
        };
    }
}
