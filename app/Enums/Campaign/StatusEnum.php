<?php
namespace App\Enums\Campaign;


enum StatusEnum: string{
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
    case ARCHIVED = 'ARCHIVED';

    public function isActive(): bool {
        return $this !== StatusEnum::ARCHIVED;
    }
}
