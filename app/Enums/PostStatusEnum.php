<?php

namespace App\Enums;

enum PostStatusEnum: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case UNPUBLISHED = 'unpublished';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => '초안',
            self::PUBLISHED => '공개됨',
            self::UNPUBLISHED => '공개되지 않음',
            self::ARCHIVED => '아카이브',
        };
    }
}
