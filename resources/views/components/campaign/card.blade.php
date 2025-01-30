@props(['campaign' => $campaign, 'mode' => null])
@php
    switch ($mode){
        case 'admin':
            $routeName = 'admin.campaign.edit';
        break;
        default:
            $routeName = 'campaign.show';
        break;
    }
@endphp
<div class="card">
    <div class="card-body">
        <x-campaign.card-image :campaign="$campaign" :href="route($routeName, $campaign)"></x-campaign.card-image>
        <div class="my-1 md:my-3 flex gap-x-[7px]">
            @foreach($campaign->media as $media)
                <x-media-icon :media="$media->media"></x-media-icon>
            @endforeach
            <div class="m1-2 text-sm md:text-base font-bold text-gray-600">{{ $campaign->application_end_at->diffForHumans() }} 마감</div>
        </div>
        <div>
            <div class="text-sm md:text-base font-bold break-keep">
                @if($campaign->locationCategories->count() > 0)[{{ $campaign->locationCategories[0]->name }}]@endif
                <a href="{{ route($routeName, $campaign) }}">{{ $campaign->product_name }}</a>
            </div>
            <small class="text-gray-500 line-clamp-2 break-keep">{{ $campaign->title }}</small>
        </div>
        <div class="my-2">
            <small>신청 {{ number_format($campaign->applications()->active()->count()) }}</small><small class="text-gray-500"> / </small><small
                    class="text-gray-500">{{ number_format($campaign->application_limit) }}명</small>
        </div>
        <div class="flex gap-1">
            @foreach($campaign->options as $option)
                <div class="p-1 text-xs border text-gray-600">{{ $option->name }}</div>
            @endforeach
        </div>
    </div>
</div>
