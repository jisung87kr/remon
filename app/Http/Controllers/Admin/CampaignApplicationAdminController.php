<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Campaign\ApplicationStatus;
use App\Enums\User\PointTypeEnum;
use App\Events\ApplicationProcessed;
use App\Exports\CampaignApplicationExport;
use App\Http\Controllers\Controller;
use App\Libraries\TrackerDelivery;
use App\Models\CampaignApplication;
use App\Models\CampaignMediaContent;
use App\Notifications\Campaign\Application\Applied;
use App\Notifications\Campaign\Application\Canceled;
use App\Notifications\Campaign\Application\Approved;
use App\Notifications\Campaign\Application\Rejected;
use App\Notifications\Campaign\Application\Pending;
use App\Notifications\Campaign\Application\Posted;
use App\Notifications\Campaign\Application\Completed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CampaignApplicationAdminController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->input('size', 10);
        $filter = [
            'status' => $request->input('status'),
            'keyword' => $request->input('keyword'),
        ];

        if($request->input('export')){
            $filename = "campaign_application_export_".time().".xlsx";
            return (new CampaignApplicationExport($filter))->download($filename);
        }

        $applications = CampaignApplication::filter($filter)->with('user')->orderBy('id', 'desc')->paginate($size);
        return view('admin.application.index', compact('applications'));
    }

    public function updateStatus(Request $request, TrackerDelivery $trackerDelivery)
    {
        $result = DB::transaction(function() use ($request, $trackerDelivery){
            foreach($request->input('application') as $index => $item) {
                if(isset($item['checked'])){
                    $application = CampaignApplication::find($item['id']);
                    $application->update(['status' => $item['status']]);

                    // 포인트 부여
                    if($item['status'] === ApplicationStatus::COMPLETED->value && $application->campaign->use_benefit_point){
                        $pointData = $application->user->points()->where('campaign_id', $application->campaign_id)->first();
                        if(!$pointData){
                            $application->user->points()->create([
                                'type' => PointTypeEnum::INCREMENT->value,
                                'point' => $application->campaign->benefit_point,
                                'description' => "캠페인 완료 보상",
                                'campaign_id' => $application->campaign_id,
                                'expired_at' => now()->addDays('100'),
                            ]);
                        }
                    }

                    if($item['status'] === ApplicationStatus::APPROVED->value){
                        foreach ($application->campaign->media as $index => $media) {
                            if(!CampaignMediaContent::where([
                                'campaign_application_id' => $application->id,
                                'campaign_media_id' => $media->id,
                            ])->first()){
                                $application->mediaContents()->create([
                                    'campaign_media_id' => $media->id,
                                    'campaign_id' => $application->campaign->id,
                                    'user_id' => $application->user->id,
                                    'banner_id' => (string)Str::uuid(),
                                ]);
                            }
                        }
                    }

                    // 송장등록
                    if($application->campaign->isShippingType && $item['status'] == ApplicationStatus::PROCESSING->value){
                        if(!$application->parcel){
                            if(isset($item['carrier_id']) && isset($item['tracking_number'])){
                                $parcel = $application->parcel()->create([
                                    'carrier_id' => $item['carrier_id'],
                                    'tracking_number' => $item['tracking_number'],
                                    'tracking_status' => $item['tracking_status'],
                                ]);

                                $expireAt = $trackerDelivery->makeExpireAt();
                                $callbackUrl = route('callback.tracker_delivery', $parcel);
                                $parcel->update([
                                    'callback_url' => $callbackUrl,
                                    'expired_at' => date('Y-m-d H:i:s', strtotime($expireAt)),
                                ]);

                                // 콜백등록
                                $trackerDelivery->registerTrackWebhook($item['carrier_id'], $item['tracking_number'], $callbackUrl, $expireAt);
                            }

                        } elseif($application->parcel['carrier_id'] != $item['carrier_id'] || $application->parcel['tracking_number'] != $item['tracking_number']){
                            $expireAt = $trackerDelivery->makeExpireAt();
                            $callbackUrl = route('callback.tracker_delivery', $application->parcel);
                            $application->parcel()->update([
                                'carrier_id' => $item['carrier_id'],
                                'tracking_number' => $item['tracking_number'],
                                'tracking_status' => $item['tracking_status'],
                                'expired_at' => date('Y-m-d H:i:s', strtotime($expireAt)),
                            ]);

                            $trackerDelivery->registerTrackWebhook($item['carrier_id'], $item['tracking_number'], $callbackUrl, $expireAt);

                        } elseif ($application->parcel['tracking_status'] != $item['tracking_status']) {
                            $application->parcel()->update([
                                'tracking_status' => $item['tracking_status'],
                            ]);
                        }
                    }

                    //상태변경 알림 이벤트
                    ApplicationProcessed::dispatch($application);
                }
            }

            return true;
        });

        if ($result) {
            // 플러시 메시지 추가
            session()->flash('status', '상태가 업데이트되었습니다.');
        } else {
            // 실패할 경우 플러시 메시지 추가
            session()->flash('error', '상태를 업데이트하지 못했습니다.');
        }

        return redirect()->route('admin.application.index');
    }
}
