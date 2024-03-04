<?php
namespace App\Enums\Campaign;
enum MediaEnum: string
{
    case NAVER_BLOG = 'naver_blog';
    case INSTAGRAM = 'instagram';
    case YOUTUBE = 'youtube';

    public function label(): string
    {
        return match($this) {
            MediaEnum::NAVER_BLOG => '블로그',
            MediaEnum::INSTAGRAM => '인스타그램',
            MediaEnum::YOUTUBE => '유튜브',
        };
    }
}
