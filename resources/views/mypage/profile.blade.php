<x-mypage-layout>
    <form action="">
        <x-slot name="header">내정보</x-slot>
        <div class="mt-6">
            <div class="text-lg font-bold pb-2 mb-3 border-b border-gray-900">회원정보</div>
            <div class="mt-6">
                <div class="flex items-center py-3">
                    <label for="name" class="shrink-0 w-[120px] mr-3 label !text-gray-600">이름</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" id="name">
                </div>
                <div class="flex items-center py-3">
                    <x-label class="!text-base !mr-3 shrink-0 w-[120px]">성별</x-label>
                    <div>
                        <x-radio-button id="sex_man" name="sex" value="man">남자</x-radio-button>
                        <x-radio-button id="sex_man" name="sex" value="man">여자</x-radio-button>
                    </div>
                </div>
                <div class="flex items-center py-3">
                    <x-label class="!text-base !mr-3 shrink-0 w-[120px]">출생연도</x-label>
                    <select name="" id="" class="form-select">
                        <option value="">선택해주세요</option>
                        @foreach(array_reverse(range(1923, date('Y'))) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center py-3">
                    <label for="nick_name" class="shrink-0 w-[120px] mr-3 label !text-gray-600">닉네임</label>
                    <input type="text" class="form-control" value="" id="nick_name">
                </div>
                <div class="flex items-center py-3">
                    <label for="email" class="shrink-0 w-[120px] mr-3 label !text-gray-600">아이디(이메일)</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->email }}" id="email">
                </div>
                <div class="flex items-center py-3">
                    <label for="phone" class="shrink-0 w-[120px] mr-3 label !text-gray-600">연락처</label>
                    <div class="w-full">
                        <input type="text" class="form-control" value="" id="phone">
                        <div class="text-sm mt-2">
                            <div>
                                <div class="inline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check inline" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#312e81" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                    <span class="text-indigo-700">휴대폰 인증완료</span>
                                </div>
                                <span class="text-gray-500">휴대폰 번호 수정시 인증이 취소됩니다.</span>
                            </div>
                            <div>
                                <span class="text-gray-500">휴대폰 인증이 되지 않았습니다.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6" x-data="shippingData">
            <div class="text-lg font-bold pb-2 mb-3 border-b border-gray-900">주소록</div>
            <div>
                <table class="table">
                    <colgroup>
                        <col width="150px">
                        <col width="100px">
                        <col width="*">
                        <col width="200px">
                    </colgroup>
                    <thead>
                    <tr class="text-center">
                        <th>배송지</th>
                        <th>받는이</th>
                        <th>주소/연락처</th>
                        <th>수정∙삭제</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template x-for="item in addressList">
                    <tr :key="item.id">
                        <td class="text-center">
                            <div x-text="item.title"></div>
                            <template x-if="item.is_default == 1">
                                <span class="badge badge-purple !rounded-lg mt-1">기본배송지</span>
                            </template>
                        </td>
                        <td x-text="item.name">유지성</td>
                        <td>
                            <div x-text="item.address_postcode">(24302)</div>
                            <div x-text="item.address">강원특별자치도 춘천시 세실로 261 (초록지붕아파트)</div>
                            <div>
                                <span x-text="item.address_detail"></span>
                                <template x-if="item.address_extra">
                                    (<span x-text="item.address_extra"></span>)
                                </template>
                            </div>
                            <div x-text="item.phone"></div>
                        </td>
                        <td>
                            <div class="flex justify-center gap-3">
                                <button type="button" class="border px-3 py-1.5 text-xs" @click="editAddress(item.id)">수정</button>
                                <button type="button" class="border px-3 py-1.5 text-xs" @click="deleteAddress(item.id)">삭제</button>
                            </div>
                        </td>
                    </tr>
                    </template>
                    </tbody>
                </table>
                <div class="mt-3 text-center">
                    <button type="button" class="text-sm mx-auto" @click="openModal">+ 배송지 추가</button>
                </div>
            </div>
            <div class="modal" x-show="isModalShow" style="display: none;">
                <div class="modal-bg"></div>
                <div class="modal-wrapper">
                    <div class="modal-header">
                        <div class="relative">
                            <div>모달 타이틀</div>
                            <button type="button" class="absolute right-1 top-1/2 -translate-y-1/2"
                                    @click="isModalShow = false">x</button>
                        </div>
                    </div>
                    <div class="modal-content" @click.away="isModalShow = false">
                        <div class="my-3">
                            <label for="address_title" class="label mb-1">배송지명</label>
                            <input type="text" name="address_title" id="address_title" class="form-control" x-model="addressTitle">
                        </div>
                        <div class="my-3">
                            <label for="address_name" class="label mb-1">수령인</label>
                            <input type="text" name="address_name" id="address_name" class="form-control" x-model="addressName">
                        </div>
                        <div class="my-3">
                            <label for="address_phone" class="label mb-1">휴대폰번호</label>
                            <input type="text" name="address_phone" id="address_phone" class="form-control" x-model="addressPhone" @keyup="typePhoneNumber(addressPhone)">
                        </div>
                        <div class="my-3">
                            <label for="" class="label mb-1">주소</label>
                            <div class="my-1">
                                <div class="flex w-full">
                                    <input type="text" name="address_postcode" id="address_postcode" class="form-control w-full" x-model="postcode">
                                    <button type="button" class="button button-gray-outline shrink-0 ml-1" @click="openDaumPostcode">우편번호 찾기</button>
                                </div>
                                <div id="address_searchbox"
                                     x-ref="address_searchbox"
                                     x-show="searchOpen"
                                     :style="{height: height}"
                                    class="mt-3 relative pt-[25px] border">
                                    <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" @onclick="foldDaumPostcode" alt="접기 버튼">
                                </div>
                            </div>
                            <div class="my-1">
                                <input type="text" name="address" class="form-control" id="address" x-model="address">
                            </div>
                            <div class="my-1">
                                <input type="text" name="address_detail" class="form-control" id="address_detail" x-model="addressDetail" x-ref="address_detail">
                            </div>
                            <div class="my-1">
                                <input type="text" name="address_extra" class="form-control" id="address_extra" x-model="addressExtra">
                            </div>
                        </div>
                        <div class="my-3">
                            <label for="" class="label mb-1">기본 배송지</label>
                            <div>
                                <input type="checkbox" name="is_default" id="address_is_default" class="form-check" x-model="isDefault" :checked="isDefault">
                                <label for="address_is_default" class="mr-2">기본 배송지로 설정</label>
                            </div>
                        </div>
                        <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
                    </div>
                    <div class="modal-footer">
                        <div class="flex justify-between">
                            <button type="button" class="button button-gray" @click="isModalShow = false">닫기</button>
                            <button type="button" class="button button-default" @click="save">저장</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const shippingData = {
              isModalShow: false,
              addressId: '',
              addressTitle: '',
              addressName: '',
              addressPhone: '',
              postcode: '',
              address: '',
              addressDetail: '',
              addressExtra: '',
              isDefault: false,
              searchOpen: false,
              height: 0,
              addressList: [],
              init(){
                this.getAddressList();
                this.$watch('isModalShow', (value, old)=>{
                  if(value === false){
                    console.log('close');
                    this.resetForm();
                  }
                });
              },
              getAddressList(){
                axios.get('/api/user/shipping_addresses').then(res => {
                  this.addressList = res.data.data;
                }).catch(error => {
                    console.log(error.response.data.message);
                    Swal.fire({
                      icon: "error",
                      title: "오류발생",
                      text: error.response.data.message,
                    });
                });
              },
              editAddress(id){
                axios.get(`/api/user/shipping_addresses/${id}`).then(res => {
                  const data = res.data.data;
                  this.addressId = id;
                  this.addressTitle = data.title;
                  this.addressName = data.name;
                  this.addressPhone = data.phone;
                  this.postcode = data.address_postcode;
                  this.address = data.address;
                  this.addressDetail = data.address_detail;
                  this.addressExtra = data.address_extra;
                  this.isDefault = data.is_default;
                  this.openModal();
                }).catch(error => {
                  Swal.fire({
                    icon: "error",
                    title: "오류발생",
                    text: error.response.data.message,
                  });
                });
              },

              deleteAddress(id){
                if(this.addressList.length === 1){
                  Swal.fire({
                    icon: "warning",
                    title: "배송지를 삭제할 수 없습니다.",
                    text: "최소 1개의 배송지를 유지하셔야 합니다.",
                  });
                  return false;
                }

                axios.delete(`/api/user/shipping_addresses/${id}`).then(res => {
                  Swal.fire({
                    icon: "success",
                    title: "성공",
                    text: res.data.message,
                  });
                  this.getAddressList();
                }).catch(error => {
                  Swal.fire({
                    icon: "error",
                    title: "오류발생",
                    text: error.response.data.message,
                  });
                });;
              },
              openModal(){
                  this.isModalShow = true;
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
                      this.addressExtra = extraAddr;

                    } else {
                      this.addressExtra = '';
                    }

                    this.postcode = data.zonecode;
                    this.address = addr;
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
              typePhoneNumber(input){
                this.addressPhone = input.replace(/\D/g, '')
                  .replace(/(\d{3})(\d{1,4})(\d{1,4})/, '$1-$2-$3');
              },
              save(){
                let params = {
                  name: this.addressName,
                  title: this.addressTitle,
                  phone: this.addressPhone,
                  address_postcode: this.postcode,
                  address: this.address,
                  address_detail: this.addressDetail,
                  address_extra: this.addressExtra,
                  is_default: this.isDefault,
                }

                if(this.addressId){
                  axios.put(`/api/user/shipping_addresses/${this.addressId}`, params).then(res => {
                    Swal.fire({
                      icon: "success",
                      title: "성공",
                      text: res.data.message,
                    });
                  }).catch(error => {
                    Swal.fire({
                      icon: "error",
                      title: "오류발생",
                      text: error.response.data.message,
                    });
                  });
                } else {
                  axios.post('/api/user/shipping_addresses', params).then(res => {
                    Swal.fire({
                      icon: "success",
                      title: "성공",
                      text: res.data.message,
                    });
                  }).catch(error => {
                    Swal.fire({
                      icon: "error",
                      title: "오류발생",
                      text: error.response.data.message,
                    });
                  });
                }

                this.resetForm();
                this.getAddressList();
              },
              resetForm(){
                this.addressId = '';
                this.addressName = '';
                this.addressTitle = '';
                this.addressPhone = '';
                this.postcode = '';
                this.address = '';
                this.addressDetail = '';
                this.addressExtra = '';
                this.isDefault = '';
              },
            }
        </script>
        <div class="mt-6">
            <div class="text-lg font-bold pb-2 mb-3 border-b border-gray-900">
                <div>수신동의</div>
                <small class="text-gray-500 my-3">레몬에서 진행하는 다양한 이벤트와 회원님 맞춤 캠페인 추천을 받을 수 있어요.</small>
            </div>
            <div class="mt-6">
                <div class="flex items-center">
                    <input type="checkbox" class="form-check mr-2" id="privacy">
                    <div>
                        <label for="privacy">이벤트 및 캠페인 추천 등 혜택안내를 위한 개인정보 수집∙이용동의</label>
                        <a href="" class="text-purple-700 underline text-sm">내용보기</a>
                    </div>
                </div>
                <div class="flex items-center mt-3">
                    <input type="checkbox" class="form-check mr-2" id="allow_marketing">
                    <div>
                        <label for="allow_marketing">이벤트 및 캠페인 추천 등 혜택안내 수신 동의</label>
                        <a href="" class="text-purple-700 underline text-sm">내용보기</a>
                    </div>
                </div>
                <div class="ml-6 mt-3 flex gap-6">
                    <div>
                        <input type="checkbox" name="allow_marketing[]" value="email" class="form-check mr-2" id="allow_marketing_email">
                        <label for="allow_marketing_email">이메일</label>
                    </div>
                    <div>
                        <input type="checkbox" name="allow_marketing[]" value="sms" class="form-check mr-2" id="allow_marketing_SMS">
                        <label for="allow_marketing_SMS">SMS</label>
                    </div>
                    <div>
                        <input type="checkbox" name="allow_marketing[]" value="push" class="form-check mr-2" id="allow_marketing_push">
                        <label for="allow_marketing_push">앱 푸시 알림</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-24 text-center">
            <button class="text-white bg-gray-900 px-4 py-3 font-bold w-full max-w-[300px]">기본정보 저장</button>
        </div>
    </form>
</x-mypage-layout>
