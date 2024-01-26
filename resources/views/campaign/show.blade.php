<x-app-layout>
    <div class="container mx-auto px-6" x-data="campaignData">
        <div class="grid grid-cols-8 gap-6 relative">
            <div class="col-span-8 lg:col-span-6 lg:border-r lg:pr-6">
                <div>
                    <h1 class="font-bold text-[32px] my-3">[{{ $campaign->locations[0]->name }}] {{ $campaign->product_name }}</h1>
                    <div class="font-bold text-gray-500">{{ $campaign->title }}</div>
                    <div class="flex gap-3 mt-3">
                        @foreach($campaign->media as $media)
                            @switch($media->meta_value)
                                @case(App\Enums\Campaign\Media::NAVER_BLOG->value)
                                    <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="">
                                    @break
                                @case(App\Enums\Campaign\Media::INSTAGRAM->value)
                                    <img src="{{ Vite::asset('resources/images/media/instagram.svg') }}" alt="">
                                    @break
                                @case(App\Enums\Campaign\Media::YOUTUBE->value)
                                    <img src="{{ Vite::asset('resources/images/media/youtube.svg') }}" alt="">
                                    @break
                            @endswitch
                        @endforeach

                        @foreach($campaign->options as $option)
                        <div class="p-1 text-xs border text-gray-600">{{ $option->name }}</div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-6 border-b mb-6 flex">
                    <a href="{{ route('campaigns.show', 1) }}" class="block px-5 py-3 border-b-2 border-indigo-400 font-bold">캠페인 정보</a>
                    <a href="{{ route('campaigns.applicants', 1) }}" class="block px-5 py-3 text-gray-500">
                        <span>신청자 </span><span class="font-bold">4,000</span><span>/</span><span>{{ number_format($campaign->application_limit) }}</span>
                    </a>
                </div>
                <div>
                    <div class="overflow-hidden" :class="{'h-[800px]' : !showMore}">
                        <img src="https://placeholder.co/1200x600" alt="">
                        <img src="https://placeholder.co/1200x600" alt="">
                        <img src="https://placeholder.co/1200x600" alt="">
                    </div>
                    <button class="p-3 text-center border-y my-3 text-gray-500 font-bold block w-full flex justify-center items-center" @click.prevent="showMore = true" x-show="!showMore">
                        <span class="mr-2">상세이미지 더보기</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M6 9l6 6l6 -6" />
                        </svg>
                    </button>
                    <div>
                        <div class="flex py-6" id="benefit">
                            <div class="shrink-0 w-[160px] font-bold mr-3">제공 내역</div>
                            <div class="w-full border-b pb-6">
                                {{ $campaign->benefit }}
                                <div class="text-sm text-red-500 mt-6">
                                    ※ 옵션 오기재로 인한 교환/취소 불가하며, 해당 사유 발생 시 관련 페널티 부과 및 배송비, 제품가 환불 요청 등이 이루어질 수 있습니다. 이 점 유의하시어 반드시 정확하게 기재 바랍니다.
                                </div>
                            </div>
                        </div>
                        <div class="flex py-6" id="visit_instruction">
                            <div class="shrink-0 w-[160px] font-bold mr-3">방문 및 예약안내</div>
                            <div class="w-full border-b pb-6">{{ $campaign->visit_instruction }}</div>
                        </div>
                        <div class="flex py-6" id="mission">
                            <div class="shrink-0 w-[160px] font-bold mr-3">캠페인 미션</div>
                            <div class="w-full border-b pb-6">
                                <ul class="flex gap-x-3 mb-3">
                                    @foreach($campaign->missions as $mission)
                                    <li>{{ $mission->name }}</li>
                                    @endforeach
                                </ul>
                                <hr class="my-6">
                                <div>{{ $campaign->mission }}</div>

                                <div class="text-sm text-gray-500 mt-6">
                                    <p>- 캠페인 미션이 지켜지지 않을 시 수정 요청이 있을 수 있습니다.</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex py-6" id="keyword">
                            <div class="shrink-0 w-[160px] font-bold mr-3">키워드</div>
                            <div class="w-full border-b pb-6">
                                <div>
                                    <div class="font-bold mb-3">제목 키워드</div>
                                    <div>{{ $campaign->titleKeyword[0]->meta_value }}</div>
                                    <div class="text-sm text-gray-500 mt-6">
                                        <p>- 안내드린 제목 키워드를 콘텐츠 제목에 꼭 넣어주세요. #태그에도 넣어주시면 더욱 좋아요.</p>
                                        <p>- 키워드가 지켜지지 않으면 수정요청이 있을 수 있습니다.</p>
                                    </div>
                                </div>
                                <hr class="my-6">
                                <div>
                                    <div class="font-bold mb-3">본문 키워드</div>
                                    <div>{{ $campaign->titleKeyword[0]->meta_value }}</div>
                                    <div class="text-sm text-gray-500 mt-6">
                                        <p>- 안내드린 본문키워드 중 1개 이상을 선택하여 총 5회 이상 본문에 언급해 주세요.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex py-6" id="extra_information">
                            <div class="shrink-0 w-[160px] font-bold mr-3">링크</div>
                            <div class="w-full pb-6">
                                <div>
                                    <ul>
                                        @foreach($campaign->links as $link)
                                        <li>
                                            <a href="{{ $link->meta_value }}">{{ $link->meta_value }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="text-sm text-gray-500 mt-6">
                                    <p>- 안내드린 링크를 본문에 포함해주세요.</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex py-6" id="extra_information">
                            <div class="shrink-0 w-[160px] font-bold mr-3">추가 안내사항</div>
                            <div class="w-full pb-6">{{ $campaign->extra_information }}</div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-span-8 lg:col-span-2">
                <div class="lg:sticky lg:top-0">
                    <div class="py-6 border-b">
                        <div class="flex font-bold my-2">
                            <div class="shrink-0 w-[110px] mr-1">캠페인 신청기간</div>
                            <div>{{ $campaign->application_start_at->format('m.d') }} ~ {{ $campaign->application_end_at->format('m.d') }}</div>
                        </div>
                        <div class="flex text-gray-500 my-2">
                            <div class="shrink-0 w-[110px] mr-1">인플루언서 발표</div>
                            <div>{{ $campaign->announcement_at->format('m.d') }}</div>
                        </div>
                        <div class="flex text-gray-500 my-2">
                            <div class="shrink-0 w-[110px] mr-1">콘텐츠 등록기간</div>
                            <div>{{ $campaign->registration_start_date_at->format('m.d') }} ~ {{ $campaign->registration_end_date_at->format('m.d') }}</div>
                        </div>
                        <div class="flex text-gray-500 my-2">
                            <div class="shrink-0 w-[110px] mr-1">콘텐츠 결과발표</div>
                            <div>{{ $campaign->result_announcement_date_at->format('m.d') }}</div>
                        </div>
                    </div>
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
                    <div class="py-6">
                        <a href="" class="bg-gray-900 text-white px-5 py-4 block text-center font-bold">캠페인 신청하기</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
      const campaignData = {
        showMore: false,
        clickTabHandle(name){
          this.currentTab = name;
        }
      }
    </script>
</x-app-layout>
