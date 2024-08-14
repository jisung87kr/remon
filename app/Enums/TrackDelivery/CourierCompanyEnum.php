<?php
namespace App\Enums\TrackDelivery;
enum CourierCompanyEnum: string
{
    case ACTCORE_OCEAN_INBOUND = 'kr.actcore.ocean-inbound';
    case CJLOGISTICS = 'kr.cjlogistics';
    case COUPANGLS = 'kr.coupangls';
    case CUPOST = 'kr.cupost';
    case CHUNILPS = 'kr.chunilps';
    case CVSNET = 'kr.cvsnet';
    case CWAY = 'kr.cway';
    case DAESIN = 'kr.daesin';
    case EPANTOS = 'kr.epantos';
    case EPOST = 'kr.epost';
    case EPOST_EMS = 'kr.epost.ems';
    case GOODSTOULUCK = 'kr.goodstoluck';
    case HOMEPICK = 'kr.homepick';
    case HANJIN = 'kr.hanjin';
    case HONAMLOGIS = 'kr.honamlogis';
    case KDEXP = 'kr.kdexp';
    case KUNYOUNG = 'kr.kunyoung';
    case LOGEN = 'kr.logen';
    case LOTTE = 'kr.lotte';
    case LOTTE_GLOBAL = 'kr.lotte.global';
    case SWGEXP_EPOST = 'kr.swgexp.epost';
    case SWGEXP_CJLOGISTICS = 'kr.swgexp.cjlogistics';
    case TODAYPICKUP = 'kr.todaypickup';
    case ILYANGLOGIS = 'kr.ilyanglogis';
    case HANIPS = 'kr.hanjips';
    case HDEXP = 'kr.hdexp';

    public function label(): string
    {
        return match ($this) {
            CourierCompanyEnum::ACTCORE_OCEAN_INBOUND => '에이스터미널코어물류 (해상수입)',
            CourierCompanyEnum::CJLOGISTICS => 'CJ대한통운',
            CourierCompanyEnum::COUPANGLS => '쿠팡 로지스틱스 서비스',
            CourierCompanyEnum::CUPOST => 'CU 편의점택배',
            CourierCompanyEnum::CHUNILPS => '천일택배',
            CourierCompanyEnum::CVSNET => 'GS Postbox',
            CourierCompanyEnum::CWAY => 'CWAY (Woori Express)',
            CourierCompanyEnum::DAESIN => '대신택배',
            CourierCompanyEnum::EPANTOS => 'LX 판토스',
            CourierCompanyEnum::EPOST => '우체국택배',
            CourierCompanyEnum::EPOST_EMS => '우체국택배 국제우편(EMS)',
            CourierCompanyEnum::GOODSTOULUCK => '굿투럭',
            CourierCompanyEnum::HOMEPICK => '홈픽',
            CourierCompanyEnum::HANJIN => '한진택배',
            CourierCompanyEnum::HONAMLOGIS => '한서호남택배',
            CourierCompanyEnum::KDEXP => '경동택배',
            CourierCompanyEnum::KUNYOUNG => '건영택배',
            CourierCompanyEnum::LOGEN => '로젠택배',
            CourierCompanyEnum::LOTTE => '롯데택배',
            CourierCompanyEnum::LOTTE_GLOBAL => '롯데택배 (국제택배)',
            CourierCompanyEnum::SWGEXP_EPOST => '성원글로벌카고 (우체국)',
            CourierCompanyEnum::SWGEXP_CJLOGISTICS => '성원글로벌카고 (대한통운)',
            CourierCompanyEnum::TODAYPICKUP => '오늘의픽업',
            CourierCompanyEnum::ILYANGLOGIS => '일양로지스',
            CourierCompanyEnum::HANIPS => 'HPL (한의사랑택배)',
            CourierCompanyEnum::HDEXP => '합동택배',
        };
    }
}
