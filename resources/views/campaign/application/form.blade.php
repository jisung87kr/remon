@if(session('message'))
    <script>
        alert('{{ session('message') }}');
    </script>
@endif
<div class="container mx-auto px-6" x-data="campaignData">
    <form action="{{ $route }}" method="POST">
        @csrf
        @method($method)
        <div class="grid grid-cols-8 gap-6 relative break-keep">
            <div class="col-span-8 lg:col-span-6 lg:border-r lg:pr-6">
                <div class="flex gap-3 items-center">
                    <h1 class="font-bold text-[32px] my-3">캠페인 신청하기</h1>
                    @isset($campaignApplication->status)
                    <div>
                        <x-badge.application :status="$campaignApplication->status">{{ \App\Enums\Campaign\ApplicationStatus::tryFrom($campaignApplication->status)->label() }}</x-badge.application>
                    </div>
                    @endif
                </div>
                <div>
                    <div class="flex mt-6">
                        <div class="shrink-0 w-[160px] font-bold mr-3">상품링크</div>
                        <div class="w-full">
                            <a href="{{ $campaign->product_url }}" target="_blank" class="text-blue-600">{{ $campaign->product_url }}</a>
                        </div>
                    </div>
                    <div class="flex mt-6">
                        <div class="shrink-0 w-[160px] font-bold mr-3 pt-6">제공내역</div>
                        <div class="w-full border-t pt-6">
                            {!! nl2br($campaign->benefit) !!}
                            <div class="text-sm text-red-500 mt-6">
                                ※ 옵션 오기재로 인한 교환/취소 불가하며, 해당 사유 발생 시 관련 페널티 부과 및 배송비, 제품가 환불 요청 등이 이루어질 수 있습니다. 이 점유의하시어 반드시 정확하게 기재 바랍니다.
                            </div>
                        </div>
                    </div>
                    @if(!$campaign->useShipping)
                        <div class="flex mt-6">
                            <div class="shrink-0 w-[160px] font-bold mr-3 pt-6">방문 및 예약안내</div>
                            <div class="w-full border-t pt-6">
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
                    <div class="flex mt-6">
                        <div class="shrink-0 w-[160px] font-bold mr-3 pt-6">회원 기본 정보</div>
                        <div class="w-full border-t pt-6">
                            <div>
                                <label for="name" class="label mb-2">이름</label>
                                <input type="text" name="name" class="form-control"
                                       @readonly(auth()->user()->name)
                                       value="{{ old('name', $campaignApplication->name ?? auth()->user()->name) }}" id="name">
                                <x-input-error for="name" class="mt-1"></x-input-error>
                            </div>
                            <div class="my-4">
                                <label for="birthdate" class="label mb-2">출생연도</label>
                                <select name="birthdate" id="birthdate" class="form-select" @readonly(auth()->user()->birthdate)>
                                    <option value="" disabled selected>선택해주세요</option>
                                    @foreach(array_reverse(range(1923, date('Y'))) as $year)
                                        <option value="{{ $year }}" @selected($year == old('birthdate', $campaignApplication->birthdate ?? auth()->user()->birthdate))>{{ $year }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="birthdate" class="mt-1"></x-input-error>
                            </div>
                            <div class="my-4">
                                <label for="sex" class="label mb-2">성별</label>
                                <div class="flex gap-3">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="sex" value="man" @checked(old('sex', $campaignApplication->sex ?? auth()->user()->sex) == 'man')>
                                        <label for="man" class="text-sm">남자</label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="sex" value="woman" @checked(old('sex', $campaignApplication->sex ?? auth()->user()->sex) == 'woman')>
                                        <label for="woman" class="text-sm">여자</label>
                                    </div>
                                </div>
                                <x-input-error for="sex" class="mt-1"></x-input-error>
                            </div>
                            <div class="my-4">
                                <label for="phone" class="label mb-2">연락처</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ old('phone', $campaignApplication->phone ?? auth()->user()->phone) }}" id="phone"
                                       @readonly(auth()->user()->phone)
                                       @keyup="event.target.value = event.target.value.replace(/\D/g, '').replace(/(\d{3})(\d{1,4})(\d{1,4})/, '$1-$2-$3')">
                                <x-input-error for="phone" class="mt-1"></x-input-error>
                            </div>
                        </div>
                    </div>
                    @foreach($campaign->media as $media)
                    @php
                        $item = auth()->user()->media->filter(function($item) use ($media){
                            return $item['media'] == $media->media;
                        })->first();
                    @endphp
                    <div x-data="{{$media->media}}_mediaData">
                        <div class="flex mt-6">
                            <div class="shrink-0 w-[160px] font-bold mr-3 pt-6">{{ \App\Enums\Campaign\MediaEnum::tryFrom($media->media)->label() }}</div>
                            <div class="w-full border-t pt-6">
                                <div class="text-sm" >콘텐츠를 작성할 {{ \App\Enums\Campaign\MediaEnum::tryFrom($media->media)->label() }} 주소를 등록해주세요. 등록한 정보는 선정 후 변경할 수 없습니다.</div>
                                <x-rootmodal class="z-[999]">
                                    <x-slot name="trigger">
                                        <button type="button"
                                                class="button button-light flex gap-1 mt-4 items-center"
                                                :class="{ 'bg-green-100 border': item.id, 'button-light' : !item.id}"
                                                @click="openModal()"
                                        >
                                            <x-media-icon :media="$media->media"></x-media-icon>
                                            <span>{{ \App\Enums\Campaign\MediaEnum::tryFrom($media->media)->label() }}</span><span x-text="item.id ? '연결됨' : '연결하기'"></span>
                                        </button>
                                    </x-slot>
                                    <x-slot name="header"></x-slot>
                                    <div class="text-left">
                                        <label for="{{ $media->media }}" class="label">{{ \App\Enums\Campaign\MediaEnum::tryFrom($media->media)->label() }} 주소</label>
                                        <div class="flex gap-3 mt-3 mb-1">
                                            <input type="text" name='url[{{ $media->media }}]' x-model="item.url" class="form-control" id="{{ $media->media }}" placeholder="http://example.com">
                                        </div>
                                        <small>{{ \App\Enums\Campaign\MediaEnum::tryFrom($media->media)->label() }} 주소를 정확히 입력해주세요</small>
                                    </div>
                                    <x-slot name="footer">
                                        <button type="button" class="button button-default" @click="save('{{ $media->media }}')">저장</button>
                                    </x-slot>
                                </x-rootmodal>
                                <x-input-error :for="'url.'.$media->media" class="mt-1"></x-input-error>
                            </div>
                        </div>
                    </div>
                    <script>
                      const {{$media->media}}_mediaData = {
                        item: @json($item),
                        init(){
                          if(!this.item){
                            this.item = {
                              id: null,
                              media: null,
                              url: null,
                            }
                          }
                        },
                        save(media){
                          let params = {
                            media: media,
                            url: this.item.url,
                            connected_status: 'connected',
                          };

                          if(this.item){
                            params.id = this.item.id;
                          }

                          if(params.id){
                            axios.put(`/api/user/media/${params.id}`, params).then(res => {
                              Swal.fire({
                                icon: 'success',
                                title: res.data.message,
                                didClose: () => {
                                  this.item = res.data.data;
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
                                  this.item = res.data.data;
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
                        openModal(){
                          this.$data.open = true;
                        }
                      }
                    </script>
                    @endforeach

                    <div class="flex mt-6">
                        <div class="shrink-0 w-[160px] font-bold mr-3 pt-6">신청 정보 입력</div>
                        <div class="w-full pb-6">
                            @if($campaign->application_information)
                                <div class="application-category">
                                    <div class="application-category-content !mt-0">
                                        {!! nl2br($campaign->application_information) !!}
                                    </div>
                                </div>
                            @endif

                            {{-- 선택한 옵션이 있으면 노출 --}}
                            @if($campaign->applicationFields->count() > 0)
                            <div class="application-category">
                                @foreach($campaign->applicationFields as $field)
                                    @php
                                        $applicantionValue = App\Helper\CommonHelper::findApplicationFieldValue($campaignApplication->applicationValues ?? [], $field);
                                        $value = old("application_field.{$field->id}.value", $applicantionValue->value ?? '');
                                    @endphp
                                    <input type="hidden" name="application_field[{{ $field->id }}][id]" value="{{ $field->id }}">
                                    <div class="application_field">
                                        <div class="application_field-item mt-3">
                                            <div class="application_field-title">{{ $field->label }}</div>
                                            @if($field->name === 'custom_option')
                                                <select name="application_field[{{ $field->id }}][value]" id="application_field_{{$field->id}}" class="form-select" required>
                                                    <option value="" disabled selected>옵선선택</option>
                                                    @foreach(explode(',', $field->option) as $option)
                                                        <option value="{{ $option }}" @selected($value === $option)>{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif($field->type === 'text')
{{--                                                <input type="text"--}}
{{--                                                       name="application_field[{{ $field->id }}][value]"--}}
{{--                                                       class="form-control"--}}
{{--                                                       id="application_field_{{$field->id}}"--}}
{{--                                                       value="{{ $value }}"--}}
{{--                                                       required>--}}
                                                <textarea name="application_field[{{ $field->id }}][value]"
                                                          class="form-control"
                                                          id="application_field_{{$field->id}}"
                                                          required
                                                          >{{$value}}</textarea>
                                            @elseif($field->type === 'selectbox')
                                                <select name="application_field[{{ $field->id }}][value]" id="application_field_{{$field->id}}" class="application_field-input form-select" required>
                                                    <option value="" disabled selected>옵선선택</option>
                                                    @foreach(unserialize($field->option) as $option)
                                                        <option value="{{$option['value']}}" @selected($value === $option['value'])>{{ $option['label'] }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif($field->type === 'radio')
                                                <div class="flex gap-5 items-center">
                                                    @foreach(unserialize($field->option) as $key => $option)
                                                        <div class="flex items-center gap-2">
                                                            <input type="radio" id="application_field_{{$field->id}}_{{ $option['name'].$key }}"
                                                                   name="application_field[{{ $field->id }}][value]"
                                                                   required
                                                                   @if($value)checked="{{ $value == $option['value'] }}"@endif
                                                                   value="{{$option['value']}}"
                                                                   >
                                                            <label for="application_field_{{$field->id}}_{{ $option['name'].$key }}" class="text-sm">{{ $option['label'] }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <x-input-error for="application_field.{{ $field->id }}.value" class="mt-1"></x-input-error>
                                    </div>
                                @endforeach
                            </div>
                            @else
                            <div class="application-category">
                                <div class="text-sm pt-6">입력정보 받지 않음</div>
                            </div>
                            @endif

                            @if($campaign->useShipping)
                                {{-- 배송형 캠페인만 노출 --}}
                                <div class="application-category mt-10" x-data="shippingData">
                                    <div class="application-category-title">
                                        <span>상품을 배송받을 주소를 입력해 주세요.</span>
                                        <a href="{{ route('mypage.profile') }}" class="ms-1 underline text-sm">(배송지관리)</a>
                                    </div>
                                    <div class="application_field">
                                        <div class="application_field-item mt-5">
                                            <div class="flex gap-3">
                                                <template x-for="item in addressList" :key="item.id">
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
                                                           required
                                                           x-model="address.shippingName">
                                                </div>
                                                <div class="">
                                                    <label for="shipping_phone" class="label application_field-title">연락처</label>
                                                    <input type="text"
                                                           name="shipping_phone"
                                                           class="form-control"
                                                           id="shipping_phone"
                                                           :readonly="readonly"
                                                           required
                                                           @keyup="typePhoneNumber()"
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
                                                               required
                                                               x-model="address.addressPostcode">
                                                        @if($editable)
                                                        <button type="button" class="button button-light shrink-0" @click="openDaumPostcode">우편번호 찾기</button>
                                                        @endif
                                                    </div>
                                                    <div id="address_searchbox"
                                                         x-ref="address_searchbox"
                                                         x-show="searchOpen"
                                                         :style="{height: height}"
                                                         class="mt-3 relative pt-[25px] border">
                                                        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" @click="foldDaumPostcode" alt="접기 버튼">
                                                    </div>
                                                </div>
                                                <div class="mt-1">
                                                    <input type="text"
                                                           name="address"
                                                           class="form-control"
                                                           placeholder="주소"
                                                           :readonly="readonly"
                                                           required
                                                           x-model="address.address">
                                                </div>
                                                <div class="mt-1">
                                                    <input type="text"
                                                           name="address_detail"
                                                           class="form-control"
                                                           placeholder="주소상세"
                                                           :readonly="readonly"
                                                           x-model="address.addressDetail"
                                                           required
                                                           x-ref="address_detail">
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

                                <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
                                <script>
                                  const shippingData = {
                                    addressList: @json(auth()->user()->shippingAddresses),
                                    application: @json($campaignApplication),
                                    address: {
                                      address: '{{ old('address', $campaignApplication->address ?? '') ?? '' }}',
                                      addressDetail: '{{ old('address_detail', $campaignApplication->address_detail ?? '') ?? '' }}',
                                      addressExtra: '{{ old('address_extra', $campaignApplication->address_extra ?? '') ?? '' }}',
                                      addressPostcode: '{{ old('address_postcode', $campaignApplication->address_postcode ?? '') ?? '' }}',
                                      shippingName: '{{ old('shipping_name', $campaignApplication->shipping_name ?? '') ?? '' }}',
                                      shippingPhone: '{{ old('shipping_phone', $campaignApplication->shipping_phone ?? '') ?? '' }}',
                                    },
                                    selectedId: null,
                                    readonly: true,
                                    searchOpen: false,
                                    height: 0,
                                    init(){
                                      if(!this.application){
                                        if(this.addressList && this.addressList[0] && this.addressList[0].id){
                                          this.setAddress(this.addressList[0].id);
                                        } else {
                                          this.setAddress('new');
                                        }
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
                                    },
                                    openDaumPostcode(){
                                      var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
                                      new daum.Postcode({
                                        oncomplete: (data) => {
                                          let addr = '';
                                          let extraAddr = '';

                                          if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                            addr = data.roadAddress;
                                          } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                            addr = data.jibunAddress;
                                          }

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
                                            this.address.addressExtra = extraAddr;

                                          } else {
                                            this.address.addressExtra = '';
                                          }

                                          this.address.addressPostcode = data.zonecode;
                                          this.address.address = addr;
                                          this.$refs.address_detail.focus();

                                          // iframe을 넣은 element를 안보이게 한다.
                                          // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                                          this.searchOpen = false;

                                          document.body.scrollTop = currentScroll;
                                        },
                                        onresize : (size) => {
                                          this.height = size.height+30+'px';
                                        },
                                        width : '100%',
                                        height : '100%'
                                      }).embed(this.$refs.address_searchbox);

                                      this.searchOpen = true;
                                    },
                                    foldDaumPostcode(){
                                      this.searchOpen = false;
                                    },
                                    typePhoneNumber(){
                                        this.address.shippingPhone = event.target.value.replace(/\D/g, '').replace(/(\d{3})(\d{1,4})(\d{1,4})/, '$1-$2-$3');
                                    }
                                  }
                                </script>
                            @endif
                        </div>
                    </div>

                    @if(isset($campaignApplication->id) && in_array($campaignApplication->status, [\App\Enums\Campaign\ApplicationStatus::APPROVED->value, \App\Enums\Campaign\ApplicationStatus::POSTED->value]))
                    <div class="flex mt-6">
                        <div class="shrink-0 w-[160px] font-bold mr-3 pt-6">콘텐츠 선택</div>
                        <div class="w-full border-t pt-6">
                            <div class="mb-3">
                                캠페인에 등록할 콘텐츠를 선택해주세요.
                                리스트에서 찾지 못한 경우, 글 주소를 입력해주세요.
                            </div>
                            @foreach($campaignApplication->mediaContents as $content)
                            <div x-data="{{$content->media->media}}_mediaContentData" class="my-10">
                                <div class="mb-3 flex gap-3">
                                    <x-media-icon :media="$content->media->media"></x-media-icon>
                                    <span>{{ \App\Enums\Campaign\MediaEnum::from($content->media->media)->label() }}</span>
                                </div>
                                <input type="hidden" name="media_content[{{ $loop->index }}][media]" value="{{ $content->media->media }}">
                                <input type="hidden" name="media_content[{{ $loop->index }}][id]" value="{{ $content->campaign_media_id }}">
                                <input type="hidden" name="media_content[{{ $loop->index }}][content_url]" x-model="contentUrl">
                                <select name="media_content[{{ $loop->index }}][url]"
                                        id="media_content"
                                        class="form-select w-full"
                                        x-model="contentUrl"
                                        x-ref="media_content">
                                    <option value="" disabled selected>선택하세요</option>
                                    <template x-for="item in items" :key="item.url">
                                        <option :value="item.url"
                                                x-text="item.title"
                                                :selected="item.url === contentUrl"></option>
                                    </template>
                                </select>
                                <template x-if="!items || items.length == 0">
                                    <div class="mt-1 mb-3 text-sm">목록을 불러올 수 없습니다.</div>
                                </template>
                                <input type="text" name="media_content[{{ $loop->index }}][url_text]"
                                       class="form-control mt-3"
                                       x-model="contentUrl"
                                       required
                                       placeholder="http://글주소">
                                @if($content->media->media === \App\Enums\Campaign\MediaEnum::NAVER_BLOG->value)
                                <div class="mt-6 w-full" x-data="{{$content->media->media}}_bannerData">
                                    <div class="mb-3">콘텐츠 본문 하단에 스폰서 배너를 삽입해주세요.</div>
                                    <div class="flex gap-3">
                                        <input type="text" class="form-control" value="<img src='{{ config('app.url') }}/campaign-banner?id={{ $content->banner_id }}' />" x-ref="banner">
                                        <button type="button" class="button button-light" @click="copyBanner">코드복사</button>
                                    </div>
                                </div>
                                <script>
                                  const {{$content->media->media}}_bannerData = {
                                    copyBanner(){
                                      const text = this.$refs.banner.value;
                                        const elem = document.createElement('textarea');
                                        document.body.appendChild(elem);
                                        elem.value = text;
                                        elem.select();
                                        document.execCommand('copy');
                                        document.body.removeChild(elem);
                                        alert('복사 되었습니다.');
                                    }
                                  };
                                </script>
                                @endif
                            </div>
                            <script>
                                const {{$content->media->media}}_mediaContentData = {
                                    media: '{{ $content->media->media }}',
                                    contentUrl: '{{ $content->content_url }}',
                                    items: [],
                                    init(){
                                      axios.get(`/api/user/media/external_content?media=${this.media}`).then(res => {
                                        this.items = res.data.data;
                                      });
                                    },
                                };
                            </script>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex my-6">
                        <div class="shrink-0 w-[160px] font-bold mr-3 pt-6">스폰서배너 삽입</div>
                        <div class="w-full border-t pt-6">
                            <ul class="list-disc">
                                <li>캠페인에 등록한 콘텐츠는 홍보나 필요에 의해 사용될 수 있습니다.</li>
                                <li>콘텐츠 본문에 반드시 스폰서배너가 삽입되야 캠페인 참여로 인정됩니다.</li>
                                <li>캠페인과 관련 없는 콘텐츠는 통보없이 삭제될 수 있습니다.</li>
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <x-campaign.sidecar :campaign="$campaign" :useThumbnail="true" :campaignApplication="$campaignApplication"></x-campaign.sidecar>
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
