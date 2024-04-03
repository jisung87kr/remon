<?php

namespace App\Http\Controllers;

use App\Enums\Campaign\ApplicationStatus;
use App\Http\Resources\Response;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Services\CampaignApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignApplicationController extends Controller
{
    public $service;
    public function __construct(CampaignApplicationService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Campaign $campaign)
    {
        $campaignApplication = auth()->user()->getApplication($campaign) ??  new CampaignApplication();
        return view('campaign.application.index', compact('campaign', 'campaignApplication'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Campaign $campaign)
    {
        $campaignApplication = auth()->user()->getApplication($campaign) ??  new CampaignApplication();
        if($campaignApplication->id){
            return redirect()->route('campaign.application.edit', [$campaign, $campaignApplication]);
        }
        return view('campaign.application.create', compact('campaign', 'campaignApplication'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Campaign $campaign)
    {
        $campaignApplication = auth()->user()->getApplication($campaign) ??  new CampaignApplication();
        $application = $this->service->upsert($campaign, $campaignApplication);
        return redirect()->route('campaign.show', [$campaign]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, CampaignApplication $campaignApplication)
    {
        dd('신청 완료!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, CampaignApplication $campaignApplication)
    {
        if(!auth()->user()->can('update', $campaignApplication)){
            abort(403);
        }
        return view('campaign.application.edit', compact('campaign', 'campaignApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign, CampaignApplication $campaignApplication)
    {
        if(!auth()->user()->can('update', $campaignApplication)){
            abort(403);
        }

        $application = $this->service->upsert($campaign, $campaignApplication);
        return redirect()->route('campaign.application.edit', [$campaign, $campaignApplication]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, CampaignApplication $campaignApplication)
    {
        //
    }

    public function cancel(Request $request, Campaign $campaign, CampaignApplication $campaignApplication){
        if(!auth()->user()->can('cancel', $campaignApplication)){
            return response()->json(new Response(Response::ERROR, '캔페인 신청서 취소 권한이 없습니다.', ''), 403);
        }

        $result = $campaignApplication->update(['status' => ApplicationStatus::CANCELED->value]);
        if($result){
            return response()->json(new Response(Response::SUCCESS, '캔페인 신청서 취소 성공', ''));
        } else {
            return response()->json(new Response(Response::ERROR, '캔페인 신청서 취소 실패', ''), 500);
        }
    }
}
