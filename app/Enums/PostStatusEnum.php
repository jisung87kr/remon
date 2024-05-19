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
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::UNPUBLISHED => 'Unpublished',
            self::ARCHIVED => 'Archived',
        };
    }
}
