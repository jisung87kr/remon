@props(['campaign' => $campaign, 'useLink' => false, 'useThumbnail' => false, 'campaignApplication' => $campaignApplication])
<div class="col-span-8 lg:col-span-2">
    <div class="lg:sticky lg:top-0">
        @if($useThumbnail)
        <div class="py-6 border-b">
            @isset($campaign->thumbnails[0])
                <img src="{{Storage::url($campaign->thumbnails[0]['file_path'])}}" alt="">
            @else
                <img src="https://placeholder.co/1000x1000" alt="">
            @endisset
            <div class="mt-3">
                <div class="font-bold text-xl">@if($campaign->locationCategories->count() > 0)[{{ $campaign->locationCategories[0]->name }}] @endif{{ $campaign->product_name }}</div>
                <div class="font-bold text-gray-500">{{ $campaign->title }}</div>
                <div class="flex gap-3 mt-3">
                    @foreach($campaign->media as $media)
                        <x-media-icon :media="$media->media"></x-media-icon>
                    @endforeach
{{--                    <div class="p-1 text-xs border text-gray-600">예약없음</div>--}}
                </div>
            </div>
        </div>
        @endif
        <div class="py-6 border-b">
            <div class="flex font-bold my-2">
                <div class="shrink-0 w-[110px] mr-1">캠페인 신청기간</div>
                <div>{{ $campaign->application_start_at->format('m.d') }}
                    ~ {{ $campaign->application_end_at->format('m.d') }}</div>
            </div>
            <div class="flex text-gray-500 my-2">
                <div class="shrink-0 w-[110px] mr-1">선정결과 발표</div>
                <div>{{ $campaign->announcement_at->format('m.d') }}</div>
            </div>
{{--            <div class="flex text-gray-500 my-2">--}}
{{--                <div class="shrink-0 w-[110px] mr-1">콘텐츠 등록기간</div>--}}
{{--                <div>{{ $campaign->registration_start_date_at->format('m.d') }}--}}
{{--                    ~ {{ $campaign->registration_end_date_at->format('m.d') }}</div>--}}
{{--            </div>--}}
{{--            <div class="flex text-gray-500 my-2">--}}
{{--                <div class="shrink-0 w-[110px] mr-1">콘텐츠 결과발표</div>--}}
{{--                <div>{{ $campaign->result_announcement_date_at->format('m.d') }}</div>--}}
{{--            </div>--}}
        </div>
        @if($useLink)
        <div>
            <div class="hidden lg:block py-6 border-b">
                <a href="#benefit" class="text-gray-800">제공 내역</a>
            </div>
            <div class="hidden lg:block py-6 border-b">
                <a href="#visit_instruction" class="text-gray-800">방문 및 예약안내</a>
            </div>
            <div class="hidden lg:block py-6 border-b">
                <a href="#mission" class="text-gray-800">캠페인 미션</a>
            </div>
            <div class="hidden lg:block py-6 border-b">
                <a href="#keyword" class="text-gray-800">키워드</a>
            </div>
            <div class="hidden lg:block py-6 border-b">
                <a href="#extra_information" class="text-gray-800">추가 안내사항</a>
            </div>
        </div>
        @endif
        <div class="py-6">
            @if(in_array(request()->route()->getName(), ['campaign.show', 'campaign.application.index']))
                @if(auth()->user() && auth()->user()->getApplication($campaign))
                    <a href="{{ route('campaign.application.edit', [$campaign, $campaignApplication]) }}" class="bg-gray-900 text-white px-5 py-4 block text-center font-bold mt-3">신청 내용 보기</a>
                @else
                    @if($campaign->is_appliable)
                        <a href="{{ route('campaign.application.create', $campaign) }}" class="bg-gray-900 text-white px-5 py-4 block text-center font-bold">캠페인 신청하기</a>
                    @else
                        <button type="button" class="bg-gray-500 text-white px-5 py-4 block text-center font-bold w-full" disabled>마감된 캠페인 입니다</button>
                    @endif
                @endif
            @else
                <div class="mb-6">
                    @if($campaign->hasPortraitRightConsent)
                        <div class="my-2 flex gap-3">
                            <input type="checkbox" name="portrait_right_consent" class="form-check mt-1" id="portrait_right_consent" value="1" required @checked(old('portrait_right_consent', $campaignApplication->portrait_right_consent ?? null) == 1)>
                            <div>
                                <label for="portrait_right_consent" class="text-sm text-gray-700">초상권 활용에 동의 합니다.</label>
                                <a href="/page/policy" class="block underline text-sm text-gray-500 mt-2" target="_blank">자세히보기</a>
                            </div>
                            <x-input-error for="portrait_right_consent" class="mt-1"></x-input-error>
                        </div>
                    @endif
                    @if(!isset($campaignApplication->status))
                    <div class="my-2 flex gap-3">
                        <input type="checkbox" name="base_right_consent" class="form-check mt-1" id="base_right_consent" value="1" required @checked(old('base_right_consent', $campaignApplication->base_right_consent ?? null) == 1)>
                        <div>
                            <label for="base_right_consent" class="text-sm text-gray-700">캠페인 유의사항, 개인정보 및 콘텐츠 제3자 제공, 저작물 이용에 동의합니다.</label>
                            <a href="/page/policy" class="block underline text-sm text-gray-500 mt-2" target="_blank">자세히보기</a>
                        </div>
                        <x-input-error for="base_right_consent" class="mt-1"></x-input-error>
                    </div>
                    @endif
                </div>
                @if(auth()->user()->can('update', $campaignApplication))
                    @if($campaignApplication->status == \App\Enums\Campaign\ApplicationStatus::APPLIED->value)
                        <button type="submit" class="mt-3 bg-gray-900 text-white px-5 py-4 block text-center font-bold w-full">수정완료</button>
                        <button type="button"
                                class="bg-orange-300 text-white px-5 py-4 block text-center font-bold mt-3 w-full"
                                x-data="campaignCancelData"
                                @click="cancelApplication">신청 취소</button>
                        <script>
                          const campaignCancelData = {
                            campaignId: '{{ $campaign->id }}',
                            campaignApplicationId: '{{ $campaignApplication->id }}',
                            cancelApplication(){
                              axios.post(`/campaigns/${this.campaignId}/applications/${this.campaignApplicationId}/cancel`).then(res => {
                                alert(res.data.message);
                                if(res.data.status == 'SUCCESS'){
                                    window.location.href = `/campaigns/${this.campaignId}`;
                                }
                              }).catch(err => {
                                alert(err.response.data.message);
                              });
                            }
                          }
                        </script>
                    @endif
                    @if($campaignApplication->status == \App\Enums\Campaign\ApplicationStatus::APPROVED->value)
                        <button type="submit" class="mt-3 bg-gray-900 text-white px-5 py-4 block text-center font-bold w-full">제출완료</button>
                    @elseif($campaignApplication->status == \App\Enums\Campaign\ApplicationStatus::POSTED->value)
                        <button type="submit" class="mt-3 bg-gray-900 text-white px-5 py-4 block text-center font-bold w-full">수정완료</button>
                    @endif
                @endif

                @if(request()->route()->getName() === 'campaign.application.create')
                    <button type="submit" class="bg-gray-900 text-white px-5 py-4 block text-center font-bold w-full">신청 제출</button>
                @endif

            @endif
        </div>
    </div>
</div>
