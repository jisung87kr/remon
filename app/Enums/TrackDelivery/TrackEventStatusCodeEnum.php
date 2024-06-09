<?php
namespace App\Enums\TrackDelivery;
enum TrackEventStatusCodeEnum: string
{
    case UNKNOWN = 'unknown';
    case INFORMATION_RECEIVED = 'information_received';
    case AT_PICKUP = 'at_pickup';
    case IN_TRANSIT = 'in_transit';
    case OUT_FOR_DELIVERY = 'out_for_delivery';
    case ATTEMPT_FAIL = 'attempt_fail';
    case DELIVERED = 'delivered';
    case AVAILABLE_FOR_PICKUP = 'available_for_pickup';
    case EXCEPTION = 'exception';

    public function label()
    {
        return match ($this){
            TrackEventStatusCodeEnum::UNKNOWN => '알 수 없음',
            TrackEventStatusCodeEnum::INFORMATION_RECEIVED => '정보 수신됨',
            TrackEventStatusCodeEnum::AT_PICKUP => '픽업 장소에 있음',
            TrackEventStatusCodeEnum::IN_TRANSIT => '배송 중',
            TrackEventStatusCodeEnum::OUT_FOR_DELIVERY => '배송 출발',
            TrackEventStatusCodeEnum::ATTEMPT_FAIL => '배송 시도 실패',
            TrackEventStatusCodeEnum::DELIVERED => '배송 완료',
            TrackEventStatusCodeEnum::AVAILABLE_FOR_PICKUP => '픽업 가능',
            TrackEventStatusCodeEnum::EXCEPTION => '예외 발생',
        };
    }
}
