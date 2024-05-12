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
use Illuminate\Http\Request;

class CampaignBusinessController extends Controller
{
    public function dashboard(Request $request)
    {
        $filter = [];
        $campaignIds = $request->user()->businessCampaigns()->pluck('id')->toArray();
        $manCount = CampaignApplication::whereIn('campaign_id', $campaignIds)->where('sex', 'man')->count();
        $womanCount = CampaignApplication::whereIn('campaign_id', $campaignIds)->where('sex', 'woman')->count();
        $ageGroup = CampaignApplication::selectRaw('age_group, COUNT(age_group) as cnt')->whereIn('campaign_id', $campaignIds)->groupBy('age_group')->get();

        $summary = [
            'allCount' => $request->user()->businessCampaigns()->count() ?? 0,
            'readyCount' => $request->user()->businessCampaigns()->filter(['progress_status' => [ProgressStatusEnum::READY->value]])->count() ?? 0,
            'applyingCount' => $request->user()->businessCampaigns()->filter(['progress_status' => [ProgressStatusEnum::Applying->value]])->count() ?? 0,
            'approvingCount' => $request->user()->businessCampaigns()->filter(['progress_status' => [ProgressStatusEnum::Approving->value]])->count() ?? 0,
            'completedCount' => $request->user()->businessCampaigns()->filter(['progress_status' => [ProgressStatusEnum::COMPLETED->value]])->count() ?? 0,
            'contentCount' => CampaignMediaContent::whereIn('campaign_id', $campaignIds)->count('id') ?? 0,
            'viewCount' => $request->user()->businessCampaigns()->filter($filter)->sum('banner_log_count') ?? 0,
            'mobileCount' => $request->user()->businessCampaigns()->filter($filter)->sum('banner_log_mobile_count') ?? 0,
            'pcCount' => $request->user()->businessCampaigns()->sum('banner_log_pc_count') ?? 0,
            'manCount' => $manCount,
            'womanCount' => $womanCount,
            'ageGroup' => $ageGroup,
        ];
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
        return view('business.campaign.show', compact('campaign'));
    }

    public function report(Request $request, Campaign $campaign)
    {
        return view('business.campaign.report', compact('campaign'));
    }
}
