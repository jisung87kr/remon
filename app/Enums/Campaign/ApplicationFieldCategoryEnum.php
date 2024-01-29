<?php
namespace App\Enums\Campaign;

enum ApplicationFieldCategoryEnum: string
{
    case OPTION = 'option';
    case INFORMATION = 'information';
    case SHIPPING_ADDRESS = 'shipping_address';

    public function label()
    {
        return match($this){
            ApplicationFieldCategoryEnum::OPTION => '옵션',
            ApplicationFieldCategoryEnum::INFORMATION => '정보',
            ApplicationFieldCategoryEnum::SHIPPING_ADDRESS => '배송주소',
        };
    }
}
