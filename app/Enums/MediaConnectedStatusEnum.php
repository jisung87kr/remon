<?php
namespace App\Enums;
enum MediaConnectedStatusEnum: string
{
    case CONNECTED = 'connected';
    case UNCONNECTED = 'unconnected';

    public function label(): string
    {
        return match($this) {
            MediaConnectedStatusEnum::CONNECTED => '연결됨',
            MediaConnectedStatusEnum::UNCONNECTED => '미연결',
        };
    }
}
