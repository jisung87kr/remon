<?php
namespace App\Services;
use App\Enums\Campaign\ApplicationFieldEnum;
use App\Enums\Campaign\ImageTypeEnum;
use App\Enums\Campaign\MissionOptionEnum;
use App\Enums\Campaign\StatusEnum;
use App\Helper\CommonHelper;
use App\Models\Campaign;
use App\Models\CampaignImage;
use App\Models\CampaignMedia;
use App\Models\CampaignType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class CampaignService{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function upsert()
    {
        $validated = $this->request->validate([
            'id'                             => 'nullable',
            'user_id'                        => 'required',
            'status'                         => [Rule::enum(StatusEnum::class)],
            'type'                           => 'required',
            'product_category'               => 'required|array',
            'type_category'                  => 'required|array',
            'location_category'              => 'nullable|array',
            'media'                          => 'required|array',
            'title'                          => 'required',
            'product_name'                   => 'required',
            'product_url'                    => 'nullable',
            'use_benefit_point'              => Rule::in(['y', 'n']),
            'benefit'                        => 'required',
            'benefit_point'                  => 'nullable',
            'address_postcode'               => 'nullable',
            'address'                        => 'nullable',
            'address_detail'                 => 'nullable',
            'address_extra'                  => 'nullable',
            'application_limit'              => 'integer',
            'lat'                            => 'nullable',
            'long'                           => 'nullable',
            'visit_instruction'              => 'nullable',
            'extra_information'              => 'nullable',
            'application_start_at'             => 'required|date',
            'application_end_at'               => 'required|date',
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
            'application_field'              => ['nullable', 'array', Rule::in(ApplicationFieldEnum::toArray('value'))],
            'custom_option'                  => 'nullable|array',
            'thumbnails.*'                   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'detail_images.*'                => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images'                  => 'nullable|array',
            'application_information'        => 'nullable',
            'thumbnails_sort.*'              => 'nullable',
            'detail_images_sort.*'           => 'nullable',
        ]);

        try {
            // 캠페인 등록
            DB::beginTransaction();
            $campaignType = CampaignType::find($validated['type']);
            $campaign = Campaign::updateOrCreate([
                'id' => $validated['id'] ?? null,
            ],[
                'user_id'                     => $validated['user_id'],
                'campaign_type_id'            => $validated['type'],
                'status'                      => $validated['status'],
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
                'address_extra'               => $validated['address_extra'] ?? null,
                'application_limit'           => $validated['application_limit'],
                'lat'                         => $validated['lat'] ?? null,
                'long'                        => $validated['long'] ?? null,
                'visit_instruction'           => $validated['visit_instruction'] ?? null,
                'extra_information'           => $validated['extra_information'],
                'application_start_at'        => $validated['application_start_at'],
                'application_end_at'          => $validated['application_end_at'],
                'announcement_at'             => $validated['announcement_at'],
                'registration_start_date_at'  => $validated['registration_start_date_at'],
                'registration_end_date_at'    => $validated['registration_end_date_at'],
                'result_announcement_date_at' => $validated['result_announcement_date_at'],
                'mission'                     => $validated['mission'],
                'application_information'     => $validated['application_information'] ?? null,
            ]);

            // 카테고리 등록
            $mergedCategories = [];
            $mergedCategories = array_merge($mergedCategories, $validated['product_category']);
            $mergedCategories = array_merge($mergedCategories, $validated['type_category']);
            $mergedCategories = array_merge($mergedCategories, $validated['location_category'] ?? []);
            $mergedCategories = array_unique($mergedCategories);
            $campaign->categories()->sync($mergedCategories);


            // 미디어 등록
            foreach ($validated['media'] as $index => $media) {
                $campaign->media()->updateOrCreate(['media' => $media], ['media' => $media]);
            }

            $mediaArray = $campaign->media;
            $recordsToDelete = [];
            foreach ($mediaArray as $index => $item) {
                if(!in_array($item->media, $validated['media'])){
                    $recordsToDelete[] = $item->id;
                }
            }
            $campaign->media()->whereIn('id', $recordsToDelete)->delete();


            // 미션 등록
            $missionOptionsData = [];
            foreach ($validated['mission_options'] as $index => $mission_option) {
                $content = null;

                switch ($mission_option){
                    case MissionOptionEnum::TITLE_KEYWORD_ID_OF_MISSION_OPTION->value:
                        $content = isset($validated['mission_option_title_keyword']) ? $validated['mission_option_title_keyword'] : null;
                        break;
                    case MissionOptionEnum::CONTENT_KEYWORD_ID_OF_MISSION_OPTION->value:
                        $content = isset($validated['mission_option_content_keyword']) ? $validated['mission_option_content_keyword'] : null;
                        break;
                    case MissionOptionEnum::LINK_ID_OF_MISSION_OPTION->value:
                        $content = isset($validated['mission_option_link']) ? $validated['mission_option_link'] : null;
                        break;
                    case MissionOptionEnum::HASHTAG_ID_OF_MISSION_OPTION->value:
                        $content = isset($validated['mission_option_hashtag']) ? $validated['mission_option_hashtag'] : null;
                        break;
                }

                $missionOptionsData[$mission_option] = ['content' => $content];
            }
            $campaign->missionOptions()->sync($missionOptionsData);

            // 지원사항 필드 등록
            if(isset($validated['application_field'])){
                $applicationFields = [];
                foreach ($validated['application_field'] as $index => $item) {
                    $enumLabel = ApplicationFieldEnum::from($item)->label();
                    $option = isset($enumLabel['option']) ? serialize(CommonHelper::makeCasesWithLabel($enumLabel['option'])) : null;
                    $fieldName = $enumLabel['value'];

                    if($enumLabel['value'] === ApplicationFieldEnum::CUSTOM_OPTION->value){
                        foreach ($validated['custom_option'] as $key => $value) {
                            $applicationFields[] = [
                                'id' => $value['id'],
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
                            'id' => $campaign->applicationFields()->where('name', $fieldName)->where('field_category', $enumLabel['category'])->first()['id'] ?? null,
                            'campaign_id' => $campaign->id,
                            'field_category' => $enumLabel['category'],
                            'name' => $fieldName,
                            'type' => $enumLabel['type'],
                            'label' => $enumLabel['label'],
                            'option' => $option,
                        ];
                    }
                }

                $existingApplicationFields = $campaign->applicationFields()->get();
                $existingIds = $existingApplicationFields->pluck('id')->all();
                $recordsToDelete = $existingIds;

                foreach ($applicationFields as $key => $field) {
                    if (($index = array_search($field['id'], $recordsToDelete)) !== false) {
                        unset($recordsToDelete[$index]);
                    }
                }

                $campaign->applicationFields()->whereIn('id', $recordsToDelete)->delete();
                $campaign->applicationFields()->upsert($applicationFields, ['campaign_id', 'field_category', 'name', 'type', 'label']);
            } else {
                $campaign->applicationFields()->delete();
            }

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

            if (!empty($validated['delete_images'])) {
                $images = $campaign->images()->whereIn('id', $validated['delete_images'])->get();
                foreach ($images as $image) {
                    $image->delete();
                    Storage::disk('public')->delete($image->file_path);
                }
            }

            if(!empty($validated['thumbnails_sort'])){
                foreach ($validated['thumbnails_sort'] as $index => $item) {
                    $campaign->images()->where('id', $index)->update(['order_seq' => $item]);
                }
            }

            if(!empty($validated['detail_images_sort'])){
                foreach ($validated['detail_images_sort'] as $index => $item) {
                    $campaign->images()->where('id', $index)->update(['order_seq' => $item]);
                }
            }

            DB::commit();
            return $campaign;

        } catch (\Exception $e){

            DB::rollBack();
            throw new \Exception($e->getMessage());

        }
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
