<?php
namespace App\Enums\User;

enum JobEnum: string {
    case STUDENT = 'student';
    case EMPLOYEE = 'employee';
    case HOMEMAKER = 'homeworker';
    case SELF_EMPLOYED = 'self_employed';
    case OTHER = 'other';

    public function label()
    {
        return match($this){
            JobEnum::STUDENT => 'student',
            JobEnum::EMPLOYEE => 'employee',
            JobEnum::HOMEMAKER => 'homeworker',
            JobEnum::SELF_EMPLOYED => 'self_employed',
            JobEnum::OTHER => 'other',
        };
    }
}
