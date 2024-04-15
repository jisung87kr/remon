<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CampaignApplicationExport;
use App\Http\Controllers\Controller;
use App\Models\CampaignApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            (new CampaignApplicationExport($filter))->download($filename);
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
