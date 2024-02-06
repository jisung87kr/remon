<?php
namespace App\Enums\User;

enum CameraTypeEnum: string {
    case DSLR = 'dslr';
    case FILM = 'film';
    case SMARTPHONE = 'smartphone';
    case ETC = 'etc';

    public function label()
    {
        return match($this){
            CameraTypeEnum::DSLR => 'DSLR 카메라',
            CameraTypeEnum::FILM => '필름 카메라',
            CameraTypeEnum::SMARTPHONE => '스마트폰',
            CameraTypeEnum::ETC => '기타'
        };
    }
}
