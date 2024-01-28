<?php
namespace App\Enums\Campaign;

enum ImageType:string{
    case THUMBNAIL = 'THUMBNAIL';
    case DETAIL = 'DETAIL';

    public function label(): string
    {
        return match($this) {
            ImageType::THUMBNAIL => '썸네일',
            ImageType::DETAIL => '디테일',
        };
    }
}
