<?php
namespace App\Enums\Campaign;
use App\Enums\User\BottomSizeEnum;
use App\Enums\User\CameraTypeEnum;
use App\Enums\User\HeightEnum;
use App\Enums\User\ShoesSizeEnum;
use App\Enums\User\SkinTypeEnum;
use App\Enums\User\TopSizeEnum;

enum ApplicationFieldEnum:string
{
    case APPLY_REASON = 'apply_reason';
    case CUSTOM_OPTION = 'custom_option';
    case CAMERA_TYPE = 'camera_type';
    case SHIPPING_ADDRESS_POSTCODE = 'shipping_address_postcode';
    case SHIPPING_ADDRESS = 'shipping_address';
    case SHIPPING_ADDRESS_DETAIL = 'shipping_address_detail';
    case RECIPIENT_NAME = 'recipient_name';
    case RECIPIENT_PHONE = 'recipient_phone';
    case IS_FACE_VISIBLE = 'is_face_visible';
    case HAS_SHARED_BLOG = 'has_shared_blog';
    case TOP_SIZE = 'top_size';
    case BOTTOM_SIZE = 'bottom_size';
    case SHOES_SIZE = 'shoes_size';
    case HEIGHT = 'height';
    case SKIN_TYPE = 'skin_type';
    case IS_MARRIED = 'is_married';
    case HAS_CHILDREN = 'has_children';
    case JOB = 'job';
    case HAS_PET = 'has_pet';

    public function label()
    {
        return match($this){
            ApplicationFieldEnum::APPLY_REASON => [
                'category' => ApplicationFieldCategoryEnum::OPTION->name,
                'label' => '지원사유',
                'type' => 'text',
                'name' => ApplicationFieldEnum::APPLY_REASON->name,
            ],
            ApplicationFieldEnum::CUSTOM_OPTION => [
                'category' => ApplicationFieldCategoryEnum::OPTION->name,
                'label' => '사용자 정의 옵션',
                'type' => 'text',
                'name' => ApplicationFieldEnum::CUSTOM_OPTION->name,
            ],
            ApplicationFieldEnum::CAMERA_TYPE => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '어떤 카메라를 사용하시나요?',
                'type' => 'selectbox',
                'name' => ApplicationFieldEnum::CAMERA_TYPE->name,
                'option' => CameraTypeEnum::cases(),
            ],
            ApplicationFieldEnum::SHIPPING_ADDRESS_POSTCODE => [
                'category' => ApplicationFieldCategoryEnum::SHIPPING_ADDRESS->name,
                'label' => '배송지 우편번호',
                'type' => 'text',
                'name' => ApplicationFieldEnum::SHIPPING_ADDRESS_POSTCODE->name,
            ],
            ApplicationFieldEnum::SHIPPING_ADDRESS => [
                'category' => ApplicationFieldCategoryEnum::SHIPPING_ADDRESS->name,
                'label' => '배송지 주소',
                'type' => 'text',
                'name' => ApplicationFieldEnum::SHIPPING_ADDRESS->name,
            ],
            ApplicationFieldEnum::SHIPPING_ADDRESS_DETAIL => [
                'category' => ApplicationFieldCategoryEnum::SHIPPING_ADDRESS->name,
                'label' => '배송지 상세',
                'type' => 'text',
                'name' => ApplicationFieldEnum::SHIPPING_ADDRESS_DETAIL->name,
            ],
            ApplicationFieldEnum::RECIPIENT_NAME => [
                'category' => ApplicationFieldCategoryEnum::SHIPPING_ADDRESS->name,
                'label' => '받는분',
                'type' => 'text',
                'name' => ApplicationFieldEnum::RECIPIENT_NAME->name,
            ],
            ApplicationFieldEnum::IS_FACE_VISIBLE => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '얼굴 노출 가능 여부',
                'type' => 'radio',
                'name' => ApplicationFieldEnum::IS_FACE_VISIBLE->name,
            ],
            ApplicationFieldEnum::HAS_SHARED_BLOG => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '공동으로 운영하는 블로그가 있으신가요?',
                'type' => 'radio',
                'name' => ApplicationFieldEnum::HAS_SHARED_BLOG->name,
            ],
            ApplicationFieldEnum::TOP_SIZE => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '상의 사이즈',
                'type' => 'selectbox',
                'name' => ApplicationFieldEnum::TOP_SIZE->name,
                'option' => TopSizeEnum::cases(),
            ],
            ApplicationFieldEnum::BOTTOM_SIZE => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '하의 사이즈',
                'type' => 'selectbox',
                'name' => ApplicationFieldEnum::BOTTOM_SIZE->name,
                'option' => BottomSizeEnum::cases(),
            ],
            ApplicationFieldEnum::SHOES_SIZE => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '신발 사이즈',
                'type' => 'selectbox',
                'name' => ApplicationFieldEnum::SHOES_SIZE->name,
                'option' => ShoesSizeEnum::cases(),
            ],
            ApplicationFieldEnum::HEIGHT => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '키',
                'type' => 'selectbox',
                'name' => ApplicationFieldEnum::HEIGHT->name,
                'option' => HeightEnum::cases(),
            ],
            ApplicationFieldEnum::SKIN_TYPE => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '피부타입',
                'type' => 'selectbox',
                'name' => ApplicationFieldEnum::SKIN_TYPE->name,
                'option' => SkinTypeEnum::cases(),
            ],
            ApplicationFieldEnum::IS_MARRIED => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '결혼여부',
                'type' => 'radio',
                'name' => ApplicationFieldEnum::IS_MARRIED->name,
            ],
            ApplicationFieldEnum::HAS_CHILDREN => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '자녀가 있나요?',
                'type' => 'radio',
                'name' => ApplicationFieldEnum::HAS_CHILDREN->name,
            ],
            ApplicationFieldEnum::JOB => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '직업',
                'type' => 'text',
                'name' => ApplicationFieldEnum::JOB->name,
            ],
            ApplicationFieldEnum::HAS_PET => [
                'category' => ApplicationFieldCategoryEnum::INFORMATION->name,
                'label' => '반려동물을 키우시나요?',
                'type' => 'radio',
                'name' => ApplicationFieldEnum::HAS_PET->name,
            ],
        };
    }

    static public function toArray($type='name')
    {
        return array_map(function($item) use ($type){
            if($type === 'value'){
                return $item->value;
            } elseif($type === 'label'){
                return $item->label();
            }

            return $item->name;

        }, self::cases());
    }

    static public function findByName($name){
        foreach (self::cases() as $index => $case) {
            if($case->name === $name){
                return $case;
            }
        }
    }
}
