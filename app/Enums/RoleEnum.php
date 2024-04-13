<?php
namespace App\Enums;

enum RoleEnum: string
{
    case GENERAL_USER = 'general_user';
    case BUSINESS_USER = 'business_user';
    case VENDOR_USER = 'vendor_user';

    public function label()
    {
        return match($this){
            RoleEnum::GENERAL_USER => '일반 회원',
            RoleEnum::BUSINESS_USER => '비즈니스 회원',
            RoleEnum::VENDOR_USER => '벤더 회원',
        };
    }
}
