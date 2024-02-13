<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
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
        $campaigns = Campaign::filter($filter)->paginate(60);
        $category = new Category;
        $campaignTypes = CampaignType::all();
        $typeCategory = Category::filter(['name' => '유형'])->first();
        $productCategory = Category::filter(['name' => '제품'])->first();
        $locationCategory = Category::filter(['name' => '지역'])->first();
        $missions = Mission::all();
        return view('campaign.index', compact('campaigns', 'category', 'campaignTypes', 'typeCategory', 'productCategory', 'locationCategory', 'missions'));
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
        return view('campaign.create', compact('campaign', 'campaignTypes', 'typeCategory', 'productCategory', 'locationCategory', 'missions', 'customOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $campaign = $this->campaignService->upsert();
        return $campaign;
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        return view('campaign.show', compact('campaign'));
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
        return view('campaign.edit', compact('campaign', 'campaignTypes', 'typeCategory', 'productCategory', 'locationCategory', 'missions', 'customOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $this->campaignService->upsert();
        return redirect()->route('campaigns.show', $campaign);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('index');
    }
}
