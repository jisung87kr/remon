<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Campaign\ApplicationStatus;
use App\Enums\User\PointTypeEnum;
use App\Events\ApplicationProcessed;
use App\Exports\CampaignApplicationExport;
use App\Http\Controllers\Controller;
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

    public function updateStatus(Request $request)
    {
        $result = DB::transaction(function() use ($request){
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
