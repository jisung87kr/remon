<?php

namespace App\Exports;

use App\Models\CampaignApplication;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CampaignApplicationExport implements FromQuery, WithHeadings
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
        return [];
    }
}
