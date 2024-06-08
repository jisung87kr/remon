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
        $bestCampaigns = Campaign::where('status', StatusEnum::PUBLISHED)->limit(7)->get();
        $fleetPicksCampaigns = [];
        $pendingCampaigns = [];
        $brands = [];
        $bestContents = CampaignMediaContent::withCount('bannerLogs')->orderBy('banner_logs_count', 'desc')->take(10)->get();

        return view('index', compact('bestCampaigns', 'bestContents'));
    }
}
