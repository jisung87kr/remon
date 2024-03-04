<?php
namespace App\Enums;

enum BoolEnum: int{
    case FALSE = 0;
    case TRUE = 1;

    public function label()
    {
        return match($this){
            BoolEnum::FALSE => '아니요',
            BoolEnum::TRUE => '예',
        };
    }
}
