<?php
namespace App\Enums\User;

enum SkinTypeEnum: string{
    case OILY = 'oily';
    case DRY = 'dry';
    case NORMAL = 'normal';
    case COMBINATION = 'combination';
    case SENSITIVE = 'sensitive';
    case ACNE_PRONE = 'acne_prone';
    case ATOPIC = 'atopic';

    public function label(): string
    {
        return match($this){
            SkinTypeEnum::OILY => '지성',
            SkinTypeEnum::DRY => '건성',
            SkinTypeEnum::NORMAL => '중성',
            SkinTypeEnum::COMBINATION => '복합성',
            SkinTypeEnum::SENSITIVE => '민감성',
            SkinTypeEnum::ACNE_PRONE => '트러블',
            SkinTypeEnum::ATOPIC => '아토피',
        };
    }
}
