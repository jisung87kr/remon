<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignImage;
use App\Models\CampaignMissionOption;
use App\Models\Category;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Enums\Campaign\Meta;
use App\Enums\Campaign\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
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
        //
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
//        $faker = Factory::create();
//        $path = storage_path('app/public/dummy');
//        $filePath = $faker->image($path, 400, 400, null, false);
//        $fileUrl = Storage::disk('public')->url('dummy/1.png');
//        dd($fileUrl);

//        $result = CampaignImage::factory(1)->create();
        dd($campaign->detailimages());
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
