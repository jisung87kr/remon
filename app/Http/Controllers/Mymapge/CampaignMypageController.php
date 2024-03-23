<?php

namespace App\Http\Controllers\Mymapge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignMypageController extends Controller
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
        ];

        $campaigns = auth()->user()->campaigns()->filter($filter)->paginate(10);
        return view('mypage.campaigns', compact('campaigns'));
    }
}
