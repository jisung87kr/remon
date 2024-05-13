<?php

namespace App\Http\Controllers\Mymapge;

use App\Enums\Campaign\ApplicationStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignMypageController extends Controller
{
    public function campaigns(Request $request)
    {
        $filter = [
            'media'         => $request->input('media'),
            'keyword'       => $request->input('keyword'),
            'campaign_type' => $request->input('campaign_type'),
            'type'          => $request->input('type'),
            'product'       => $request->input('product'),
            'location'      => $request->input('location'),
            'application_status' => $request->input('status'),
            'progress_status'      => $request->input('progress_status'),
        ];

        $campaigns = auth()->user()->campaigns()->filter($filter)->paginate(10);
        $countData = [
            'appliedCount' => auth()->user()->campaigns()->filter(['application_status' => ApplicationStatus::APPLIED->value])->count(),
            'approvedCount' => auth()->user()->campaigns()->filter(['application_status' => ApplicationStatus::APPROVED->value])->count(),
            'postedCount' => auth()->user()->campaigns()->filter(['application_status' => ApplicationStatus::POSTED->value])->count(),
            'completedCount' => auth()->user()->campaigns()->filter(['application_status' => ApplicationStatus::COMPLETED->value])->count(),
        ];
        return view('mypage.campaigns', compact('campaigns', 'countData'));
    }

    public function favorites(Request $request)
    {
        $filter = [
            'media'         => $request->input('media'),
            'keyword'       => $request->input('keyword'),
            'campaign_type' => $request->input('campaign_type'),
            'type'          => $request->input('type'),
            'product'       => $request->input('product'),
            'location'      => $request->input('location'),
            'applicant_status' => $request->input('status'),
        ];

        $campaigns = $request->user()->campaignFavorites()->filter($filter)->paginate(10);;
        return view('mypage.favorites', compact('campaigns'));
    }
}
