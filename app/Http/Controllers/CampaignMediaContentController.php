<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignMedia;
use App\Models\CampaignMediaContent;
use Illuminate\Http\Request;

class CampaignMediaContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Campaign $campaign, CampaignMedia $media)
    {
        return $media;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Campaign $campaign, CampaignMedia $media)
    {
        return $media;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Campaign $campaign, CampaignMedia $media)
    {
        $validated = $request->validate([
            'content_url' => 'required',
        ]);

        $validated['user_id'] = $request->user()->id;

        $result = $media->contents()->create($validated);
        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, CampaignMedia $media, CampaignMediaContent $content)
    {
        return $content;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, CampaignMedia $media, CampaignMediaContent $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign, CampaignMedia $media, CampaignMediaContent $content)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, CampaignMedia $media, CampaignMediaContent $content)
    {
        //
    }
}
