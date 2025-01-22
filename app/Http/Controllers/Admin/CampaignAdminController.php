<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignType;
use App\Models\Category;
use App\Models\Mission;
use Illuminate\Http\Request;

class CampaignAdminController extends Controller
{
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
        $campaigns = Campaign::filter($filter)->sort($request->input('sort', 'latest'))->paginate(60);
        $category = new Category;
        $campaignTypes = CampaignType::all();
        $typeCategory = Category::filter(['name' => '유형'])->first();
        $productCategory = Category::filter(['name' => '제품'])->first();
        $locationCategory = Category::filter(['name' => '지역'])->first();
        $missions = Mission::all();
        $viewName =  'admin.campaign.index';
        return view($viewName, compact('campaigns', 'category', 'campaignTypes', 'typeCategory', 'productCategory', 'locationCategory', 'missions'));
    }
}
