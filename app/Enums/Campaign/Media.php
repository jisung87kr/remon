<?php
namespace App\Enums\Campaign;
enum Media: string
{
    case NAVER_BLOG = 'NAVER_BLOG';
    case INSTAGRAM = 'INSTAGRAM';
    case YOUTUBE = 'YOUTUBE';

    public function label(): string
    {
        return match($this) {
            Media::NAVER_BLOG => '블로그',
            Media::INSTAGRAM => '인스타그램',
            Media::YOUTUBE => '유튜브',
        };
    }
}
