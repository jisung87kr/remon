<?php

namespace App\Http\Controllers;

use App\Enums\Campaign\MissionOptionEnum;
use App\Enums\Campaign\StatusEnum;
use App\Helper\CommonHelper;
use App\Models\Campaign;
use App\Models\CampaignApplicationField;
use App\Models\CampaignImage;
use App\Models\CampaignMissionOption;
use App\Models\CampaignType;
use App\Models\Category;
use App\Models\Mission;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Enums\Campaign\MetaEnum;
use App\Enums\Campaign\MediaEnum;
use App\Enums\User\MetaEnum AS UserMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Enums\Campaign\ApplicationFieldEnum;
use Illuminate\Validation\Rule;
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
    public function index()
    {
        //
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
        $campaign = $this->campaignService->upsert($request->all());
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        //
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
