<?php
namespace App\Enums\User;

enum ShoesSizeEnum: string {
    case SIZE_210 = 'size_210';
    case SIZE_215 = 'size_215';
    case SIZE_220 = 'size_220';
    case SIZE_225 = 'size_225';
    case SIZE_230 = 'size_230';
    case SIZE_235 = 'size_235';
    case SIZE_240 = 'size_240';
    case SIZE_245 = 'size_245';
    case SIZE_250 = 'size_250';
    case SIZE_255 = 'size_255';
    case SIZE_260 = 'size_260';
    case SIZE_265 = 'size_265';
    case SIZE_270 = 'size_270';
    case SIZE_275 = 'size_275';
    case SIZE_280 = 'size_280';
    case SIZE_285 = 'size_285';
    case SIZE_290 = 'size_290';
    case SIZE_295 = 'size_295';
    case SIZE_300 = 'size_300';
    case SIZE_OVER_305 = 'size_over_305';

    public function label()
    {
        return match($this){
            ShoesSizeEnum::SIZE_210 => '210',
            ShoesSizeEnum::SIZE_215 => '215',
            ShoesSizeEnum::SIZE_220 => '220',
            ShoesSizeEnum::SIZE_225 => '225',
            ShoesSizeEnum::SIZE_230 => '230',
            ShoesSizeEnum::SIZE_235 => '235',
            ShoesSizeEnum::SIZE_240 => '240',
            ShoesSizeEnum::SIZE_245 => '245',
            ShoesSizeEnum::SIZE_250 => '250',
            ShoesSizeEnum::SIZE_255 => '255',
            ShoesSizeEnum::SIZE_260 => '260',
            ShoesSizeEnum::SIZE_265 => '265',
            ShoesSizeEnum::SIZE_270 => '270',
            ShoesSizeEnum::SIZE_275 => '275',
            ShoesSizeEnum::SIZE_280 => '280',
            ShoesSizeEnum::SIZE_285 => '285',
            ShoesSizeEnum::SIZE_290 => '290',
            ShoesSizeEnum::SIZE_295 => '295',
            ShoesSizeEnum::SIZE_300 => '300',
            ShoesSizeEnum::SIZE_OVER_305 => '305 이상',
        };
    }
}
