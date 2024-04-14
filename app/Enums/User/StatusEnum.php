<?php
namespace App\Enums\User;

enum StatusEnum:string
{
    case ACTIVE = 'active';
    case DEACTIVE = 'deactive';
    case SLEEP = 'sleep';
    case LEAVE = 'leave';

    public function label()
    {
        return match($this){
            StatusEnum::ACTIVE => '활성',
            StatusEnum::DEACTIVE => '비활성',
            StatusEnum::SLEEP => '휴면',
            StatusEnum::LEAVE => '탈퇴',
        };
    }
}
