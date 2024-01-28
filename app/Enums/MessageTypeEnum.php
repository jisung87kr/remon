<?php
namespace App\Enums;

enum MessageTypeEnum:string
{
    case Email = 'email';
    case SMS = 'sms';
    case PUSH = 'push';
    case KAKAO_ALIMTALK = 'kakao_alimtalk';

    public function label()
    {
        return match($this){
            MessageTypeEnum::Email => '이메일',
            MessageTypeEnum::SMS => '문자',
            MessageTypeEnum::PUSH => '푸시',
            MessageTypeEnum::KAKAO_ALIMTALK => '카카오 알림톡',
        };
    }
}
