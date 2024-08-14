<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignMediaContent;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Enums\Campaign\StatusEnum;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::where('status', StatusEnum::PUBLISHED)->latest()->paginate(50);
//        $fleetPicksCampaigns = [];
//        $pendingCampaigns = [];
//        $brands = [];
//        $bestContents = CampaignMediaContent::withCount('bannerLogs')->orderBy('banner_logs_count', 'desc')->take(10)->get();

        return view('index', compact('campaigns'));
    }
}
