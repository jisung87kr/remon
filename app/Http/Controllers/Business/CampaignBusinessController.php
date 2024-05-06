<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignType;
use App\Models\Category;
use App\Models\Mission;
use Illuminate\Http\Request;

class CampaignBusinessController extends Controller
{
    public function dashboard()
    {
        return view('business.dashboard');
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
        ];

        $campaigns = $request->user()->campaigns()->filter($filter)->sort($request->input('sort'))->paginate(60);
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
