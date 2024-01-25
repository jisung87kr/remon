<?php
namespace App\Enums\Campaign;
enum Meta: string {
    case MEDIA = 'MEDIA';
    case TITLE_KEYWORD = 'TITLE_KEYWORD';
    case CONTENT_KEYWORD = 'CONTENT_KEYWORD';
    case LINK = 'LINK';

    public function label(): string
    {
        return match($this) {
            Meta::MEDIA => '미디어',
            Meta::TITLE_KEYWORD => '제목 키워드',
            Meta::CONTENT_KEYWORD => '본문 키워드',
            Meta::LINK => '링크',
        };
    }
}
