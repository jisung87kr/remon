<?php
namespace App\Services;

use App\Enums\Campaign\ApplicationStatus;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignApplicationService{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function upsert(Campaign $campaign, CampaignApplication $campaignApplication)
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

        if($this->request->input('portrait_right_consent')){
            $rules['portrait_right_consent'] = ['nullable', 'boolean'];
        }

        $validated = $this->request->validate($rules);

        $validated['status'] = ApplicationStatus::APPLIED->value;
        $validated['campaign_id'] = $campaign->id;
        $validated['banner_id'] = md5(uniqid(mt_rand(), true));

        DB::beginTransaction();
        try {

            $updateUserData = [];
            if(!$this->request->user()->birthdate){
                $updateUserData['birthdate'] = $validated['birthdate'];
            }

            if(!$this->request->user()->sex){
                $updateUserData['sex'] = $validated['sex'];
            }

            if(!$this->request->user()->phone){
                $updateUserData['phone'] = $validated['phone'];
                $updateUserData['phone_verified_at'] = null;
            }

            if($updateUserData){
                $this->request->user()->update($updateUserData);
            }

            $application = $this->request->user()->applications()->updateOrCreate([
                'id' => $campaignApplication->id ?? null,
            ], $validated);

            if($this->request->input('application_field')){
                $this->request->validate([
                    'application_field.*.value' => ['required']
                ]);
                foreach ($this->request->input('application_field') as $index => $item) {
                        $application->applicationValues()->updateOrCreate([
                            'campaign_application_id' => $campaignApplication->id ?? null,
                            'campaign_application_field_id' => $item['id'],
                        ],[
                            'campaign_application_field_id' => $item['id'],
                            'value' => $item['value'],
                        ]);
                }
            }

            DB::commit();
            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
