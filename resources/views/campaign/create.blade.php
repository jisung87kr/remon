<x-app-layout>
    <div class="container mx-auto p-6" x-data="campaignData">
        <form action="" method="POST">
            @csrf
            <section class="mb-16">
                <h1 class="h3 mb-6">캠페인 설정</h1>
                <div class="border-t border-stone-900 py-3">
                    <div class="grid md:grid-cols-2 divide-y">
                        <div class="col-span-2 py-6">
                            <label class="label mb-2 text-base">유형</label>
                            <ul class="flex gap-3">
                                @foreach($campaignTypes as $campaignType)
                                <li>
                                    <x-radio-button id="type_{{$campaignType->id}}" name="type" :value="$campaignType->id" required="true">{{ $campaignType->name }}</x-radio-button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-span-2 py-6">
                            <label class="label mb-2 text-base">제품 카테고리</label>
                            <ul class="flex flex-wrap gap-3">
                                @foreach($productCategory->categories as $category)
                                <li>
                                    <x-checkbox-button id="product_category_{{$category->id}}" name="product_category[]" :value="$category->id">{{ $category->name }}</x-checkbox-button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-span-2 py-6">
                            <label class="label mb-2 text-base">제퓸 유형</label>
                            <ul class="flex flex-wrap gap-3">
                                @foreach($typeCategory->categories as $category)
                                    <li>
                                        <x-checkbox-button id="product_category_{{$category->id}}" name="product_category[]" :value="$category->id">{{ $category->name }}</x-checkbox-button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-span-2 py-6">
                            <label class="label mb-4">지역 카테고리</label>
                            <div>
                                @foreach($locationCategory->categories as $category)
                                <div class="mb-6">
                                    <div class="mb-3 text-sm">{{ $category->name }}</div>
                                    <ul class="flex flex-wrap gap-3">
                                        @foreach($category->categories as $location)
                                        <li>
                                            <x-checkbox-button id="location_category_{{$location->id}}" name="location_category[]" :value="$location->id">{{ $location->name }}</x-checkbox-button>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="mb-16">
                <h1 class="h3 mb-6">이미지</h1>
                <div class="border-t border-stone-900 py-3">
                    <div class="grid md:grid-cols-2 divide-y">
                        <div class="col-span-2 py-6">
                            <label class="label mb-2 text-base">대표이미지</label>
                            <input type="file" name="thumbnails" class="form-control" multiple>
                        </div>
                        <div class="col-span-2 py-6">
                            <label class="label mb-2 text-base">상세이미지</label>
                            <input type="file" name="detail_images" class="form-control" multiple>
                        </div>
                    </div>
                </div>
            </section>
            <section class="mb-16">
                <h1 class="h3 mb-6">캠페인 정보</h1>
                <div class="border-t border-stone-900 py-3">
                    <div class="grid md:grid-cols-2 divide-y">
                        <div class="col-span-2 py-6">
                            <label for="title" class="label mb-2">캠페인 제목</label>
                            <input type="text" id="title" class="form-control" name="title">
                        </div>
                        <div class="col-span-2 py-6">
                            <label for="product_name" class="label mb-2">상품명</label>
                            <input type="text" id="product_name" class="form-control" name="product_name">
                        </div>
                        <div class="col-span-2 py-6">
                            <label for="benefit" class="label mb-2">제공내역</label>
                            <textarea id="benefit" name="benefit" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-span-2 py-6">
                            <label for="point" class="label mb-2">제공포인트</label>
                            <div class="flex gap-x-3">
                                <div class="flex items-center ps-4 border border-gray-200 rounded">
                                    <input type="radio" value="n" name="use-benefit-point" id="use-benefit-point-false" class="form-radio" x-model="useBenefitPoint">
                                    <label for="use-benefit-point-false" class="w-full p-4 text-sm font-medium">미제공</label>
                                </div>
                                <div class="flex items-center ps-4 border border-gray-200 rounded">
                                    <input type="radio" value="y" name="use-benefit-point" id="use-benefit-point-true" class="form-radio" x-model="useBenefitPoint">
                                    <label for="use-benefit-point-true" class="w-full p-4 text-sm font-medium">제공</label>
                                </div>
                            </div>
                            <input type="number" name="point" id="point" class="form-control mt-3" x-show="useBenefitPoint === 'y'">
                        </div>
                        <div class="col-span-2 py-6">
                            <div class="grid grid-cols-12 gap-6">
                                <div class="col-span-3">
                                    <label for="address_postcode" class="label mb-2">우편번호</label>
                                    <input id="address_postcode" class="form-control" name="address_postcode" readonly x-model="addressPostcode" @click="execDaumPostcode">
                                </div>
                                <div class="col-span-9">
                                    <label for="address" class="label mb-2">주소</label>
                                    <div class="flex gap-3">
                                        <input id="address" class="form-control w-full" name="address" readonly x-model="address" @click="execDaumPostcode">
                                        <button type="button" class="button button-gray shrink-0 !m-0" @click.prevent="execDaumPostcode">주소찾기</button>
                                    </div>
                                </div>
                                <div class="col-span-12 relative border pt-6" x-show="findAddress">
                                    <div x-ref="search_address_element">
                                        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" @click="findAddress=false" alt="접기 버튼">
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <label for="address_detail" class="label mb-2">주소상세</label>
                                    <input id="address_detail" class="form-control" name="address_detail" x-ref="address_detail">
                                </div>
                                <div class="col-span-12 bg-red-50 h-[300px] rounded-lg flex items-center justify-center" x-show="mapObject">
                                    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=509c2656c00fa9af4782197a888763f6&libraries=services,clusterer,drawing"></script>
                                    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
                                    <div id="map" x-ref="map" class="w-full h-[300px]"></div>
                                    <input type="hidden" name="address_latitude" value="" x-model="lat">
                                    <input type="hidden" name="address_longitude" value="" x-model="long">
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 py-6">
                            <label for="visit_instructions" class="label mb-2">방문 및 예약안내</label>
                            <textarea name="visit_instructions" id="visit_instructions" class="form-control" cols="30" rows="10"></textarea>
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
                                                    <x-checkbox-button id="mission_option_{{$option->id}}" name="mission_options[{{$option->id}}][id]" :value="$option->id" xmodel="missionOptions">{{ $option->option_value }}</x-checkbox-button>
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
                                                <x-checkbox-button id="mission_option_{{$mission->options[0]->id}}" name="mission_options[{{$mission->options[0]->id}}]['id']" :value="$mission->options[0]->id" xmodel="missionOptions">{{ $mission->options[0]->option_name }}</x-checkbox-button>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col-span-2 py-6" x-show="showInput(1)">
                            <label for="title_keyword" class="label mb-2">제목키워드</label>
                            <input type="text" id="title_keyword" class="form-control" name="mission_options[1][content]">
                        </div>
                        <div class="col-span-2 py-6"  x-show="showInput(2)">
                            <label for="content_keyword" class="label mb-2">본문키워드</label>
                            <input type="text" id="content_keyword" class="form-control" name="mission_options[2][content]">
                        </div>
                        <template x-if="showInput(11)">
                            <div class="col-span-2 py-6">
                                <label for="hashtag" class="label mb-2">해시태그</label>
                                <input type="text" id="hashtag" class="form-control" name="mission_options[11][content]">
                            </div>
                        </template>
                        <div class="col-span-2 py-6">
                            <label for="mission" class="label mb-2">미션설명</label>
                            <textarea id="mission" name="mission" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-16">
                <h1 class="h3 mb-6">신청정보</h1>
                <div class="border-t border-stone-900 py-3">
                    <div class="grid md:grid-cols-2 divide-y">
                        <div class="col-span-2 py-6">
                            <label class="label mb-2 text-base">입력항목 선택</label>
                            <ul class="flex flex-wrap gap-3">
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::APPLY_REASON->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::APPLY_REASON->name}}" checked="true" readonly="true" @click.prevent="alert('필수값입니다.')">{{ App\Enums\Campaign\ApplicationFieldEnum::APPLY_REASON->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::CAMERA_TYPE->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::CAMERA_TYPE->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::CAMERA_TYPE->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::IS_FACE_VISIBLE->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::IS_FACE_VISIBLE->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::IS_FACE_VISIBLE->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::HAS_SHARED_BLOG->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::HAS_SHARED_BLOG->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::HAS_SHARED_BLOG->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::TOP_SIZE->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::TOP_SIZE->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::TOP_SIZE->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::BOTTOM_SIZE->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::BOTTOM_SIZE->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::BOTTOM_SIZE->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::SHOES_SIZE->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::SHOES_SIZE->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::SHOES_SIZE->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::HEIGHT->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::HEIGHT->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::HEIGHT->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::SKIN_TYPE->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::SKIN_TYPE->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::SKIN_TYPE->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::IS_MARRIED->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::IS_MARRIED->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::IS_MARRIED->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::HAS_CHILDREN->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::HAS_CHILDREN->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::HAS_CHILDREN->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::JOB->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::JOB->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::JOB->label() }}</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="application_field_{{App\Enums\Campaign\ApplicationFieldEnum::HAS_PET->value}}" name="application_field[]" value="{{App\Enums\Campaign\ApplicationFieldEnum::HAS_PET->name}}">{{ App\Enums\Campaign\ApplicationFieldEnum::HAS_PET->label() }}</x-checkbox-button>
                                </li>
                            </ul>
                        </div>
                        <div class="col-span-2 py-6">
                            <label for="" class="label mb-2">상품옵션</label>
                            <template x-for="(item, index) in customOptions">
                                <div class="grid grid-cols-2 gap-3 py-1">
                                    <input type="text" name="custom_option[][name]" id="" class="form-control" placeholder="옵션명" x-model="item.name">
                                    <div class="flex gap-3">
                                        <input type="text" name="custom_option[][value]" id="" class="form-control" placeholder="예)빨강, 노랑" x-model="item.value">
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
                </div>
            </section>

            <div class="text-center">
                <button class="button button-light">취소</button>
                <button class="button button-default">등록</button>
            </div>
        </form>
    </div>
    <script>
        const campaignData = {
          useBenefitPoint: 'n',
          addressPostcode: '',
          address: '',
          addressDetail: '',
          addressExtra: '',
          searchAddressElement: '',
          findAddress: false,
          mapElement: '',
          mapObject: null,
          showMap: true,
          lat: null,
          long: null,
          marker: null,
          missionOptions: [],
          customOptions: [],
          customOption: {
            id: null,
            name: null,
            value: null,
          },
          init(){
            this.searchAddressElement = this.$refs.search_address_element;
            this.mapelement = this.$refs.map;
            if(this.lat && this.long){
              this.initMap();
            }

            if(this.customOptions.length === 0){
              this.customOptions = [{...this.customOption}]
            }
          },
          showInput(optionId){
            return this.missionOptions.includes(optionId+'');
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
                this.searchAddressElement.style.height = size.height+'px';
              },
              width : '100%',
              height : '100%'
            }).embed(this.searchAddressElement);
          }
        }
    </script>
</x-app-layout>
