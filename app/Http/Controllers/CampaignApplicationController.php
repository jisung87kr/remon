<?php

namespace App\Http\Controllers;

use App\Enums\Campaign\ApplicantStatus;
use App\Enums\Campaign\StatusEnum;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Campaign $campaign)
    {
        return view('campaign.application.index', compact('campaign'));
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
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'birthdate' => ['required'],
            'sex' => ['required'],
            'phone' => ['required'],
            'portrait_right_consent' => ['required', 'boolean'],
            'base_right_consent' => ['required', 'boolean'],
        ]);

        $validated['status'] = ApplicantStatus::APPLIED->value;

        DB::beginTransaction();
        try {
            $applicant = $request->user()->applicants()->create($validated);
            foreach ($request->input('application_field') as $index => $item) {
                $applicant->applicationValues()->create([
                    'campaign_application_filed_id' => $item['id'],
                    'value' => $item['value'],
                ]);
            }

            DB::commit();
            return $applicant;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
