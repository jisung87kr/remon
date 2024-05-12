<?php

namespace App\Http\Controllers\Business;

use App\Enums\Campaign\ProgressStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\CampaignMedia;
use App\Models\CampaignMediaContent;
use App\Models\CampaignType;
use App\Models\Category;
use App\Models\Mission;
use App\Services\StatisticsService;
use Illuminate\Http\Request;

class CampaignBusinessController extends Controller
{
    public $service;

    public function __construct(StatisticsService $service)
    {
        $this->service = $service;
    }

    public function dashboard(Request $request)
    {
        $summary = $this->service->summary($request);
        return view('business.dashboard', compact('summary'));
    }

    public function index(Request $request)
    {
        $filter = [
            'media'         => $request->input('media'),
            'keyword'       => $request->input('keyword'),
            'campaign_type' => $request->input('campaign_type'),
            'type'          => $request->input('type'),
            'product'       => $request->input('product'),
            'location'      => $request->input('location'),
            'progress_status'      => $request->input('progress_status'),
        ];

        $campaigns = $request->user()->businessCampaigns()->filter($filter)->sort($request->input('sort'))->paginate(60);
        $category = new Category;
        $campaignTypes = CampaignType::all();
        $typeCategory = Category::filter(['name' => '유형'])->first();
        $productCategory = Category::filter(['name' => '제품'])->first();
        $locationCategory = Category::filter(['name' => '지역'])->first();
        $missions = Mission::all();
        return view('business.campaign.index', compact('campaigns', 'category', 'campaignTypes', 'typeCategory', 'productCategory', 'locationCategory', 'missions'));
    }

    public function show(Request $request, Campaign $campaign)
    {
        $contents = CampaignMediaContent::where('campaign_id', $campaign->id)->paginate(10);
        $applicants = $campaign->applications()->paginate(10);
        return view('business.campaign.show', compact('campaign', 'contents', 'applicants'));
    }

    public function report(Request $request, Campaign $campaign)
    {
        $request['campaign_id'] = $campaign->id;
        $summary = $this->service->summary($request);
        $contents = CampaignMediaContent::where('campaign_id', $campaign->id)->paginate(10);
        $applicants = $campaign->applications()->paginate(10);
        return view('business.campaign.report', compact('campaign', 'summary', 'contents', 'applicants'));
    }
}
