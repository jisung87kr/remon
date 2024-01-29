<?php

namespace App\Enums\User;

enum MetaEnum: string
{
    case SELFINTRODUCTION = 'self_introduction';
    case INTERESTS = 'interests';
    case LOCATION = 'location';
    case CAMERATYPE = 'camera_type';
    case IS_FACE_VISIBLE = 'is_face_visible';
    case HAS_SHARED_BLOG = 'has_shared_blog';
    case TOP_SIZE = 'top_size';
    case BOTTOM_SIZE = 'bottom_size';
    case SHOES_SIZE = 'shoeze_size';
    case HEIGHT = 'height';
    case SKIN_TYPE = 'skin_type';
    case IS_MARRIED = 'is_married';
    case HAS_CHILDREN = 'has_children';
    case JOB = 'job';
    case HAS_PET = 'has_pet';

    public function label(): string
    {
        return match ($this) {
            MetaEnum::SELFINTRODUCTION => '자기소개',
            MetaEnum::INTERESTS => '관심사',
            MetaEnum::LOCATION => '주활동 지역',
            MetaEnum::CAMERATYPE => '사용 카메라 종류',
            MetaEnum::IS_FACE_VISIBLE => '얼굴 노출 가능 여부',
            MetaEnum::HAS_SHARED_BLOG => '공동 블로그 운영 여부',
            MetaEnum::TOP_SIZE => '상의 사이즈',
            MetaEnum::BOTTOM_SIZE => '하의 사이즈',
            MetaEnum::SHOES_SIZE => '신발 사이즈',
            MetaEnum::HEIGHT => '키',
            MetaEnum::SKIN_TYPE => '피부 타입',
            MetaEnum::IS_MARRIED => '결혼 여부',
            MetaEnum::HAS_CHILDREN => '자녀 유무',
            MetaEnum::JOB => '작업',
            MetaEnum::HAS_PET => '반려동물 여부',
        };
    }
}
