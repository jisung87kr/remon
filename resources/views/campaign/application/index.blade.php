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
                                           @readonly(auth()->user()->name)
                                           value="{{ auth()->user()->name }}" id="name">
                                    <x-input-error for="name" class="mt-1"></x-input-error>
                                </div>
                                <div class="my-4">
                                    <label for="birthdate" class="label mb-2">출생연도</label>
                                    <select name="birthdate" id="birthdate" class="form-select" @readonly(auth()->user()->birthdate)>
                                        <option value="">선택해주세요</option>
                                        @foreach(array_reverse(range(1923, date('Y'))) as $year)
                                            <option value="{{ $year }}" @selected($year == auth()->user()->birthdate)>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="birthdate" class="mt-1"></x-input-error>
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
                                    <x-input-error for="sex" class="mt-1"></x-input-error>
                                </div>
                                <div class="my-4">
                                    <label for="phone" class="label mb-2">연락처</label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ auth()->user()->phone }}" id="phone"
                                           @readonly(auth()->user()->phone)
                                           @keyup="event.target.value = event.target.value.replace(/\D/g, '').replace(/(\d{3})(\d{1,4})(\d{1,4})/, '$1-$2-$3')">
                                    <x-input-error for="phone" class="mt-1"></x-input-error>
                                </div>
                            </div>
                        </div>
                        @if($campaign->media)
                            <div x-data="mediaData">
                                <template x-for="item in media">
                                    <div class="flex py-6">
                                        <div class="shrink-0 w-[160px] font-bold mr-3" x-text="item.media_name"></div>
                                        <div class="w-full border-b pb-6">
                                            <div class="text-sm" x-text="`콘텐츠를 작성할 ${item.media_name} 주소를 등록해주세요. 등록한 정보는 선정 후 변경할 수 없습니다.`"></div>
                                            <x-rootmodal class="z-[999]">
                                                <x-slot name="trigger">
                                                    <button type="button"
                                                            class="button button-light flex gap-1 mt-4 items-center"
                                                            :class="{ 'bg-green-100 border': item.id, 'button-light' : !item.id}"
                                                            @click="openModal(item.media)"
                                                            >
                                                        <template x-if="item.media == '{{ App\Enums\Campaign\MediaEnum::NAVER_BLOG->value }}'">
                                                            <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="">
                                                        </template>
                                                        <template x-if="item.media == '{{ App\Enums\Campaign\MediaEnum::INSTAGRAM->value }}'">
                                                            <img src="{{ Vite::asset('resources/images/media/instagram.svg') }}">
                                                        </template>
                                                        <template x-if="item.media == '{{ App\Enums\Campaign\MediaEnum::YOUTUBE->value }}'">
                                                            <img src="{{ Vite::asset('resources/images/media/youtube.svg') }}" alt="" class="w-[20px]">
                                                        </template>
                                                        <img src="" alt="">
                                                        <span x-text="item.media_name"></span><span x-text="item.id ? '연결됨' : '연결하기'"></span>
                                                    </button>
                                                </x-slot>
                                                <x-slot name="header"></x-slot>
                                                <div class="text-left">
                                                    <label :for="item.media" class="label" x-text="`${item.media_name} 주소`"></label>
                                                    <div class="flex gap-3 mt-3 mb-1">
                                                        <input type="text" name="url" x-model="item.url" class="form-control" :id="item.media" placeholder="http://example.com">
                                                    </div>
                                                    <small>주소를 정확히 입력해주세요</small>
                                                </div>
                                                <x-slot name="footer">
                                                    <button type="button" class="button button-default" @click="save(item.media)">저장</button>
                                                </x-slot>
                                            </x-rootmodal>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <script>
                              const mediaData = {
                                campaignMedia: @json($campaign->media),
                                userMedia: @json(auth()->user()->medias),
                                media:{},
                                init(){
                                    this.setMedia();
                                    console.log(this.media);
                                },
                                setMedia(){
                                    this.media = this.campaignMedia.map(item => {
                                        let mediaId = null;
                                        let url = null;
                                        let connected_status = null;

                                        for(var i=0; i < this.userMedia.length; i++){
                                            let media = this.userMedia[i];

                                            if(media.media === item.media){
                                              mediaId = media.id;
                                              url = media.url;
                                              connected_status = media.connected_status;
                                            }
                                        }

                                        return {
                                          id: mediaId,
                                          media: item.media,
                                          media_name: this.getMediaName(item.media),
                                          url: url,
                                          connected_status: connected_status,
                                        }
                                    });

                                    console.log(this.media);
                                },
                                getMediaName(media){
                                  switch (media){
                                    case '{{ \App\Enums\Campaign\MediaEnum::NAVER_BLOG->value }}':
                                      return '{{ \App\Enums\Campaign\MediaEnum::NAVER_BLOG->label() }}';
                                    case '{{ \App\Enums\Campaign\MediaEnum::INSTAGRAM->value }}':
                                      return '{{ \App\Enums\Campaign\MediaEnum::INSTAGRAM->label() }}';
                                    case '{{ \App\Enums\Campaign\MediaEnum::YOUTUBE->value }}':
                                      return '{{ \App\Enums\Campaign\MediaEnum::YOUTUBE->label() }}';
                                  }
                                },
                                save(media){
                                  let filtered = this.media.filter(item => item.media === media);
                                  let params = filtered[0];
                                  params.connected_status = 'connected';

                                  if(params.id){
                                    axios.put(`/api/user/media/${params.id}`, params).then(res => {
                                      Swal.fire({
                                        icon: 'success',
                                        title: res.data.message,
                                        didClose: () => {
                                          window.location.reload();
                                        }
                                      });
                                    }).catch(error => {
                                      Swal.fire({
                                        icon: 'error',
                                        title: error.response.data.message,
                                        text: error.response.data.data,
                                      });
                                    })
                                  } else {
                                    axios.post('/api/user/media', params).then(res => {
                                      Swal.fire({
                                        icon: 'success',
                                        title: res.data.message,
                                        didClose: () => {
                                          console.log('finished');
                                          console.log(res);
                                          params.id = res.data.data.id;
                                        }
                                      });
                                    }).catch(error => {
                                      Swal.fire({
                                        icon: 'error',
                                        title: error.response.data.message,
                                        text: error.response.data.data,
                                      });
                                    })
                                  }
                                },
                                openModal(type){
                                  this.$data.open = true;
                                }
                              }
                            </script>
                        @endif
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
                                                    <select name="application_field[{{ $field->id }}][value]" id="application_field_{{$field->id}}" class="form-select" required>
                                                        @foreach(explode(',', $field->option) as $option)
                                                            <option value="{{ $option }}">{{ $option }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif($field->type === 'text')
                                                    <input type="text" name="application_field[{{ $field->id }}][value]" class="form-control" id="application_field_{{$field->id}}" required>
                                                @elseif($field->type === 'selectbox')
                                                    <select name="application_field[{{ $field->id }}][value]" id="application_field_{{$field->id}}" class="application_field-input form-select" required>
                                                        <option value="">선택</option>
                                                        @foreach(unserialize($field->option) as $option)
                                                            <option value="{{$option['value']}}">{{ $option['label'] }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif($field->type === 'radio')
                                                    <div class="flex gap-3">
                                                        @foreach(unserialize($field->option) as $key => $option)
                                                            <x-radio-button id="application_field_{{$field->id}}_{{ $option['name'].$key }}"
                                                                            name="application_field[{{ $field->id }}][value]"
                                                                            required
                                                                            value="{{$option['value']}}">{{ $option['label'] }}</x-radio-button>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <x-input-error for="application_field.{{ $field->id }}.value" class="mt-1"></x-input-error>
                                        </div>
                                    @endforeach
                                </div>

                                @if($campaign->useShipping)
                                {{-- 배송형 캠페인만 노출 --}}
                                <div class="application-category mt-10" x-data="shippingData">
                                    <div class="application-category-title">상품을 배송받을 주소를 입력해 주세요.</div>
                                    <div class="application_field">
                                        <div class="application_field-item mt-5">
                                            <div class="flex gap-3">
                                                <template x-for="item in addressList">
                                                    <div>
                                                        <input type="radio"
                                                               name="shipping_id"
                                                               :id="`shipping_id${item.id}`"
                                                               :value="item.id"
                                                               x-model="selectedId"
                                                               class="hidden peer"
                                                               @click="setAddress(item.id)">
                                                        <label :for="`shipping_id${item.id}`"
                                                               x-text="item.title"
                                                               class="text-sm inline-flex items-center justify-between px-3 py-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100"></label>
                                                    </div>
                                                </template>
                                                <x-radio-button id="shipping_id_new" name="shipping_id" value="new" x-model="selectedId"
                                                                @click="setAddress('new')">새로입력하기</x-radio-button>
                                            </div>
                                            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <div class="">
                                                    <label for="shipping_name" class="label application_field-title">이름</label>
                                                    <input type="text"
                                                           name="shipping_name"
                                                           class="form-control"
                                                           id="shipping_name"
                                                           :readonly="readonly"
                                                           x-model="address.shippingName">
                                                </div>
                                                <div class="">
                                                    <label for="shipping_phone" class="label application_field-title">연락처</label>
                                                    <input type="text"
                                                           name="shipping_phone"
                                                           class="form-control"
                                                           id="shipping_phone"
                                                           :readonly="readonly"
                                                           x-model="address.shippingPhone">
                                                </div>
                                            </div>
                                            <div class="mt-5">
                                                <div>
                                                    <div class="flex gap-3">
                                                        <input type="text"
                                                               name="address_postcode"
                                                               class="form-control"
                                                               placeholder="우편번호"
                                                               :readonly="readonly"
                                                               x-model="address.addressPostcode">
                                                        <button class="button button-light shrink-0">우편번호 찾기</button>
                                                    </div>
                                                </div>
                                                <div class="mt-1">
                                                    <input type="text"
                                                           name="address"
                                                           class="form-control"
                                                           placeholder="주소"
                                                           :readonly="readonly"
                                                           x-model="address.address">
                                                </div>
                                                <div class="mt-1">
                                                    <input type="text"
                                                           name="address_detail"
                                                           class="form-control"
                                                           placeholder="주소상세"
                                                           :readonly="readonly"
                                                           x-model="address.addressDetail">
                                                </div>
                                                <div class="mt-1">
                                                    <input type="text"
                                                           name="address_extra"
                                                           class="form-control"
                                                           placeholder="추가항목"
                                                           :readonly="readonly"
                                                           x-model="address.addressExtra">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const shippingData = {
                                      addressList: @json(auth()->user()->shippingAddresses),
                                      address: {
                                        address: null,
                                        addressDetail: null,
                                        addressExtra: null,
                                        addressPostcode: null,
                                        shippingName: null,
                                        shippingPhone: null,
                                      },
                                      seletedId: null,
                                      readonly: true,
                                      init(){
                                        if(this.addressList && this.addressList[0] && this.addressList[0].id){
                                          this.setAddress(this.addressList[0].id);
                                        } else {
                                          this.setAddress('new');
                                        }
                                      },
                                      setAddress(id){
                                        this.seletedId = id;
                                        this.readonly = id !== 'new';
                                        if(this.readonly){
                                          const selectedAddress = this.addressList.filter(item => item.id === id)[0];
                                          this.address.address = selectedAddress.address;
                                          this.address.addressDetail = selectedAddress.address_detail;
                                          this.address.addressExtra = selectedAddress.address_extra;
                                          this.address.addressPostcode = selectedAddress.address_postcode;
                                          this.address.shippingName = selectedAddress.name;
                                          this.address.shippingPhone = selectedAddress.phone;
                                        } else {
                                            this.cleanAddress();
                                        }
                                      },
                                      cleanAddress(){
                                        this.address = {
                                            address: null,
                                            addressDetail: null,
                                            addressExtra: null,
                                            addressPostcode: null,
                                            shippingName: null,
                                            shippingPhone: null,
                                        };
                                      }
                                    }
                                </script>
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
