@props(['campaign' => $campaign])
<div class="{{ $attributes->merge(['class' => '']) }}">
    <div class="mb-3">
        <div>
            <x-campaign.badge :status="$campaign->progress_status"></x-campaign.badge>
        </div>
        <div class="flex items-center gap-2 mb-2">
            @foreach($campaign->media as $media)
                <x-media-icon :media="$media"></x-media-icon>
            @endforeach
        </div>
        <div class="text-2xl mb-1 font-bold">{{ $campaign->title }}</div>
        <div>
            @if($campaign->benefit)
                <small class="text-gray-500 line-clamp-2">{{ $campaign->benefit }}</small>
            @endif
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="flex items-center">
            <div class="mr-1 font-bold shrink-0 w-[120px]">캠페인 신청기간</div>
            <div class="text-gray-800">{{ $campaign->application_start_at->format('y.m.d') }} ~ {{ $campaign->application_end_at->format('y.m.d') }}</div>
        </div>
        <div class="flex items-center">
            <div class="mr-1 font-bold shrink-0 w-[120px]">인플루언서 발표</div>
            <div class="text-gray-800">{{ $campaign->announcement_at->format('y.m.d') }}</div>
        </div>
        <div class="flex items-center">
            <div class="mr-1 font-bold shrink-0 w-[120px]">컨텐츠 등록기간</div>
            <div class="text-gray-800">{{ $campaign->registration_start_date_at->format('y.m.d') }} ~ {{ $campaign->registration_end_date_at->format('y.m.d') }}</div>
        </div>
        <div class="flex items-center">
            <div class="mr-1 font-bold shrink-0 w-[120px]">캼페인 종료일</div>
            <div class="text-gray-800">{{ $campaign->result_announcement_date_at->format('y.m.d') }}</div>
        </div>
    </div>
</div>
