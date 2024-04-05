<?php
namespace App\Enums;

enum AdminRoleEnum: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case SALES_TEAM = 'sales_team';
    case ACCOUNTING_TEAM = 'accounting_team';

    public function label()
    {
        return match($this){
            AdminRoleEnum::SUPER_ADMIN => '최고 관리자',
            AdminRoleEnum::ADMIN => '관리자',
            AdminRoleEnum::SALES_TEAM => '영업팀',
            AdminRoleEnum::ACCOUNTING_TEAM => '회계팀',
        };
    }
}
