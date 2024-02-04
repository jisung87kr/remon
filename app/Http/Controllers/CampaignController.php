<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignImage;
use App\Models\CampaignMissionOption;
use App\Models\CampaignType;
use App\Models\Category;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Enums\Campaign\MetaEnum;
use App\Enums\Campaign\MediaEnum;
use App\Enums\User\MetaEnum AS UserMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function __construct(Category $category)
    {
        $this->category = $category;
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
        $productCategory = Category::filter(['name' => '제품'])->first();
        $locationCategory = Category::filter(['name' => '지역'])->first();
        return view('campaign.create', compact('campaign', 'campaignTypes', 'productCategory', 'locationCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
