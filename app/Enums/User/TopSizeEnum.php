<?php
namespace App\Enums\User;

enum TopSizeEnum: string {
    case S = 's';
    case M = 'm';
    case L = 'l';
    case XL = 'xl';
    case XXL = 'xxl';
    case XXXL = 'xxxl';

    public function label()
    {
        return match($this){
            TopSizeEnum::S => '44,90',
            TopSizeEnum::M => '55,95',
            TopSizeEnum::L => '66,100',
            TopSizeEnum::XL => '77,105',
            TopSizeEnum::XXL => '88,110',
            TopSizeEnum::XXXL => '99,115',
        };
    }
}
