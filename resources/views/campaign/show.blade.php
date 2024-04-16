<x-app-layout>
    <div class="container mx-auto px-6" x-data="campaignData">
        <div class="grid grid-cols-8 gap-6 relative">
            <div class="col-span-8 lg:col-span-6 lg:border-r lg:pr-6">
                @if($campaign->locationCategories)
                <div>
                    <h1 class="font-bold text-[32px] my-3">@if($campaign->locationCategories->count() > 0)[{{ $campaign->locationCategories[0]->name }}]@endif {{ $campaign->product_name }}</h1>
                    <div class="font-bold text-gray-500">{{ $campaign->title }}</div>
                    <div class="flex items-center gap-2 mt-3">
                        @foreach($campaign->media as $media)
                            <x-media-icon :media="$media"></x-media-icon>
                        @endforeach

                        @foreach($campaign->options as $option)
                            <div class="p-1 text-xs border text-gray-600">{{ $option->name }}</div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="mt-6 border-b mb-6 flex">
                    <a href="{{ route('campaign.show', $campaign) }}"
                       class="block px-5 py-3 border-b-2 border-indigo-400 font-bold">캠페인 정보</a>
                    <a href="{{ route('campaign.application.index', $campaign) }}" class="block px-5 py-3 text-gray-500">
                        <span>신청자 </span><span
                                class="font-bold">{{ number_format($campaign->applications()->activeCount()->count()) }}</span><span>/</span><span>{{ number_format($campaign->application_limit) }}</span>
                    </a>
                </div>
                <div>
                    @if(is_countable($campaign->detailimages) && count($campaign->detailimages) > 0)
                    <div class="overflow-hidden" :class="{'h-[800px]' : !showMore}">
                        @foreach($campaign->detailimages as $image)
                        <img src="{{ Storage::url($image['file_path']) }}" alt="">
                        @endforeach
                    </div>
                    <button class="p-3 text-center border-y my-3 text-gray-500 font-bold block w-full flex justify-center items-center"
                            @click.prevent="showMore = true" x-show="!showMore">
                        <span class="mr-2">상세이미지 더보기</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down"
                             width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M6 9l6 6l6 -6"/>
                        </svg>
                    </button>
                    @endif
                    <div>
                        <div class="flex py-6" id="benefit">
                            <div class="shrink-0 w-[160px] font-bold mr-3">제공 내역</div>
                            <div class="w-full border-b pb-6">
                                {{ $campaign->benefit }}
                                <div class="text-sm text-red-500 mt-6">
                                    ※ 옵션 오기재로 인한 교환/취소 불가하며, 해당 사유 발생 시 관련 페널티 부과 및 배송비, 제품가 환불 요청 등이 이루어질 수 있습니다. 이 점
                                    유의하시어 반드시 정확하게 기재 바랍니다.
                                </div>
                            </div>
                        </div>
                        @if(!$campaign->isShippingType)
                        <div class="flex py-6" id="visit_instruction">
                            <div class="shrink-0 w-[160px] font-bold mr-3">방문 및 예약안내</div>
                            <div class="w-full border-b pb-6">
                                <div>{{ $campaign->visit_instruction }}</div>
                                @if($campaign->lat && $campaign->long)
                                <div class="mt-6">
                                    <div id="map"
                                         x-ref="map"
                                         x-data="mapData"
                                         data-address="{{$campaign->address}}"
                                         class="mt-6 w-full h-[300px]"></div>
                                    <div class="mt-3 text-gray-500">
                                        <div>
                                            <span>({{ $campaign->address_postcode }})</span> <span>{{ $campaign->address }}</span> <span>{{ $campaign->address_extra }}</span> <span>{{ $campaign->address_detail }}</span>
                                        </div>
                                    </div>
                                    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=509c2656c00fa9af4782197a888763f6&libraries=services,clusterer,drawing?autoload=false"></script>
                                    <script>
                                        const mapData = {
                                          lat: '{{ $campaign->lat }}',
                                          long: '{{ $campaign->long }}',
                                          mapObject: null,
                                          init(){
                                            this.initMap();
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

                                            //컨트롤러
                                            let mapTypeControl = new kakao.maps.MapTypeControl();
                                            this.mapObject.addControl(mapTypeControl, kakao.maps.ControlPosition.TOPRIGHT);

                                            // 줌
                                            let zoomControl = new kakao.maps.ZoomControl();
                                            this.mapObject.addControl(zoomControl, kakao.maps.ControlPosition.RIGHT);
                                          },
                                        }
                                    </script>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="flex py-6" id="mission">
                            <div class="shrink-0 w-[160px] font-bold mr-3">캠페인 미션</div>
                            <div class="w-full border-b pb-6">
                                <ul class="flex flex-wrap gap-3 mb-3">
                                    @foreach($campaign->missionOptions as $missionOption)
                                        <li class="border p-2 text-sm rounded-lg">{{ $missionOption->mission_name }}</li>
                                    @endforeach
                                </ul>
                                <hr class="my-6">
                                <div>{{ $campaign->mission }}</div>

                                <div class="text-sm text-gray-500 mt-6">
                                    <p>- 캠페인 미션이 지켜지지 않을 시 수정 요청이 있을 수 있습니다.</p>
                                </div>
                            </div>
                        </div>
                        @if(count($campaign->keywords) > 0)
                            <div class="flex py-6" id="keyword">
                                <div class="shrink-0 w-[160px] font-bold mr-3">키워드</div>
                                <div class="w-full border-b pb-6">
                                    @foreach($campaign->keywords as $keyword)
                                        @if($loop->index > 0)
                                            <hr class="my-6">
                                        @endif
                                        <div>
                                            <div class="font-bold mb-3">{{ $keyword->missionOption->option_value }}</div>
                                            <div>{{ $keyword->content }}</div>
                                            <div class="text-sm text-gray-500 mt-6">
                                                <p>- 안내드린 제목 키워드를 콘텐츠 제목에 꼭 넣어주세요. #태그에도 넣어주시면 더욱 좋아요.</p>
                                                <p>- 키워드가 지켜지지 않으면 수정요청이 있을 수 있습니다.</p>
                                                @if($keyword->missionOption->extra_value1 && $keyword->missionOption->extra_value2)
                                                    <p>- 안내드린 {{ $keyword->missionOption->option_value }}
                                                        중 {{$keyword->missionOption->extra_value1 }}개 이상을 선택하여
                                                        총 {{$keyword->missionOption->extra_value2}}회 이상 본문에 언급해 주세요.</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if(count($campaign->link) > 0)
                            <div class="flex py-6" id="extra_information">
                                <div class="shrink-0 w-[160px] font-bold mr-3">링크</div>
                                <div class="w-full pb-6">
                                    <div>
                                        <ul>
                                            @foreach($campaign->links as $link)
                                                <li>
                                                    <a href="{{ $link->content }}"
                                                       target="_blank">{{ $link->content }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-6">
                                        <p>- 안내드린 링크를 본문에 포함해주세요.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($campaign->hashtag)
                            <div class="flex py-6" id="extra_information">
                                <div class="shrink-0 w-[160px] font-bold mr-3">해시태그</div>
                                <div class="w-full pb-6">
                                    @foreach($campaign->hashtag as $hashtag)
                                    <div>{{ $hashtag['content'] }}</div>
                                    @endforeach
                                    <div class="text-sm text-gray-500 mt-6">
                                        <p>- 안내드린 해시태그를 본문에 포함해주세요.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="flex py-6" id="extra_information">
                            <div class="shrink-0 w-[160px] font-bold mr-3">추가 안내사항</div>
                            <div class="w-full pb-6">{{ $campaign->extra_information }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <x-campaign.sidecar :campaign="$campaign" :useLink="true" :campaignApplication="$campaignApplication"></x-campaign.sidecar>
        </div>
    </div>
    <script>
      const campaignData = {
        showMore: false,
        clickTabHandle(name) {
          this.currentTab = name;
        }
      }
    </script>
</x-app-layout>
