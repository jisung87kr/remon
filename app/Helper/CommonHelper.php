<?php
namespace App\Helper;

use App\Models\CampaignApplicationField;
use App\Models\CampaignApplicationValue;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class CommonHelper{
    static public function getRandomEnumCase($cases)
    {
        $count = count($cases) - 1;
        return $cases[rand(0, $count)];
    }

    static public function makeCasesWithLabel($cases)
    {
        $result = [];
        foreach ($cases as $index => $case) {
            $item = [
                'name' => $case->name,
                'value' => $case->value,
                'label' => $case->label(),
            ];
            $result[] = $item;
        }

        return $result;
    }

    static public function makeCustomOptionByModel($customOptions)
    {
        $result = [];
        foreach ($customOptions as $index => $customOption) {
            $result[] = [
              'id' => $customOption['id'],
              'name' => $customOption['label'],
              'value' => $customOption['option'],
            ];
        }

        return $result;
    }

    static public function toggleArrayQueryString($key, $value)
    {
        $currentMedia = request()->input($key, []);

        if (in_array($value, $currentMedia)) {
            $currentMedia = array_diff($currentMedia, [$value]);
        } else {
            $currentMedia[] = $value;
        }
        return $currentMedia;
    }

    static public function findApplicationFieldValue($values, CampaignApplicationField $field){
        foreach ($values as $index => $value) {
            if($value->campaign_application_field_id === $field->id){
                return $value;
            }
        }
        return null;
    }

    static public function makeViewCountChartData($dateRange, $allData)
    {
        $data = [];
        foreach ($dateRange as $index => $date) {
            foreach ($allData as $index => $allDatum) {
                if($allDatum->ymd == $date){
                    $data[] = $allDatum->cnt;
                    break;
                }
            }
            $data[] = 0;
        }
        return $data;
    }

    static public function makeShortUrl(string $url){
        try {
            $client = new Client();
            $headers = [
                'X-NCP-APIGW-API-KEY-ID' => env('NAVERCLOUD_CLIENT_ID'),
                'X-NCP-APIGW-API-KEY' => env('NAVERCLOUD_SECRECT'),
            ];
            $request = new Request('GET', "https://naveropenapi.apigw.ntruss.com/util/v1/shorturl?url={$url}", $headers);
            $res = $client->sendAsync($request)->wait();
            return json_decode((string)$res->getBody(), true);
        } catch (\Exception $e){
            throw $e;
        }
    }
}
