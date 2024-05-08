<?php
namespace App\Enums\Campaign;


enum StatusEnum: string{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case UNPUBLISHED = 'unpublished';
    case ARCHIVED = 'archived';

    public function isActive(): bool {
        return $this !== StatusEnum::ARCHIVED;
    }

    public function label(){
        return match ($this){
            StatusEnum::DRAFT => '작성중',
            StatusEnum::PUBLISHED => '공개',
            StatusEnum::UNPUBLISHED => '미공개',
            StatusEnum::ARCHIVED => '아카이브됨',
        };
    }
}
