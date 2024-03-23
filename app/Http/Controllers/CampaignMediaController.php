<?php

namespace App\Http\Controllers;

use App\Models\CampaignMedia;
use Illuminate\Http\Request;

class CampaignMediaController extends Controller
{
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

        $campaigns = auth()->user()->campaigns()->filter($filter)->paginate(10);
        return view('mypage.campaigns', compact('campaigns'));
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
    public function show(CampaignMedia $campaignMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CampaignMedia $campaignMedia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CampaignMedia $campaignMedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CampaignMedia $campaignMedia)
    {
        //
    }
}
