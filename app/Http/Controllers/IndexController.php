<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Enums\Campaign\Status;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $bestCampaigns = Campaign::where('status', Status::DRAFT)->limit(7)->get();
        $remonPicksCampaigns = [];
        $pendingCampaigns = [];
        $brands = [];
        $bestContents = [];
        return view('index', compact('bestCampaigns'));
    }
}
