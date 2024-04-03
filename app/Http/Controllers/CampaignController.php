<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\CampaignType;
use App\Models\Category;
use App\Models\Mission;
use Illuminate\Http\Request;
use App\Services\CampaignService;
class CampaignController extends Controller
{
    private $campaignService;
    public function __construct(Category $category, CampaignService $campaignService)
    {
        $this->category = $category;
        $this->campaignService = $campaignService;
    }
    /**
     * Display a listing of the resource.
     */
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
        $campaigns = Campaign::filter($filter)->sort($request->input('sort'))->paginate(60);
        $category = new Category;
        $campaignTypes = CampaignType::all();
        $typeCategory = Category::filter(['name' => '유형'])->first();
        $productCategory = Category::filter(['name' => '제품'])->first();
        $locationCategory = Category::filter(['name' => '지역'])->first();
        $missions = Mission::all();
        $viewName = request()->route()->getPrefix() === 'admin/' ? 'admin.campaign.index' : 'campaign.index';
        return view($viewName, compact('campaigns', 'category', 'campaignTypes', 'typeCategory', 'productCategory', 'locationCategory', 'missions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $campaign = new Campaign();
        $campaignTypes = CampaignType::all();
        $typeCategory = Category::filter(['name' => '유형'])->first();
        $productCategory = Category::filter(['name' => '제품'])->first();
        $locationCategory = Category::filter(['name' => '지역'])->first();
        $missions = Mission::all();
        $customOptions = $this->campaignService->getApplicationFields();
        $viewName = request()->route()->getPrefix() === 'admin/' ? 'admin.campaign.create' : 'campaign.create';
        return view($viewName, compact('campaign', 'campaignTypes', 'typeCategory', 'productCategory', 'locationCategory', 'missions', 'customOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $campaign = $this->campaignService->upsert();
        $routeName = request()->route()->getPrefix() === 'admin/' ? 'admin.campaign.show' : 'campaign.show';
        return redirect()->route($routeName, $campaign);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        $campaignApplication = new CampaignApplication();
        $viewName = request()->route()->getPrefix() === 'admin/' ? 'campaign.show' : 'campaign.show';
        return view($viewName, compact('campaign', 'campaignApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        $campaignTypes = CampaignType::all();
        $typeCategory = Category::filter(['name' => '유형'])->first();
        $productCategory = Category::filter(['name' => '제품'])->first();
        $locationCategory = Category::filter(['name' => '지역'])->first();
        $missions = Mission::all();
        $customOptions = $this->campaignService->getApplicationFields();
        $viewName = request()->route()->getPrefix() === 'admin/' ? 'admin.campaign.edit' : 'campaign.edit';
        return view($viewName, compact('campaign', 'campaignTypes', 'typeCategory', 'productCategory', 'locationCategory', 'missions', 'customOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $this->campaignService->upsert();
        $routeName = request()->route()->getPrefix() === 'admin/' ? 'admin.campaign.edit' : 'campaign.show';
        return redirect()->route($routeName, $campaign);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        $routeName = request()->route()->getPrefix() === 'admin/' ? 'admin.campaign.index' : 'campaign.index';
        return redirect()->route($routeName);
    }
}
