<?php
namespace App\Enums\Campaign;

enum ApplicationCategoryEnum: string
{
    case OPTION = 'option';
    case INFORMATION = 'information';
    case SHIPPING_ADDRESS = 'shipping_address';

    public function label()
    {
        return match($this){
            ApplicationCategoryEnum::OPTION => '옵션',
            ApplicationCategoryEnum::INFORMATION => '정보',
            ApplicationCategoryEnum::SHIPPING_ADDRESS => '배송주소',
        };
    }
}
