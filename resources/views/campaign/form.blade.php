<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=509c2656c00fa9af4782197a888763f6&libraries=services,clusterer,drawing?autoload=false"></script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<div class="container mx-auto p-6" x-data="campaignData">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @method($method)
        @csrf
        <input type="hidden" name="id" value="{{ $campaign->id }}">
        <section class="mb-16">
            <h1 class="h3 mb-6">캠페인 설정</h1>
            <div class="border-t border-stone-900 py-3">
                <div class="grid md:grid-cols-2 divide-y">
                    <div class="col-span-2 py-6">
                        <label class="label mb-2 text-base">상태</label>
                        <select name="status" id="status" class="form-select">
                            @foreach(App\Enums\Campaign\StatusEnum::cases() as $status)
                                <option value="{{ $status->name }}" @selected($status->name == old('status', $campaign->status))>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="status" class="mt-1"></x-input-error>
                    </div>
                    <div class="col-span-2 py-6">
                        <label class="label mb-2 text-base">유형</label>
                        <ul class="flex gap-3">
                            @foreach($campaignTypes as $campaignType)
                                <li>
                                    <x-radio-button id="type_{{$campaignType->id}}"
                                                    name="type"
                                                    :value="$campaignType->id"
                                                    xmodel="type">{{ $campaignType->name }}</x-radio-button>
                                </li>
                            @endforeach
                        </ul>
                        <x-input-error for="type" class="mt-1"></x-input-error>
                    </div>
                    <div class="col-span-2 py-6">
                        <label class="label mb-2 text-base">제품 카테고리</label>
                        <ul class="flex flex-wrap gap-3">
                            @foreach($productCategory->categories as $category)
                                <li>
                                    <x-checkbox-button id="product_category_{{$category->id}}"
                                                       name="product_category[]"
                                                       :value="$category->id"
                                                       :checked="in_array($category->id, old('product_category', $campaign->productCategories->pluck('id')->toArray()))">{{ $category->name }}</x-checkbox-button>
                                </li>
                            @endforeach
                        </ul>
                        <x-input-error for="product_category" class="mt-1"></x-input-error>
                    </div>
                    <div class="col-span-2 py-6">
                        <label class="label mb-2 text-base">비즈니스</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="" disabled selected>선택</option>
                            @foreach($businessUsers as $businessUser)
                                <option value="{{ $businessUser->id }}" @selected($businessUser->id === $campaign->user_id)>{{ $businessUser->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="user_id" class="mt-1"></x-input-error>
                        <script defer>
                          window.onload = function(){
                            $(document).ready(function(){
                              $(".form-select").select2();
                            });
                          }
                        </script>
                    </div>
                    <div class="col-span-2 py-6">
                        <label class="label mb-2 text-base">제퓸 유형</label>
                        <ul class="flex flex-wrap gap-3">
                            @foreach($typeCategory->categories as $category)
                                <li>
                                    <x-checkbox-button id="product_category_{{$category->id}}"
                                                       name="type_category[]"
                                                       :value="$category->id"
                                                       :checked="in_array($category->id, old('type_category', $campaign->typeCategories->pluck('id')->toArray()))">{{ $category->name }}</x-checkbox-button>
                                </li>
                            @endforeach
                        </ul>
                        <x-input-error for="type_category" class="mt-1"></x-input-error>
                    </div>
                    <template x-if="type == 1">
                    <div class="col-span-2 py-6">
                        <label class="label mb-4">지역 카테고리</label>
                        <div>
                            @foreach($locationCategory->categories as $category)
                                <div class="mb-6">
                                    <div class="mb-3 text-sm">{{ $category->name }}</div>
                                    <ul class="flex flex-wrap gap-3">
                                        @foreach($category->categories as $location)
                                            <li>
                                                <x-checkbox-button id="location_category_{{$location->id}}"
                                                                   name="location_category[]"
                                                                   :value="$location->id"
                                                                   :checked="in_array($location->id, old('location_category', $campaign->locationCategories->pluck('id')->toArray()))">{{ $location->name }}</x-checkbox-button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                            <x-input-error for="location_category" class="mt-1"></x-input-error>
                        </div>
                    </div>
                    </template>
                </div>
            </div>
        </section>
        <section class="mb-16">
            <h1 class="h3 mb-6">이미지</h1>
            <div class="border-t border-stone-900 py-3">
                <div class="grid md:grid-cols-2 divide-y">
                    <div class="col-span-2 py-6">
                        <label class="label mb-2 text-base">대표이미지</label>
                        <input type="file" name="thumbnails[]" class="form-control" multiple>
                        <x-input-error for="thumbnails" class="mt-1"></x-input-error>
                    </div>
                    <div class="col-span-2 py-6">
                        <label class="label mb-2 text-base">상세이미지</label>
                        <input type="file" name="detail_images[]" class="form-control" multiple>
                        <x-input-error for="detail_images" class="mt-1"></x-input-error>
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-16">
            <h1 class="h3 mb-6">캠페인 정보</h1>
            <div class="border-t border-stone-900 py-3">
                <div class="grid md:grid-cols-2 divide-y gap-x-3">
                    <div class="col-span-2 py-6">
                        <label for="media" class="label mb-2">미디어</label>
                        <ul class="flex flex-wrap gap-3">
                        @foreach(\App\Enums\Campaign\MediaEnum::cases() as $index => $media)
                            <li>
                                <x-checkbox-button id="media_{{$index}}"
                                                   name="media[]"
                                                   :value="$media->value"
                                                   :checked="in_array($media->value, old('media', $campaign->media->pluck('media')->toArray()))">{{ $media->label() }}</x-checkbox-button>
                            </li>
                        @endforeach
                        </ul>
                        <x-input-error for="media" class="mt-1"></x-input-error>
                    </div>

                    <div class="col-span-2 py-6">
                        <label for="title" class="label mb-2">캠페인 제목</label>
                        <input type="text" id="title" class="form-control" name="title" value="{{old('title', $campaign['title'])}}">
                        <x-input-error for="title" class="mt-1"></x-input-error>
                    </div>
                    <div class="col-span-2 py-6">
                        <label for="product_name" class="label mb-2">상품명</label>
                        <input type="text" id="product_name" class="form-control" name="product_name" value="{{ old('product_name', $campaign['product_name']) }}">
                        <x-input-error for="product_name" class="mt-1"></x-input-error>
                    </div>
                    <div class="col-span-2 py-6">
                        <label for="product_url" class="label mb-2">상품주소</label>
                        <input type="text" id="product_url" class="form-control" name="product_url" value="{{ old('product_url', $campaign['product_url']) }}">
                        <x-input-error for="product_name" class="mt-1"></x-input-error>
                    </div>
                    <div class="col-span-2 py-6">
                        <label for="benefit" class="label mb-2">제공내역</label>
                        <textarea id="benefit" name="benefit" class="form-control" cols="30" rows="10">{{ old('benefit', $campaign['benefit']) }}</textarea>
                        <x-input-error for="benefit" class="mt-1"></x-input-error>
                    </div>
                    <div class="col-span-2 py-6">
                        <label for="application_limit" class="label mb-2">모집인원</label>
                        <input type="number" id="application_limit" class="form-control" name="application_limit" value="{{ old('application_limit', $campaign['application_limit']) }}">
                        <x-input-error for="product_name" class="mt-1"></x-input-error>
                    </div>
                    <div class="col-span-2 py-6 flex gap-3">
                        <div class="w-1/2">
                            <label for="application_start_at" class="label mb-2">신청 시작일</label>
                            <input type="date" id="application_start_at" class="form-control" name="application_start_at" value="{{ old('application_start_at', $campaign['application_start_at'] ? $campaign['application_start_at']->format('Y-m-d') : null) }}">
                            <x-input-error for="application_start_at" class="mt-1"></x-input-error>
                        </div>
                        <div class="w-1/2">
                            <label for="application_end_at" class="label mb-2">신청 종료일</label>
                            <input type="date" id="application_end_at" class="form-control" name="application_end_at" value="{{ old('application_end_at', $campaign['application_end_at'] ? $campaign['application_end_at']->format('Y-m-d') : null) }}">
                            <x-input-error for="application_end_at" class="mt-1"></x-input-error>
                        </div>
                    </div>
                    <div class="col-span-2 py-6 flex gap-3">
                        <div class="w-1/2">
                            <label for="announcement_at" class="label mb-2">선정결과 발표일</label>
                            <input type="date" id="announcement_at" class="form-control" name="announcement_at" value="{{ old('announcement_at', $campaign['announcement_at'] ? $campaign['announcement_at']->format('Y-m-d') : null) }}">
                            <x-input-error for="announcement_at" class="mt-1"></x-input-error>
                        </div>
                        <div class="w-1/2">
                            <label for="result_announcement_date_at" class="label mb-2">캠페인 결과 발표일</label>
                            <input type="date" id="result_announcement_date_at" class="form-control" name="result_announcement_date_at" value="{{ old('result_announcement_date_at', $campaign['result_announcement_date_at'] ? $campaign['result_announcement_date_at']->format('Y-m-d') : null) }}">
                            <x-input-error for="result_announcement_date_at" class="mt-1"></x-input-error>
                        </div>
                    </div>
                    <div class="col-span-2 py-6 flex gap-3">
                        <div class="w-1/2">
                            <label for="registration_start_date_at" class="label mb-2">콘텐츠 등록 시작일</label>
                            <input type="date" id="registration_start_date_at" class="form-control" name="registration_start_date_at" value="{{ old('registration_start_date_at', $campaign['registration_start_date_at'] ? $campaign['registration_start_date_at']->format('Y-m-d') : null) }}">
                            <x-input-error for="registration_start_date_at" class="mt-1"></x-input-error>
                        </div>
                        <div class="w-1/2">
                            <label for="registration_end_date_at" class="label mb-2">콘텐츠 등록 마감일</label>
                            <input type="date" id="registration_end_date_at" class="form-control" name="registration_end_date_at" value="{{ old('registration_end_date_at', $campaign['registration_end_date_at'] ? $campaign['registration_end_date_at']->format('Y-m-d') : null) }}">
                            <x-input-error for="registration_end_date_at" class="mt-1"></x-input-error>
                        </div>
                    </div>
                    <div class="col-span-2 py-6">
                        <label for="benefit_point" class="label mb-2">제공포인트</label>
                        <div class="flex gap-x-3">
                            <div class="flex items-center ps-4 border border-gray-200 rounded">
                                <input type="radio" value="n" name="use_benefit_point" id="use-benefit-point-false" class="form-radio" x-model="useBenefitPoint">
                                <label for="use-benefit-point-false" class="w-full p-4 text-sm font-medium">미제공</label>
                            </div>
                            <div class="flex items-center ps-4 border border-gray-200 rounded">
                                <input type="radio" value="y" name="use_benefit_point" id="use-benefit-point-true" class="form-radio" x-model="useBenefitPoint">
                                <label for="use-benefit-point-true" class="w-full p-4 text-sm font-medium">제공</label>
                            </div>
                            <x-input-error for="use_benefit_point" class="mt-1"></x-input-error>
                        </div>
                        <template x-if="useBenefitPoint === 'y'">
                            <div>
                                <input type="number" name="benefit_point" id="benefit_point" class="form-control mt-3" value="{{ old('point', $campaign['point']) }}">
                                <x-input-error for="benefit_point" class="mt-1"></x-input-error>
                            </div>
                        </template>
                    </div>
                    <template x-if="type == 1">
                        <div class="col-span-2">
                            <div class="col-span-2 py-6">
                                <div class="grid grid-cols-12 gap-6">
                                    <div class="col-span-3">
                                        <label for="address_postcode" class="label mb-2">우편번호</label>
                                        <input id="address_postcode"
                                               class="form-control"
                                               name="address_postcode"
                                               readonly
                                               x-model="addressPostcode"
                                               @click="execDaumPostcode">
                                        <x-input-error for="address_postcode" class="mt-1"></x-input-error>
                                    </div>
                                    <div class="col-span-9">
                                        <label for="address" class="label mb-2">주소</label>
                                        <div class="flex gap-3">
                                            <input id="address" class="form-control w-full" name="address" readonly x-model="address" @click="execDaumPostcode">
                                            <button type="button" class="button button-gray shrink-0 !m-0" @click.prevent="execDaumPostcode">주소찾기</button>
                                        </div>
                                        <x-input-error for="address" class="mt-1"></x-input-error>
                                    </div>
                                    <div class="col-span-12 relative border pt-6 bg-white" x-show="findAddress">
                                        <div x-ref="search_address_element">
                                            <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" @click="findAddress=false" alt="접기 버튼">
                                        </div>
                                    </div>
                                    <div class="col-span-12">
                                        <label for="address_detail" class="label mb-2">주소상세</label>
                                        <input id="address_detail" class="form-control" name="address_detail" x-model="addressDetail" x-ref="address_detail">
                                        <x-input-error for="address_detail" class="mt-1"></x-input-error>
                                    </div>
                                    <div class="col-span-12">
                                        <label for="address_extra" class="label mb-2">추가항목</label>
                                        <input id="address_extra" class="form-control" name="address_extra" x-model="addressExtra" x-ref="address_extra">
                                        <x-input-error for="address_detail" class="mt-1"></x-input-error>
                                    </div>
                                    <div class="col-span-12 bg-red-50 h-[300px] rounded-lg flex items-center justify-center" x-show="mapObject">
                                        <div id="map" x-ref="map" class="w-full h-[300px]"></div>
                                        <input type="hidden" name="lat" value="" x-model="lat">
                                        <input type="hidden" name="long" value="" x-model="long">
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2 py-6">
                                <label for="visit_instruction" class="label mb-2">방문 및 예약안내</label>
                                <textarea name="visit_instruction" id="visit_instruction" class="form-control" cols="30" rows="10">{{ old('visit_instruction', $campaign['visit_instruction']) }}</textarea>
                                <x-input-error for="visit_instruction" class="mt-1"></x-input-error>
                            </div>
                        </div>
                    </template>
                    <div class="col-span-2 py-6">
                        <label for="extra_information" class="label mb-2">추가안내사항</label>
                        <textarea name="extra_information" id="extra_information" class="form-control" cols="30" rows="10">{{ old('extra_information', $campaign->extra_information) }}</textarea>
                        <x-input-error for="extra_information" class="mt-1"></x-input-error>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-16">
            <h1 class="h3 mb-6">미션</h1>
            <div class="border-t border-stone-900 py-3">
                <div class="grid md:grid-cols-2 divide-y">
                    <div class="col-span-2 py-6">
                        <ul>
                            @foreach($missions as $mission)
                                @if($mission->options->count() > 1)
                                    <li class="mb-6">
                                        <div class="mb-3 text-sm">{{ $mission->name }}</div>
                                        <ul class="flex gap-3 flex-wrap">
                                            @foreach($mission->options as $option)
                                                <li>
                                                    <x-checkbox-button id="mission_option_{{$option->id}}"
                                                                       name="mission_options[]"
                                                                       :value="$option->id"
                                                                       xmodel="missionOptions">{{ $option->option_value }}</x-checkbox-button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach

                            <li class="mb-6">
                                <div class="mb-3 text-sm">기타</div>
                                <ul class="flex gap-3 flex-wrap">
                                    @foreach($missions as $mission)
                                        @if($mission->options[0]->option_value === null)
                                            <li>
                                                <x-checkbox-button id="mission_option_{{$mission->options[0]->id}}"
                                                                   name="mission_options[]"
                                                                   :value="$mission->options[0]->id"
                                                                   xmodel="missionOptions">{{ $mission->options[0]->option_name }}</x-checkbox-button>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        <x-input-error for="mission_options" class="mt-1"></x-input-error>
                    </div>
                    <template x-if="showInput(missionOptionId.titleKeyword)">
                        <div class="col-span-2 py-6">
                            <label for="mission_option_title_keyword" class="label mb-2">제목키워드</label>
                            <input type="text"
                                   id="mission_option_title_keyword"
                                   class="form-control"
                                   name="mission_option_title_keyword"
                                   value="{{ old('mission_option_title_keyword', $campaign->titleKeyword->first() ? $campaign->titleKeyword->first()->content : null) }}">
                            <x-input-error for="mission_option_title_keyword" class="mt-1"></x-input-error>
                        </div>
                    </template>
                    <template x-if="showInput(missionOptionId.contentKeyword)">
                        <div class="col-span-2 py-6">
                            <label for="mission_option_content_keyword" class="label mb-2">본문키워드</label>
                            <input type="text"
                                   id="mission_option_content_keyword"
                                   class="form-control"
                                   name="mission_option_content_keyword"
                                   value="{{ old('mission_option_content_keyword', $campaign->contentKeyword->first() ? $campaign->contentKeyword->first()->content : null) }}">
                            <x-input-error for="mission_option_content_keyword" class="mt-1"></x-input-error>
                        </div>
                    </template>
                    <template x-if="showInput(missionOptionId.link)">
                        <div class="col-span-2 py-6">
                            <label for="mission_option_link" class="label mb-2">링크삽입</label>
                            <input type="text"
                                   id="mission_option_link"
                                   class="form-control"
                                   name="mission_option_link"
                                   value="{{ old('mission_option_link', $campaign->link->first() ? $campaign->link->first()->content : null) }}">
                            <x-input-error for="mission_option_link" class="mt-1"></x-input-error>
                        </div>
                    </template>
                    <template x-if="showInput(missionOptionId.hashtag)">
                        <div class="col-span-2 py-6">
                            <label for="mission_option_hashtag" class="label mb-2">해시태그</label>
                            <input type="text"
                                   id="mission_option_hashtag"
                                   class="form-control"
                                   name="mission_option_hashtag"
                                   value="{{ old('mission_option_hashtag', $campaign->hashtag->first() ? $campaign->hashtag->first()->content : null) }}">
                            <x-input-error for="mission_option_hashtag" class="mt-1"></x-input-error>
                        </div>
                    </template>
                    <div class="col-span-2 py-6">
                        <label for="mission" class="label mb-2">미션설명</label>
                        <textarea id="mission" name="mission" class="form-control" cols="30" rows="10">{{old('mission', $campaign->mission)}}</textarea>
                        <x-input-error for="mission" class="mt-1"></x-input-error>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-16">
            <h1 class="h3 mb-6">신청정보</h1>
            <div class="border-t border-stone-900 py-3">
                <div class="grid md:grid-cols-2 divide-y">
                    <div class="col-span-2 py-6">
                        <label for="application_information" class="label mb-2 text-base">신청 안내</label>
                        <textarea id="application_information" name="application_information" class="form-control w-full" cols="30" rows="10">{{old('application_information', $campaign->application_information)}}</textarea>
                    </div>
                    <div class="col-span-2 py-6">
                        <label class="label mb-2 text-base">입력항목 선택</label>
                        <ul class="flex flex-wrap gap-3">
                            @foreach($customOptions as $customOption)
                                <li>
                                    <x-checkbox-button id="application_field_{{$customOption->value}}"
                                                       name="application_field[]"
                                                       value="{{$customOption->value}}"
                                                       xmodel="application_field">{{ $customOption->label()['label'] }}</x-checkbox-button>
                                </li>
                            @endforeach
                        </ul>
                        <x-input-error for="application_field" class="mt-1"></x-input-error>
                    </div>
                    <template x-if="application_field.includes('custom_option')">
                        <div class="col-span-2 py-6">
                            <label for="" class="label mb-2">상품옵션</label>
                            <div>
                                <template x-for="(item, index) in customOptions">
                                    <div class="grid grid-cols-2 gap-3 py-1">
                                        <input type="hidden" :name="`custom_option[${index}][id]`" id="" class="form-control" x-model="item.id">
                                        <input type="text" :name="`custom_option[${index}][name]`" id="" class="form-control" placeholder="옵션명" x-model="item.name">
                                        <div class="flex gap-3">
                                            <input type="text" :name="`custom_option[${index}][value]`" id="" class="form-control" placeholder="예)빨강, 노랑" x-model="item.value">
                                            <template x-if="customOptions.length > 1">
                                                <button type="button" class="button button-gray-outline shrink-0" @click="removeCustomOption(index)">삭제</button>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <div class="text-center mt-3">
                                    <button type="button" @click.prevent="addCustomOption">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-rounded-plus" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                            <path d="M15 12h-6" />
                                            <path d="M12 9v6" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <div class="text-center">
            <button class="button button-light" @click="window.location.href='/'">취소</button>
            <button type="submit" class="button button-default">저장</button>
        </div>
    </form>
</div>
<script>
  const campaignData = {
    type: '{{old('type', $campaign['campaign_type_id'] ?? 1 )}}',
    useBenefitPoint: '{{ old('use_benefit_point', ($campaign['use_benefit_point'] ? 'y' : 'n') ?? 'n' ) }}',
    addressPostcode: '{{ old('address_postcode', $campaign['address_postcode']) }}',
    address: '{{ old('address', str_replace("\n", '', $campaign['address'])) }}',
    addressDetail: '{{ old('address_detail', $campaign['address_detail']) }}',
    addressExtra: '{{ old('address_extra', $campaign['address_extra']) }}',
    findAddress: false,
    mapElement: '',
    mapObject: null,
    showMap: true,
    lat: '{{ old('lat', $campaign['lat']) }}',
    long: '{{ old('long', $campaign['long']) }}',
    marker: null,
    missionOptions: @json(old('mission_options', $campaign->missionOptions->pluck('id')->toArray())),
    application_field: @json(old('application_field', $campaign->applicationFields->pluck('name')->toArray())),
    customOptions: @json(old('custom_option', \App\Helper\CommonHelper::makeCustomOptionByModel($campaign->customOptions))),
    customOption: {
      id: null,
      name: null,
      value: null,
    },
    missionOptionId: {
      titleKeyword: '{{ App\Enums\Campaign\MissionOptionEnum::TITLE_KEYWORD_ID_OF_MISSION_OPTION->value }}',
      contentKeyword: '{{ App\Enums\Campaign\MissionOptionEnum::CONTENT_KEYWORD_ID_OF_MISSION_OPTION->value }}',
      link: '{{ App\Enums\Campaign\MissionOptionEnum::LINK_ID_OF_MISSION_OPTION->value }}',
      hashtag: '{{ App\Enums\Campaign\MissionOptionEnum::HASHTAG_ID_OF_MISSION_OPTION->value }}',
    },
    init(){
      this.mapelement = this.$refs.map;
      if(this.lat && this.long){
        this.initMap();
      }

      if(this.customOptions.length === 0){
        this.customOptions = [{...this.customOption}]
      }

      this.$watch('type', (value, old) => {
        console.log(value, old);
      });
    },
    showInput(optionId){
      for (let i = 0; i < this.missionOptions.length; i++) {
        let missionOptionId = this.missionOptions[i];
        if (missionOptionId == optionId || missionOptionId === optionId.toString()) {
          return true;
        }
      }
      return false;
    },
    addCustomOption(){
      this.customOptions = [...this.customOptions, {...this.customOption}]
    },
    removeCustomOption(index){
      this.customOptions = this.customOptions.filter((item, i) => {
        console.log(i, index);
        return i !== index;
      });
    },
    initMap(){
      this.mapObject = new daum.maps.Map(this.$refs.map, {
        center: new daum.maps.LatLng(this.lat, this.long),
        level: 5,
      });

      //마커를 미리 생성
      this.marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(this.lat, this.long),
        map: this.mapObject
      });
    },
    setMap(address){
      this.initMap();
      let geocoder = new daum.maps.services.Geocoder();
      geocoder.addressSearch(address, (results, status) => {
        // 정상적으로 검색이 완료됐으면
        if (status === daum.maps.services.Status.OK) {
          let result = results[0]; //첫번째 결과의 값을 활용
          this.lat = result.y;
          this.long = result.x;
          // 해당 주소에 대한 좌표를 받아서
          let coords = new daum.maps.LatLng(this.lat, this.long);
          // 지도를 보여준다.
          this.mapObject.relayout();
          // 지도 중심을 변경한다.
          this.mapObject.setCenter(coords);
          // 마커를 결과값으로 받은 위치로 옮긴다.
          this.marker.setPosition(coords)
        }
      });
    },
    execDaumPostcode(){
      this.findAddress = true;
      var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
      new daum.Postcode({
        oncomplete: (data) => {
          // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

          // 각 주소의 노출 규칙에 따라 주소를 조합한다.
          // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
          var addr = ''; // 주소 변수
          var extraAddr = ''; // 참고항목 변수

          //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
          if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
            addr = data.roadAddress;
          } else { // 사용자가 지번 주소를 선택했을 경우(J)
            addr = data.jibunAddress;
          }

          // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
          if(data.userSelectedType === 'R'){
            // 법정동명이 있을 경우 추가한다. (법정리는 제외)
            // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
            if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
              extraAddr += data.bname;
            }
            // 건물명이 있고, 공동주택일 경우 추가한다.
            if(data.buildingName !== '' && data.apartment === 'Y'){
              extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
            }
            // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
            if(extraAddr !== ''){
              extraAddr = ' (' + extraAddr + ')';
            }
            // 조합된 참고항목을 해당 필드에 넣는다.
            this.addressExtra = extraAddr;

          } else {
            this.addressExtra = '';
          }

          // 우편번호와 주소 정보를 해당 필드에 넣는다.
          this.addressPostcode = data.zonecode;
          this.address = addr;
          // 커서를 상세주소 필드로 이동한다.
          this.$refs.address_detail.focus();

          // iframe을 넣은 element를 안보이게 한다.
          // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
          this.findAddress = false;

          // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
          document.body.scrollTop = currentScroll;

          this.setMap(this.address);
        },
        // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
        onresize : (size) => {
          this.$refs.search_address_element.style.height = size.height+'px';
        },
        width : '100%',
        height : '100%'
      }).embed(this.$refs.search_address_element);
    }
  }
</script>
