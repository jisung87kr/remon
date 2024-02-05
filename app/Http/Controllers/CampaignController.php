<?php

namespace App\Http\Controllers;

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
            'status'                      => [Rule::enum(StatusEnum::class)],
            'type'                        => 'required',
            'product_category'            => 'required|array',
            'type_category'               => 'required|array',
            'location_category'           => 'required|array',
            'title'                       => 'required',
            'product_name'                => 'required',
            'product_url'                 => 'nullable',
            'use_benefit_point'           => Rule::in(['y', 'n']),
            'benefit'                     => 'required',
            'point'                       => 'nullable|digits',
            'address_postcode'            => 'nullable',
            'address'                     => 'nullable',
            'address_detail'              => 'nullable',
            'visit_instructions'          => 'nullable',
            'extra_information'           => 'nullable',
            'applicant_start_at'          => 'required|date',
            'applicant_end_at'            => 'required|datetime',
            'announcement_at'             => 'required|datetime',
            'registration_start_date_at'  => 'required|datetime',
            'registration_end_date_at'    => 'required|datetime',
            'result_announcement_date_at' => 'required|datetime',
            'mission_options'             => 'required|array',
            'mission_options.1.content'   => 'nullable',
            'mission_options.2.content'   => 'nullable',
            'mission_options.8.content'   => 'nullable',
            'mission_options.11.content'  => 'nullable',
            'application_field'           => ['array', Rule::in(ApplicationFieldEnum::toArray('name'))],
            'custom_option'               => 'array',
            'user_custom_option'          => Rule::in(['y', 'n']),
        ]);

        DB::beginTransaction();

        try {
            $campaign = Campaign::create([
                'campaign_type_id' => $validated['type'],
                'product_name' => $validated['product_name'],
                'product_url' => $validated['product_url'],
            ]);
            DB::rollBack();
        } catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
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
