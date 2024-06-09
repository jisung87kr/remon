<?php

namespace App\Http\Controllers;

use App\Enums\TrackDelivery\TrackEventStatusCodeEnum;
use App\Libraries\TrackerDelivery;
use App\Models\TrackerDeliverQueue;
use Illuminate\Http\Request;
use App\Models\CampaignApplicationParcel;

class CallbackController extends Controller
{
    public function trackerDelivery(Request $request, TrackerDelivery $trackerDelivery, CampaignApplicationParcel $parcel)
    {
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);

        if($input['carrierId'] && $input['trackingNumber']){
            $model = new TrackerDeliverQueue();
            $model->create([
                'carrier_id' => $input['carrierId'],
                'tracking_number' => $input['trackingNumber'],
            ]);

            try {
                $response = $trackerDelivery->lastTrack($input['carrierId'], $input['trackingNumber']);
                $body = (string)$response->response->getBody();
                $lastTrack = json_decode($body, true);
                $code = $lastTrack['data']['track']['lastEvent']['status']['code'];
                $status = null;
                foreach (TrackEventStatusCodeEnum::cases() as $index => $case) {
                    if($case->name == $code){
                        $status = $case;
                    }
                }

                $parcel->update([
                    'tracking_status' => $status->value,
                ]);
            } catch (\Exception $e) {

            }
        }
    }
}
