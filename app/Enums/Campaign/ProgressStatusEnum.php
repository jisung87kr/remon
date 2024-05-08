<?php
namespace App\Enums\Campaign;
enum ProgressStatusEnum: string{
    case READY = 'ready';
    case Applying = 'applying';
    case Approving = 'approving';
    case IN_PROGRESS = 'in_progress';
    case RESULT = 'result';
    case COMPLETED = 'completed';
    case UNKONWON = 'unknown';

    public function label(){
        return match ($this){
            ProgressStatusEnum::READY => '준비중',
            ProgressStatusEnum::Applying => '신청중',
            ProgressStatusEnum::Approving => '선정중',
            ProgressStatusEnum::IN_PROGRESS => '진행중',
            ProgressStatusEnum::RESULT => '결과발표중',
            ProgressStatusEnum::COMPLETED => '완료됨',
            ProgressStatusEnum::UNKONWON => '알수없음',
        };
    }
}
