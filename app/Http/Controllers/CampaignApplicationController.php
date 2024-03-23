<?php

namespace App\Http\Controllers;

use App\Enums\Campaign\ApplicantStatus;
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
    public function store(Request $request, Campaign $campaign)
    {
        $rules = [
            'name' => ['required', 'string'],
            'birthdate' => ['required'],
            'sex' => ['required'],
            'phone' => ['required'],
            'portrait_right_consent' => ['nullable'],
            'base_right_consent' => ['required', 'boolean'],
            'shipping_name' => ['nullable'],
            'shipping_phone' => ['nullable'],
            'address' => ['nullable'],
            'address_detail' => ['nullable'],
            'address_extra' => ['nullable'],
            'address_postcode' => ['nullable'],
        ];

        if($request->input('portrait_right_consent')){
            $rules['portrait_right_consent'] = ['nullable', 'boolean'];
        }

        $validated = $request->validate($rules);

        $validated['status'] = ApplicantStatus::APPLIED->value;
        $validated['campaign_id'] = $campaign->id;

        DB::beginTransaction();
        try {

            $updateUserData = [];
            if(!$request->user()->birthdate){
                $updateUserData['birthdate'] = $validated['birthdate'];
            }

            if(!$request->user()->sex){
                $updateUserData['sex'] = $validated['sex'];
            }

            if(!$request->user()->phone){
                $updateUserData['phone'] = $validated['phone'];
                $updateUserData['phone_verified_at'] = null;
            }

            if($updateUserData){
                $request->user()->update($updateUserData);
            }

            $applicant = $request->user()->applicants()->create($validated);
            if($request->input('application_field')){
                $request->validate([
                    'application_field.*.value' => ['required']
                ]);
                foreach ($request->input('application_field') as $index => $item) {
                    $applicant->applicationValues()->create([
                        'campaign_application_field_id' => $item['id'],
                        'value' => $item['value'],
                    ]);
                }
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
