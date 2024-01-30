<x-app-layout>
    <div class="container mx-auto p-6">
        <form action="" method="POST">
            @csrf
            <section class="mb-16">
                <h1 class="font-bold text-2xl mb-6">모집내용</h1>
                <div class="border-t border-stone-900 py-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <x-label class="mb-2">상품명</x-label>
                            <x-input class="w-full" name="product_name"></x-input>
                        </div>
                        <div class="col-span-2">
                            <x-label class="mb-2">캠페인 제목</x-label>
                            <x-input class="w-full" name="title"></x-input>
                        </div>
                        <div class="col-span-2">
                            <x-label class="mb-2">제공내역</x-label>
                            <x-textarea class="w-full" name="benefit"></x-textarea>
                        </div>
                        <div class="col-span-2">
                            <x-label class="mb-2">제공포인트</x-label>
                            <x-input class="w-full" name="benefit_point"></x-input>
                        </div>
                        <div class="col-span-2">
                            <x-label class="mb-2">방문 및 예약안내</x-label>
                            <x-textarea class="w-full" name="visit_instruction"></x-textarea>
                        </div>
                        <div class="col-span-2">
                            <x-label class="mb-2">주소</x-label>
                            <x-input class="w-full" name="benefit_point"></x-input>
                        </div>
                        <div class="col-span-2">
                            <x-label class="mb-2">미션</x-label>
                            <div class="flex gap-x-6">
                                <div class="flex items-center gap-x-1">
                                    <x-label>키워드</x-label>
                                    <x-checkbox></x-checkbox>
                                </div>
                                <div class="flex items-center gap-x-1">
                                    <x-label>키워드</x-label>
                                    <x-checkbox></x-checkbox>
                                </div>
                                <div class="flex items-center gap-x-1">
                                    <x-label>키워드</x-label>
                                    <x-checkbox></x-checkbox>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</x-app-layout>
