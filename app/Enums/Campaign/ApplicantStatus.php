<?php
namespace App\Enums\Campaign;

enum ApplicantStatus: string
{
    case APPLIED = 'applied';
    case APPROVED = 'approved';
    case REJECT = 'reject';
    case PENDING = 'pending';

    public function label(): string
    {
        return match ($this){
            ApplicantStatus::APPLIED => '신청됨',
            ApplicantStatus::APPROVED => '승인됨',
            ApplicantStatus::REJECT => '거절됨',
            ApplicantStatus::PENDING => '대기중',
        };
    }
}
