<x-app-layout>
    <div class="container mx-auto px-6" x-data="campaignData">
        <form action="{{ route('campaigns.application.post', $campaign) }}" method="POST">
            @csrf
            @method('POST')
            <div class="grid grid-cols-8 gap-6 relative break-keep">
                <div class="col-span-8 lg:col-span-6 lg:border-r lg:pr-6">
                    <div>
                        <h1 class="font-bold text-[32px] my-3">캠페인 신청하기</h1>
                    </div>
                    <div>
                        <div class="flex py-6">
                            <div class="shrink-0 w-[160px] font-bold mr-3">상품링크</div>
                            <div class="w-full border-b pb-6">
                                <a href="{{ $campaign->product_url }}" target="_blank" class="text-blue-600">{{ $campaign->product_url }}</a>
                            </div>
                        </div>
                        <div class="flex py-6">
                            <div class="shrink-0 w-[160px] font-bold mr-3">제공내역</div>
                            <div class="w-full border-b pb-6">
                                {{ $campaign->benefit }}
                                <div class="text-sm text-red-500 mt-6">
                                    ※ 옵션 오기재로 인한 교환/취소 불가하며, 해당 사유 발생 시 관련 페널티 부과 및 배송비, 제품가 환불 요청 등이 이루어질 수 있습니다. 이 점
                                    유의하시어 반드시 정확하게 기재 바랍니다.
                                </div>
                            </div>
                        </div>
                        @if($campaign->useShipping)
                        <div class="flex py-6">
                            <div class="shrink-0 w-[160px] font-bold mr-3">방문 및 예약안내</div>
                            <div class="w-full border-b pb-6">
                                <div>
                                    {{ $campaign->visit_instruction }}
                                </div>
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
                            </div>
                        </div>
                        @endif
                        <div class="flex py-6">
                            <div class="shrink-0 w-[160px] font-bold mr-3">회원 기본 정보</div>
                            <div class="w-full border-b pb-6">
                                <div>
                                    <label for="name" class="label mb-2">이름</label>
                                    <input type="text" name="name" class="form-control"
                                           value="{{ auth()->user()->name }}" id="name">
                                </div>
                                <div class="my-4">
                                    <label for="birthdate" class="label mb-2">출생연도</label>
                                    <select name="birthdate" id="birthdate" class="form-select">
                                        <option value="">선택해주세요</option>
                                        @foreach(array_reverse(range(1923, date('Y'))) as $year)
                                            <option value="{{ $year }}" @selected($year == auth()->user()->birthdate)>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="my-4">
                                    <label for="sex" class="label mb-2">성별</label>
                                    <div class="flex gap-3">
                                        <x-radio-button id="man" name="sex" value="man"
                                                        :checked="auth()->user()->sex == 'man'">남자
                                        </x-radio-button>
                                        <x-radio-button id="woman" name="sex" value="woman"
                                                        :checked="auth()->user()->sex == 'woman'">여자
                                        </x-radio-button>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <label for="phone" class="label mb-2">연락처</label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ auth()->user()->phone }}" id="phone"
                                           @keyup="event.target.value = event.target.value.replace(/\D/g, '').replace(/(\d{3})(\d{1,4})(\d{1,4})/, '$1-$2-$3')">
                                </div>
                            </div>
                        </div>
                        @foreach($campaign->media as $media)
                            <div class="flex py-6">
                                <div class="shrink-0 w-[160px] font-bold mr-3">{{ App\Enums\Campaign\MediaEnum::tryFrom($media->media)->label() }}
                                    연결
                                </div>
                                <div class="w-full border-b pb-6">
                                    <div>콘텐츠를 작성할 {{ App\Enums\Campaign\MediaEnum::tryFrom($media->media)->label() }}를 등록해주세요. 등록한 정보는 선정 후 변경할 수 없습니다.</div>
                                    <button class="button button-light flex gap-3 mt-4 items-center">
                                        @switch($media->media)
                                            @case(App\Enums\Campaign\MediaEnum::NAVER_BLOG->value)
                                                <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="">
                                                @break
                                            @case(App\Enums\Campaign\MediaEnum::INSTAGRAM->value)
                                                <img src="{{ Vite::asset('resources/images/media/instagram.svg') }}"
                                                     alt="">
                                                @break
                                            @case(App\Enums\Campaign\MediaEnum::YOUTUBE->value)
                                                <img src="{{ Vite::asset('resources/images/media/youtube.svg') }}"
                                                     alt="" class="w-[20px]">
                                                @break
                                        @endswitch
                                        <span>{{ App\Enums\Campaign\MediaEnum::tryFrom($media->media)->label() }} 연결하기</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex py-6">
                            <div class="shrink-0 w-[160px] font-bold mr-3">신청 정보 입력</div>
                            <div class="w-full pb-6">
                                @if($campaign->application_information)
                                <div class="application-category">
                                    <div class="application-category-content !mt-0">
                                        {{ $campaign->application_information }}
                                    </div>
                                </div>
                                @endif

                                {{-- 선택한 옵션이 있으면 노출 --}}
                                <div class="application-category mt-10">
                                    <div class="application-category-title">신청 옵션을 입력해주세요.</div>
                                    @foreach($campaign->applicationFields as $field)
                                        <input type="hidden" name="application_field[{{ $field->id }}][id]" value="{{ $field->id }}">
                                        <div class="application_field">
                                            <div class="application_field-item mt-3">
                                                <div class="application_field-title">{{ $field->label }}</div>
                                                @if($field->name === 'custom_option')
                                                    <select name="application_field[{{ $field->id }}][value]" id="" class="form-select">
                                                        @foreach(explode(',', $field->option) as $option)
                                                            <option value="{{ $option }}">{{ $option }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif($field->type === 'text')
                                                    <input type="text" name="application_field[{{ $field->id }}][value]" class="form-control">
                                                @elseif($field->type === 'selectbox')
                                                    <select name="application_field[{{ $field->id }}][value]" id="" class="application_field-input form-select">
                                                        <option value="">선택</option>
                                                        @foreach(unserialize($field->option) as $option)
                                                            <option value="{{$option['value']}}">{{ $option['label'] }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif($field->type === 'radio')
                                                    <div class="flex gap-3">
                                                        @foreach(unserialize($field->option) as $key => $option)
                                                            <x-radio-button id="{{ $option['name'].$key }}"
                                                                            name="application_field[{{ $field->id }}][value]"
                                                                            value="{{$option['value']}}">{{ $option['label'] }}</x-radio-button>
                                                        @endforeach
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if($campaign->useShipping)
                                {{-- 배송형 캠페인만 노출 --}}
                                <div class="application-category mt-10">
                                    <div class="application-category-title">상품을 배송받을 주소를 입력해 주세요.</div>
                                    <div class="application_field">
                                        <div class="application_field-item mt-5">
                                            <div class="flex gap-3">
                                                <x-radio-button id="man" name="sex" value="man">집
                                                </x-radio-button>
                                                <x-radio-button id="woman" name="sex" value="woman">새로입력하기
                                                </x-radio-button>
                                            </div>
                                            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <div class="">
                                                    <label for="" class="label">이름</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="">
                                                    <label for="" class="label">연락처</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="mt-5">
                                                <div>
                                                    <div class="flex gap-3">
                                                        <input type="text" class="form-control" placeholder="우편번호">
                                                        <button class="button button-light shrink-0">우편번호 찾기</button>
                                                    </div>
                                                </div>
                                                <div class="mt-1">
                                                    <input type="text" class="form-control" placeholder="주소">
                                                </div>
                                                <div class="mt-1">
                                                    <input type="text" class="form-control" placeholder="주소 상세">
                                                </div>
                                                <div class="mt-1">
                                                    <input type="text" class="form-control" placeholder="추가항목">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <x-campaign.sidecar :campaign="$campaign" :useThumbnail="true"></x-campaign.sidecar>
            </div>
        </form>
    </div>
    <script>
      const campaignData = {
        currentTab: 'info',
        showMore: false,
        clickTabHandle(name) {
          this.currentTab = name;
        }
      }
    </script>
</x-app-layout>
