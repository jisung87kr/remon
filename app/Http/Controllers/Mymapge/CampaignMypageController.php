<?php

namespace App\Http\Controllers\Mymapge;

use App\Enums\Campaign\ApplicantStatus;
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
            'applicant_status' => $request->input('status'),
        ];

        $campaigns = auth()->user()->campaigns()->filter($filter)->paginate(10);
        $countData = [
            'appliedCount' => auth()->user()->campaigns()->filter(['applicant_status' => ApplicantStatus::APPLIED->value])->count(),
            'approvedCount' => auth()->user()->campaigns()->filter(['applicant_status' => ApplicantStatus::APPROVED->value])->count(),
            'postedCount' => auth()->user()->campaigns()->filter(['applicant_status' => ApplicantStatus::POSTED->value])->count(),
            'completedCount' => auth()->user()->campaigns()->filter(['applicant_status' => ApplicantStatus::COMPLETED->value])->count(),
        ];
        return view('mypage.campaigns', compact('campaigns', 'countData'));
    }
}
