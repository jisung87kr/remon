<?php
namespace App\Enums\User;
enum HeightEnum: string {
    case HEIGHT_140_150 = 'height_140_150';
    case HEIGHT_151_160 = 'height_151_160';
    case HEIGHT_161_170 = 'height_161_170';
    case HEIGHT_171_180 = 'height_171_180';
    case HEIGHT_181_190 = 'height_181_190';
    case HEIGHT_191_200 = 'height_191_200';
    case HEIGHT_over_200 = 'height_over_200';

    public function label()
    {
        return match ($this){
            HeightEnum::HEIGHT_140_150 => '140~150',
            HeightEnum::HEIGHT_151_160 => '151~160',
            HeightEnum::HEIGHT_161_170 => '161~170',
            HeightEnum::HEIGHT_171_180 => '171~180',
            HeightEnum::HEIGHT_181_190 => '181~190',
            HeightEnum::HEIGHT_191_200 => '191~200',
            HeightEnum::HEIGHT_over_200 => '200 이상',
        };
    }
}
