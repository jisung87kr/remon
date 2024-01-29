<?php
namespace App\Enums\Campaign;

enum ApplicationFieldEnum:string
{
    case APPLY_REASON = 'apply_reason';
    case CUSTOM_OPTION = 'custom_option';
    case CAMERA_TYPE = 'camera_type';
    case SHIPPING_ADDRESS_ZIPCODE = 'shipping_address_zipcode';
    case SHIPPING_ADDRESS_FIRST = 'shipping_address_first';
    case SHIPPING_ADDRESS_LAST = 'shipping_address_last';
    case RECIPIENT_NAME = 'recipient_name';
    case RECIPIENT_PHONE = 'recipient_phone';
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

    public function label()
    {
        return match($this){
            ApplicationFieldEnum::APPLY_REASON => '지원사유',
            ApplicationFieldEnum::CUSTOM_OPTION => '사용자 정의 옵션',
            ApplicationFieldEnum::CAMERA_TYPE => '어떤 카메라를 사용하시나요?',
            ApplicationFieldEnum::SHIPPING_ADDRESS_ZIPCODE => '배송지 우편번호',
            ApplicationFieldEnum::SHIPPING_ADDRESS_FIRST => '배송지 주소',
            ApplicationFieldEnum::SHIPPING_ADDRESS_LAST => '배송지 상세',
            ApplicationFieldEnum::RECIPIENT_NAME => '받는분',
            ApplicationFieldEnum::RECIPIENT_PHONE => '받는분 연락처',
            ApplicationFieldEnum::IS_FACE_VISIBLE => '얼굴 노출 가능 여부',
            ApplicationFieldEnum::HAS_SHARED_BLOG => '공동으로 운영하는 블로그가 있으신가요?',
            ApplicationFieldEnum::TOP_SIZE => '상의 사이즈',
            ApplicationFieldEnum::BOTTOM_SIZE => '하의 사이즈',
            ApplicationFieldEnum::SHOES_SIZE => '신발사이즈',
            ApplicationFieldEnum::HEIGHT => '키',
            ApplicationFieldEnum::SKIN_TYPE => '피부타입',
            ApplicationFieldEnum::IS_MARRIED => '결혼 여부',
            ApplicationFieldEnum::HAS_CHILDREN => '자녀가 있나요?',
            ApplicationFieldEnum::JOB => '직업',
            ApplicationFieldEnum::HAS_PET => '반려동물을 키우시나요?',
        };
    }
}
