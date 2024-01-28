<?php
namespace App\Enums\User;

enum StatusEnum:string
{
    case ACTIVE = 'active';
    case DEACTIVE = 'deactive';

    public function label()
    {
        return match($this){
            StatusEnum::ACTIVE => '활성',
            StatusEnum::DEACTIVE => '비활성',
        };
    }
}
