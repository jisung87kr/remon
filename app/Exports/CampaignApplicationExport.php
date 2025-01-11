<?php

namespace App\Exports;

use App\Models\CampaignApplication;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CampaignApplicationExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public $filter;

    public function __construct(array $filter)
    {
        $this->filter = $filter;
    }
    /**
    * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return CampaignApplication::query()->filter($this->filter);
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            '#',
            '신청일',
            '신청상태',
            '캠페인',
            '신청자 이름',
            '신청자 생년월일',
            '신청자 성별',
            '신청자 연락처',
            '초상권 활용 동의',
            '캠페인 유의사항, 개인정보 및 콘텐츠 제3자 제공, 저작물이용 동의',
            '받는 사람',
            '받는 사람 연락처',
            '우편번호',
            '주소',
            '주소 상세',
            '미디어',
        ];
    }

    public function map($application): array
    {
        return [
            $application->id,
            $application->created_at,
            $application->status,
            $application->campaign->title,
            $application->name,
            $application->birthdate,
            $application->sex,
            $application->phone,
            $application->portrait_right_consent,
            $application->base_right_consent,
            $application->shipping_name,
            $application->shipping_phone,
            $application->address_postcode,
            $application->address,
            $application->address_detail.' '.$application->address_extra,
            $application->user->media->pluck('url')->implode(', '),
        ];
    }
}
