<?php
namespace App\Enums\User;
enum HeightEnum: string {
    case HEIGHT_140_150 = '140~150';
    case HEIGHT_151_160 = '151~160';
    case HEIGHT_161_170 = '161~170';
    case HEIGHT_171_180 = '171~180';
    case HEIGHT_181_190 = '181~190';
    case HEIGHT_191_200 = '191~200';
    case HEIGHT_over_200 = '200 이상';
}
