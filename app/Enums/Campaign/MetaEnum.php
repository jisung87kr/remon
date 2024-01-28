<?php
namespace App\Enums\Campaign;
enum MetaEnum: string {
    case MEDIA = 'MEDIA';
    case TITLE_KEYWORD = 'TITLE_KEYWORD';
    case CONTENT_KEYWORD = 'CONTENT_KEYWORD';
    case LINK = 'LINK';

    public function label(): string
    {
        return match($this) {
            MetaEnum::MEDIA => '미디어',
            MetaEnum::TITLE_KEYWORD => '제목 키워드',
            MetaEnum::CONTENT_KEYWORD => '본문 키워드',
            MetaEnum::LINK => '링크',
        };
    }
}
