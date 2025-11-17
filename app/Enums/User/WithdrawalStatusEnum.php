<?php
namespace App\Enums\User;

enum WithdrawalStatusEnum: string {
    case PENDING = 'pending';        // 대기
    case APPROVED = 'approved';      // 승인
    case REJECTED = 'rejected';      // 거절
    case COMPLETED = 'completed';    // 완료

    public function label(){
        return match($this){
            WithdrawalStatusEnum::PENDING => '대기',
            WithdrawalStatusEnum::APPROVED => '승인',
            WithdrawalStatusEnum::REJECTED => '거절',
            WithdrawalStatusEnum::COMPLETED => '완료',
        };
    }

    public function color(){
        return match($this){
            WithdrawalStatusEnum::PENDING => 'yellow',
            WithdrawalStatusEnum::APPROVED => 'blue',
            WithdrawalStatusEnum::REJECTED => 'red',
            WithdrawalStatusEnum::COMPLETED => 'green',
        };
    }
}
