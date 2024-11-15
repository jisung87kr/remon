<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.10/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=509c2656c00fa9af4782197a888763f6&libraries=services,clusterer,drawing?autoload=false"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
</head>
<body>
    <div class="h-screen" x-data="mydata" style="padding-bottom: 200px">
        <div id="map"
             x-ref="map"
             class="w-full h-full"></div>
        <div class="bg-white fixed left-0 bottom-0 right-0 p-5 md:p-6 z-[99]">
            <div class="bg-blue-600 hover:bg-blue-800 absolute right-2 top-[-60px] rounded-lg cursor-pointer p-1" @click.prevent="alert('준비중인 기능입니다.')">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-focus-2" width="34" height="34" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="12" r=".5" fill="currentColor" />
                    <path d="M12 12m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M12 3l0 2" />
                    <path d="M3 12l2 0" />
                    <path d="M12 19l0 2" />
                    <path d="M19 12l2 0" />
                </svg>
            </div>
            <div class="flex gap-3 mb-3">
                <div>
                    <span>위도 </span><span x-text="lat"></span>
                </div>
                <div>
                    <span>경도: </span><span x-text="long"></span>
                </div>
            </div>
            <div>
                <div>
                    <input type="text" placeholder="위치검색"
                           class="w-full border rounded-lg mb-3"
                           id="address"
                           name="address"
                           readonly
                           x-model="address"
                           @click="execDaumPostcode">
                    <div class="col-span-12 relative border pt-6 bg-white overflow-auto max-h-[400px]" x-show="findAddress">
                        <div x-ref="search_address_element">
                            <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" @click="findAddress=false" alt="접기 버튼">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-3">
                    <div class="col-span-3">
                        <div class="mb-2">위치 공유</div>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="text-center">
                                <button class="rounded-lg bg-gray-500 w-full text-center p-2 md:p-6" @click="shareLocation('accident')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto icon icon-tabler icon-tabler-alert-hexagon" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                                        <path d="M12 8v4" />
                                        <path d="M12 16h.01" />
                                    </svg>
                                </button>
                                <div class="mt-2 font-bold">사고</div>
                            </div>
                            <div class="text-center">
                                <button class="rounded-lg bg-gray-500 w-full text-center p-2 md:p-6" @click="shareLocation('fault')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto icon icon-tabler icon-tabler-forbid-2" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M9 15l6 -6" />
                                    </svg>
                                </button>
                                <div class="mt-2 font-bold">고장</div>
                            </div>
                            <div class="text-center">
                                <button class="rounded-lg bg-gray-500 w-full text-center p-2 md:p-6" @click="shareLocation('other')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto icon icon-tabler icon-tabler-message-circle-2" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" />
                                    </svg>
                                </button>
                                <div class="mt-2 font-bold">기타</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">긴급전화</div>
                        <div class="text-center">
                            <a href="tel:010-5354-7072" class="rounded-lg bg-red-600 w-full text-center p-2 md:p-6 block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto icon icon-tabler icon-tabler-phone-call" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                    <path d="M15 7a2 2 0 0 1 2 2" />
                                    <path d="M15 3a6 6 0 0 1 6 6" />
                                </svg>
                            </a>
                            <div class="mt-2 font-bold">구급대</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const mydata = {
          lat: '33.450701',
          long: '126.570667',
          mapObject: null,
          marker: null,
          addressPostcode: '',
          address: '',
          addressExtra: '',
          findAddress: false,
          infowindow: null,
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

            this.infowindow = new kakao.maps.InfoWindow({zindex:1});

            //컨트롤러
            let mapTypeControl = new kakao.maps.MapTypeControl();
            this.mapObject.addControl(mapTypeControl, kakao.maps.ControlPosition.TOPRIGHT);

            // 줌
            let zoomControl = new kakao.maps.ZoomControl();
            this.mapObject.addControl(zoomControl, kakao.maps.ControlPosition.RIGHT);

            kakao.maps.event.addListener(this.mapObject, 'click', (mouseEvent) => {
              this.addMarker(mouseEvent.latLng);
              this.lat = mouseEvent.latLng.Ma;
              this.long = mouseEvent.latLng.La;
              this.latLongToAddress(this.long, this.lat);
            });

            this.latLongToAddress(this.long, this.lat);
          },
          latLongToAddress(long, lat){
            let geocoder = new daum.maps.services.Geocoder();
            geocoder.coord2Address(long, lat, (result, status) => {
              if (status === kakao.maps.services.Status.OK) {
                this.address = result[0].road_address.address_name ? result[0].road_address.address_name : result[0].address.address_name;
                var detailAddr = !!result[0].road_address ? '<div>도로명주소 : ' + result[0].road_address.address_name + '</div>' : '';
                detailAddr += '<div>지번 주소 : ' + result[0].address.address_name + '</div>';

                var content = '<div class="bAddr" style="width: 400px; height: 100px; padding: 10px">' +
                  '<span class="title">법정동 주소정보</span>' +
                  detailAddr +
                  '</div>';


                // 인포윈도우에 클릭한 위치에 대한 법정동 상세 주소정보를 표시합니다
                // this.infowindow.setContent(content);
                // this.infowindow.open(this.mapObject, this.marker);
              }
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
          addMarker(position){
              this.marker.setMap(null);
              this.marker = new kakao.maps.Marker({
                position: position
              });

              this.marker.setMap(this.mapObject);
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
                //this.$refs.address_detail.focus();

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
          },
          shareLocation(type){
            if(!confirm('위치공유를 하시겠습니까?')){
              return false;
            }
            let msg = '';
            switch (type){
              case 'accident':
                msg = `[사고] 공유됨\n- 위치정보: ${this.lat}/${this.long}\n- 주소: ${this.address}`;
                break;
              case 'fault':
                msg = `[고장] 공유됨\n- 위치정보: ${this.lat}/${this.long}\n- 주소: ${this.address}`;
                break;
              case 'other':
                msg = `[기타] 공유됨\n- 위치정보: ${this.lat}/${this.long}\n- 주소: ${this.address}`;
                break;
              default:
                msg = `타입을 확인 할수 없습니다.`;
                break;
            }
            alert(msg);
          }
        }
    </script>
</body>
</html>
