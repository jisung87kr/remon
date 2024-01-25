<?php
namespace App\Enums\Campaign;


enum Status: string{
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
    case ARCHIVED = 'ARCHIVED';

    public function isActive(): bool {
        return $this !== Status::ARCHIVED;
    }
}
