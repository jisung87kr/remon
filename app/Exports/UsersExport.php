<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings
{
    use Exportable;

    public $filter;

    public function __construct(array $filter)
    {
        $this->filter = $filter;
    }

    public function query(){
        return User::query()->filter($this->filter);
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'nick_name',
            'email',
            'email_verified_at',
            'phone',
            'phone_verified_t',
            'sex',
            'status',
            'birthdate',
            'two_factor_confirmed_at',
            'current_team_id',
            'profile_photo_path',
            'level',
            'agree_email',
            'agree_sms',
            'agree_push',
            'point',
            'agree_privacy',
            'created_at',
            'updated_at',
            'deleted_at',
            'profile_photo_url',
            'favorite_campaign_ids',
        ];
    }
}
