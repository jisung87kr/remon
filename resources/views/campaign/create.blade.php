<x-app-layout>
    <div class="container mx-auto p-6">
        <form action="" method="POST">
            @csrf
            <section class="mb-16">
                <h1 class="h3 mb-6">캠페인 설정</h1>
                <div class="border-t border-stone-900 py-3">
                    <div class="grid md:grid-cols-2 divide-y">
                        <div class="col-span-2 py-6">
                            <label class="label mb-2 text-base">유형</label>
                            <ul class="flex gap-3">
                                <li>
                                    <x-radio-button id="category1" name="category[]" value="">체험형</x-radio-button>
                                </li>
                                <li>
                                    <x-radio-button id="category2" name="category[]" value="">방문형</x-radio-button>
                                </li>
                            </ul>
                        </div>
                        <div class="col-span-2 py-6">
                            <label class="label mb-2 text-base">제품 카테고리</label>
                            <ul class="flex gap-3">
                                <li>
                                    <x-checkbox-button id="category1" name="category[]" value="">카테고리1</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="category2" name="category[]" value="">카테고리2</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="category3" name="category[]" value="" checked="true">카테고리3</x-checkbox-button>
                                </li>
                            </ul>
                        </div>
                        <div class="col-span-2 py-6">
                            <label class="label mb-4">지역 카테고리</label>
                            <div>
                                <div>
                                    <div class="mb-3 text-sm">서울</div>
                                    <ul class="flex gap-3">
                                        <li>
                                            <x-radio-button id="radio1" name="radio" value="radio1">radio1</x-radio-button>
                                        </li>
                                        <li>
                                            <x-radio-button id="radio2" name="radio" value="radio2">radio2</x-radio-button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-3 pt-3">
                                    <div class="mb-3 text-sm">서울</div>
                                    <ul class="flex gap-3">
                                        <li>
                                            <x-radio-button id="radio1" name="radio" value="radio1">radio1</x-radio-button>
                                        </li>
                                        <li>
                                            <x-radio-button id="radio2" name="radio" value="radio2">radio2</x-radio-button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-3 pt-3">
                                    <div class="mb-3 text-sm">서울</div>
                                    <ul class="flex gap-3">
                                        <li>
                                            <x-radio-button id="radio1" name="radio" value="radio1">radio1</x-radio-button>
                                        </li>
                                        <li>
                                            <x-radio-button id="radio2" name="radio" value="radio2">radio2</x-radio-button>
                                        </li>
                                    </ul>
                                </div>
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
                            <input type="file" class="form-control">
                        </div>
                        <div class="col-span-2 py-6">
                            <label class="label mb-2 text-base">상세이미지</label>
                            <input type="file" class="form-control" multiple>
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
                                    <input id="bordered-radio-1" type="radio" value="" name="bordered-radio" class="form-radio">
                                    <label for="bordered-radio-1" class="w-full p-4 text-sm font-medium">제공</label>
                                </div>
                                <div class="flex items-center ps-4 border border-gray-200 rounded">
                                    <input checked id="bordered-radio-2" type="radio" value="" name="bordered-radio" class="form-radio">
                                    <label for="bordered-radio-2" class="w-full p-4 text-sm font-medium">미제공</label>
                                </div>
                            </div>
                            <input type="number" id="point" class="form-control mt-3" name="point">
                        </div>
                        <div class="col-span-2 py-6">
                            <label for="visit_instructions" class="label mb-2">방문 및 예약안내</label>
                            <textarea name="visit_instructions" id="visit_instructions" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-span-2 py-6">
                            <div class="grid grid-cols-12 gap-6">
                                <div class="col-span-3">
                                    <label for="address_first" class="label mb-2">우편번호</label>
                                    <input id="address_first" class="form-control" name="address_first">
                                </div>
                                <div class="col-span-9">
                                    <label for="address_first" class="label mb-2">주소</label>
                                    <input id="address_first" class="form-control" name="address_first">
                                </div>
                                <div class="col-span-12">
                                    <label for="address_first" class="label mb-2">주소상세</label>
                                    <input id="address_first" class="form-control" name="address_first">
                                </div>
                                <div class="col-span-12 bg-red-50 h-[300px] rounded-lg flex items-center justify-center">
                                    지도영역
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-16">
                <h1 class="h3 mb-6">미션</h1>
                <div class="border-t border-stone-900 py-3">
                    <div class="grid md:grid-cols-2 divide-y">
                        <div class="col-span-2 py-6">
                            <label class="label mb-2 text-base">미션선택</label>
                            <ul class="flex gap-3">
                                <li>
                                    <x-checkbox-button id="mission1" name="missions[]" value="">미션1</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="mission2" name="missions[]" value="">미션2</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="mission3" name="missions[]" value="" checked="true">미션3</x-checkbox-button>
                                </li>
                            </ul>
                        </div>
                        <div class="col-span-2 py-6">
                            <label for="title_keyword" class="label mb-2">제목키워드</label>
                            <input type="text" id="title_keyword" class="form-control" name="title_keyword">
                        </div>
                        <div class="col-span-2 py-6">
                            <label for="content_keyword" class="label mb-2">본문키워드</label>
                            <input type="text" id="content_keyword" class="form-control" name="content_keyword">
                        </div>
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
                            <ul class="flex gap-3">
                                <li>
                                    <x-checkbox-button id="mission1" name="missions[]" value="">항목1</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="mission2" name="missions[]" value="">항목2</x-checkbox-button>
                                </li>
                                <li>
                                    <x-checkbox-button id="mission3" name="missions[]" value="" checked="true">항목3</x-checkbox-button>
                                </li>
                            </ul>
                        </div>
                        <div class="col-span-2 py-6">
                            <label for="" class="label mb-2">상품옵션</label>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="text" id="" class="form-control" name="" placeholder="옵션명">
                                <input type="text" id="" class="form-control" name="" placeholder="예)빨강, 노랑">
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
</x-app-layout>
