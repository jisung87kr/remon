<?php
namespace App\Enums;

enum MessageStatusEnum:string
{
    case SUCCEED = 'succeed';
    case FAILED = 'failed';
    case WAITING = 'waiting';

    public function label()
    {
        return match($this){
            MessageStatusEnum::SUCCEED => '성공',
            MessageStatusEnum::FAILED => '실패',
            MessageStatusEnum::WAITING => '대기',
        };
    }
}
