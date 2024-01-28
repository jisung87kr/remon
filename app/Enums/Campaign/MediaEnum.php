<?php
namespace App\Enums\Campaign;
enum MediaEnum: string
{
    case NAVER_BLOG = 'NAVER_BLOG';
    case INSTAGRAM = 'INSTAGRAM';
    case YOUTUBE = 'YOUTUBE';

    public function label(): string
    {
        return match($this) {
            MediaEnum::NAVER_BLOG => '블로그',
            MediaEnum::INSTAGRAM => '인스타그램',
            MediaEnum::YOUTUBE => '유튜브',
        };
    }
}
