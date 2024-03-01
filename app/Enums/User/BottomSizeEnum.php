<?php
namespace App\Enums\User;

enum BottomSizeEnum: string {
    case XS = 'xs';
    case S = 's';
    case M = 'm';
    case L = 'l';
    case XL = 'xl';
    case XXL = 'xxl';
    case XXXL = 'xxxl';

    public function label()
    {
        return match ($this){
            BottomSizeEnum::XS => '24-25',
            BottomSizeEnum::S => '26-27',
            BottomSizeEnum::M => '28-29',
            BottomSizeEnum::L => '30-31',
            BottomSizeEnum::XL => '32-33',
            BottomSizeEnum::XXL => '34-35',
            BottomSizeEnum::XXXL => '36 이상',
        };
    }
}
