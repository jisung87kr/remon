<?php

namespace App\Http\Controllers;

use App\Enums\Campaign\MissionOptionEnum;
use App\Enums\Campaign\StatusEnum;
use App\Models\Campaign;
use App\Models\CampaignImage;
use App\Models\CampaignMissionOption;
use App\Models\CampaignType;
use App\Models\Category;
use App\Models\Mission;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Enums\Campaign\MetaEnum;
use App\Enums\Campaign\MediaEnum;
use App\Enums\User\MetaEnum AS UserMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Enums\Campaign\ApplicationFieldEnum;
use Illuminate\Validation\Rule;
class CampaignController extends Controller
{
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $campaign = new Campaign();
        $campaignTypes = CampaignType::all();
        $typeCategory = Category::filter(['name' => '유형'])->first();
        $productCategory = Category::filter(['name' => '제품'])->first();
        $locationCategory = Category::filter(['name' => '지역'])->first();
        $missions = Mission::all();

//        dd(ApplicationFieldEnum::cases()[0]->label());
        $customOptions = array_filter(ApplicationFieldEnum::cases(), function($item){
            if(!in_array($item->name, [
                ApplicationFieldEnum::SHIPPING_ADDRESS_POSTCODE->name,
                ApplicationFieldEnum::SHIPPING_ADDRESS->name,
                ApplicationFieldEnum::SHIPPING_ADDRESS_DETAIL->name,
                ApplicationFieldEnum::RECIPIENT_NAME->name,
                ApplicationFieldEnum::RECIPIENT_PHONE->name,
            ])){
                return $item;
            }
        });

        return view('campaign.create', compact('campaign', 'campaignTypes', 'typeCategory', 'productCategory', 'locationCategory', 'missions', 'customOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'status'                         => [Rule::enum(StatusEnum::class)],
            'type'                           => 'required',
            'product_category'               => 'required|array',
            'type_category'                  => 'required|array',
            'location_category'              => 'required|array',
            'title'                          => 'required',
            'product_name'                   => 'required',
            'product_url'                    => 'nullable',
            'use_benefit_point'              => Rule::in(['y', 'n']),
            'benefit'                        => 'required',
            'benefit_point'                  => 'nullable|digits',
            'address_postcode'               => 'nullable',
            'address'                        => 'nullable',
            'address_detail'                 => 'nullable',
            'lat'                            => 'nullable',
            'long'                           => 'nullable',
            'visit_instructions'             => 'nullable',
            'extra_information'              => 'nullable',
            'applicant_start_at'             => 'required|date',
            'applicant_end_at'               => 'required|date',
            'announcement_at'                => 'required|date',
            'registration_start_date_at'     => 'required|date',
            'registration_end_date_at'       => 'required|date',
            'result_announcement_date_at'    => 'required|date',
            'mission'                        => 'required|string',
            'mission_options'                => 'required|array',
            'mission_option_title_keyword'   => 'nullable|string',
            'mission_option_content_keyword' => 'nullable|string',
            'mission_option_link'    => 'nullable|string',
            'mission_option_hashtag' => 'nullable|string',
            'application_field'              => ['array', Rule::in(ApplicationFieldEnum::toArray('name'))],
            'custom_option'                  => 'nullable|array',
        ]);

//        DB::beginTransaction();
//
//        try {
            $campaign = Campaign::create([
                'campaign_type_id'            => $validated['type'],
                'title'                       => $validated['title'],
                'product_name'                => $validated['product_name'],
                'product_url'                 => $validated['product_url'],
                'use_benefit_point'           => $validated['use_benefit_point'] === 'y',
                'benefit'                     => $validated['benefit'],
                'benefit_point'               => $validated['benefit_point'] ?? null,
                'address_postcode'            => $validated['address_postcode'] ?? null,
                'address'                     => $validated['address'] ?? null,
                'address_detail'              => $validated['address_detail'] ?? null,
                'lat'                         => $validated['lat'] ?? null,
                'long'                        => $validated['long'] ?? null,
                'visit_instruction'           => $validated['visit_instruction'] ?? null,
                'extra_information'           => $validated['extra_information'],
                'applicant_start_at'          => $validated['applicant_start_at'],
                'applicant_end_at'            => $validated['applicant_end_at'],
                'announcement_at'             => $validated['announcement_at'],
                'registration_start_date_at'  => $validated['registration_start_date_at'],
                'registration_end_date_at'    => $validated['registration_end_date_at'],
                'result_announcement_date_at' => $validated['result_announcement_date_at'],
                'mission'                     => $validated['mission'],
            ]);

            $campaign->categories()->attach($validated['product_category']);
            $campaign->categories()->attach($validated['location_category']);

            foreach ($validated['mission_options'] as $index => $mission_option) {
                $content = null;

                switch ($mission_option){
                    case MissionOptionEnum::TITLE_KEYWORD_ID_OF_MISSION_OPTION->value:
                        $content = $validated['mission_option_title_keyword'];
                        break;
                    case MissionOptionEnum::CONTENT_KEYWORD_ID_OF_MISSION_OPTION->value:
                        $content = $validated['mission_option_content_keyword'];
                        break;
                    case MissionOptionEnum::LINK_ID_OF_MISSION_OPTION->value:
                        $content = $validated['mission_option_link'];
                        break;
                    case MissionOptionEnum::HASHTAG_ID_OF_MISSION_OPTION->value:
                        $content = $validated['mission_option_hashtag'];
                        break;
                }

                $campaign->missionOptions()->attach([
                    $mission_option => ['content' => $content],
                ]);
            }

            $campaign->applicationFields()->attach($validated['application_field']);


//            DB::rollBack();
//        } catch (\Exception $e){
//            DB::rollBack();
//            throw new \Exception($e->getMessage());
//        }
        dd($request->all(), $validated, $campaign);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        return view('campaign.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
