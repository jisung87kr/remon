<?php
namespace App\Enums;

enum MessageNameEnum:string
{
    case AD = 'ad';
    case ACCOUNT = 'account';
    case CAMPAIGN = 'campaign';

    public function label()
    {
        return match($this){
            MessageNameEnum::AD => '광고',
            MessageNameEnum::ACCOUNT => '계정',
            MessageNameEnum::CAMPAIGN => '캠페인',
        };
    }
}
