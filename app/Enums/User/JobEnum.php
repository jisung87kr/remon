<?php
namespace App\Enums\User;

enum JobEnum: string {
    const STUDENT = '학생';
    const EMPLOYEE = '직장인';
    const HOMEMAKER = '주부';
    const SELF_EMPLOYED = '자영업';
    const OTHER = '기타';
}
