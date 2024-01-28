<?php
namespace App\Enums\Campaign;

enum ImageTypeEnum:string{
    case THUMBNAIL = 'THUMBNAIL';
    case DETAIL = 'DETAIL';

    public function label(): string
    {
        return match($this) {
            ImageTypeEnum::THUMBNAIL => '썸네일',
            ImageTypeEnum::DETAIL => '디테일',
        };
    }
}
