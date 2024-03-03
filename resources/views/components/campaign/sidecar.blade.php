@props(['campaign' => $campaign, 'useLink' => false, 'useThumbnail' => false])
<div class="col-span-8 lg:col-span-2">
    <div class="lg:sticky lg:top-0">
        @if($useThumbnail)
        <div class="py-6 border-b">
            @if($campaign->thumbnails[0])
                <img src="{{Storage::url($campaign->thumbnails[0]['file_path'])}}" alt="">
            @else
                <img src="https://placeholder.co/1000x1000" alt="">
            @endif
            <div class="mt-3">
                <div class="font-bold text-xl">[{{ $campaign->locationCategories[0]->name }}] {{ $campaign->product_name }}</div>
                <div class="font-bold text-gray-500">{{ $campaign->title }}</div>
                <div class="flex gap-3 mt-3">
                    <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="">
                    <div class="p-1 text-xs border text-gray-600">예약없음</div>
                </div>
            </div>
        </div>
        @endif
        <div class="py-6 border-b">
            <div class="flex font-bold my-2">
                <div class="shrink-0 w-[110px] mr-1">캠페인 신청기간</div>
                <div>{{ $campaign->applicant_start_at->format('m.d') }}
                    ~ {{ $campaign->applicant_end_at->format('m.d') }}</div>
            </div>
            <div class="flex text-gray-500 my-2">
                <div class="shrink-0 w-[110px] mr-1">인플루언서 발표</div>
                <div>{{ $campaign->announcement_at->format('m.d') }}</div>
            </div>
            <div class="flex text-gray-500 my-2">
                <div class="shrink-0 w-[110px] mr-1">콘텐츠 등록기간</div>
                <div>{{ $campaign->registration_start_date_at->format('m.d') }}
                    ~ {{ $campaign->registration_end_date_at->format('m.d') }}</div>
            </div>
            <div class="flex text-gray-500 my-2">
                <div class="shrink-0 w-[110px] mr-1">콘텐츠 결과발표</div>
                <div>{{ $campaign->result_announcement_date_at->format('m.d') }}</div>
            </div>
        </div>
        @if($useLink)
        <div>
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
        </div>
        @endif
        <div class="py-6">
            <a href="" class="bg-gray-900 text-white px-5 py-4 block text-center font-bold">캠페인 신청하기</a>
        </div>
    </div>
</div>
