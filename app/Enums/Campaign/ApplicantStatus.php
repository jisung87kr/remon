<?php
namespace App\Enums\Campaign;

enum ApplicantStatus: string
{
    case APPLIED = 'applied';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PENDING = 'pending';
    case POSTED = 'posted';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this){
            ApplicantStatus::APPLIED => '신청됨',
            ApplicantStatus::APPROVED => '승인됨',
            ApplicantStatus::REJECTED => '거절됨',
            ApplicantStatus::PENDING => '대기중',
            ApplicantStatus::POSTED => '등록됨',
            ApplicantStatus::COMPLETED => '완료됨',
        };
    }
}
