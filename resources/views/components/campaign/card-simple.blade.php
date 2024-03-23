@props(['campaign' => $campaign, 'mode' => null])
@php
    switch ($mode){
        case 'admin':
            $routeName = 'admin.campaigns.edit';
        break;
        default:
            $routeName = 'campaigns.show';
        break;
    }
@endphp
<div {{ $attributes->merge(['class' => 'relative']) }}>
    <x-campaign.card-image :campaign="false" :href="route($routeName, $campaign)">
        <div class="absolute left-0 top-0 bg-gray-900 opacity-75 w-full h-full"></div>
    </x-campaign.card-image>
    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0">
        <div>미리찝하고</div>
        <div>신청하기</div>
    </div>
    <div class="absolute left-0 bottom-0 p-3 text-white">
        @foreach($campaign->media as $media)
            <x-media-icon :media="$media->media"></x-media-icon>
        @endforeach
        <div class="mt-2">
            <div class="font-bold">[{{ $campaign->locationCategories[0]->name }}] {{ $campaign->product_name }}</div>
            <div class="text-xs line-clamp-2">{{ $campaign->benefit }}</div>
        </div>
    </div>
</div>
