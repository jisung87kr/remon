<?php
namespace App\Services;
use App\Enums\Campaign\ApplicationFieldEnum;
use App\Enums\Campaign\ImageTypeEnum;
use App\Enums\Campaign\MissionOptionEnum;
use App\Enums\Campaign\StatusEnum;
use App\Helper\CommonHelper;
use App\Models\Campaign;
use App\Models\CampaignType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class CampaignService{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function upsert($params)
    {
        $validated = $this->validate($params);

        DB::beginTransaction();
        try {
            // 캠페인 등록
            $campaignType = CampaignType::find($validated['type']);
            $campaign = Campaign::updateOrCreate([
                'id' => $validated['id'] ?? null,
            ],[
                'campaign_type_id'            => $validated['type'],
                'campaign_type_name'          => $campaignType->name,
                'campaign_type_price'         => $campaignType->price,
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

            // 카테고리 등록
            $campaign->categories()->sync($validated['product_category']);
            $campaign->categories()->sync($validated['location_category']);

            // 미션 등록
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

                $campaign->missionOptions()->sync([
                    $mission_option => ['content' => $content],
                ]);
            }

            // 지원사항 필드 등록
            $applicationFields = [];
            foreach ($validated['application_field'] as $index => $item) {
                $enumLabel = ApplicationFieldEnum::findByName($item)->label();
                $option = isset($enumLabel['option']) ? serialize(CommonHelper::makeCasesWithLabel($enumLabel['option'])) : null;
                $fieldName = $enumLabel['name'];

                if($enumLabel['name'] === ApplicationFieldEnum::CUSTOM_OPTION->name){
                    foreach ($validated['custom_option'] as $key => $value) {
                        $applicationFields[] = [
                            'campaign_id' => $campaign->id,
                            'field_category' => $enumLabel['category'],
                            'name' => $fieldName,
                            'type' => $enumLabel['type'],
                            'label' => $value['name'],
                            'option' => $value['value'],
                        ];
                    }
                } else {
                    $applicationFields[] = [
                        'campaign_id' => $campaign->id,
                        'field_category' => $enumLabel['category'],
                        'name' => $fieldName,
                        'type' => $enumLabel['type'],
                        'label' => $enumLabel['label'],
                        'option' => $option,
                    ];
                }
            }

            $campaign->applicationFields()->upsert($applicationFields, ['campaign_id', 'field_category', 'name', 'type', 'label']);
            $campaign->applicationFields()
                ->whereNotIn('field_category', collect($applicationFields)->pluck('field_category'))
                ->whereNotIn('name', collect($applicationFields)->pluck('name'))
                ->whereNotIn('type', collect($applicationFields)->pluck('type'))
                ->whereNotIn('label', collect($applicationFields)->pluck('label'))
                ->delete();


            // 이미지 업로드
            if($this->request->hasFile('thumbnails')){
                foreach ($this->request->file('thumbnails') as $index => $item) {
                    $path = $item->store('campaigns/'.$campaign->id, 'public');
                    $campaign->images()->create([
                        'type' => ImageTypeEnum::THUMBNAIL,
                        'file_path' => $path,
                        'file_name' => $item->getClientOriginalName(),
                    ]);
                }
            }

            if($this->request->hasFile('detail_images')){
                foreach ($this->request->file('detail_images') as $index => $item) {
                    $path = $item->store('campaigns/'.$campaign->id, 'public');
                    $campaign->images()->create([
                        'type' => ImageTypeEnum::DETAIL,
                        'file_path' => $path,
                        'file_name' => $item->getClientOriginalName(),
                    ]);
                }
            }

            DB::commit();
            return $campaign;

        } catch (\Exception $e){

            DB::rollBack();
            throw new \Exception($e->getMessage());

        }
    }

    public function validate($params){
        $validated = Validator::make($params, [
            'id'                             => 'nullable',
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
            'mission_option_link'            => 'nullable|string',
            'mission_option_hashtag'         => 'nullable|string',
            'application_field'              => ['array', Rule::in(ApplicationFieldEnum::toArray('name'))],
            'custom_option'                  => 'nullable|array',
            'thumbnails.*'                   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'detail_images.*'                => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return $validated->attributes();
    }

    public function getApplicationFields()
    {
        return array_filter(ApplicationFieldEnum::cases(), function($item){
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
    }
}
