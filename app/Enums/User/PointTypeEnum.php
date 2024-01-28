<?php
namespace App\Enums\User;

enum PointTypeEnum: string {
    case INCREMENT = 'increment';
    case DECREMENT = 'decrement';

    public function label(){
        return match($this){
            PointTypeEnum::INCREMENT => '추가',
            PointTypeEnum::DECREMENT => '차감',
        };
    }
}
