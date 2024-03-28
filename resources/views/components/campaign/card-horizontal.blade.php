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

<div {{ $attributes->merge(['class' => "flex"]) }}>
    <div class="shrink-0 mr-3 w-[100px]">
        <x-campaign.card-image :campaign="false" :href="route($routeName, $campaign)"></x-campaign.card-image>
    </div>
    <div>
        <div class="mb-2 flex">
            @foreach($campaign->media as $media)
                <x-media-icon :media="$media->media"></x-media-icon>
            @endforeach
            <div class="ml-2 text-sm font-bold">{{ $campaign->application_end_at->diffForHumans() }} 마감</div>
        </div>
        <div>
            <a href="{{ route($routeName, $campaign) }}">[{{ $campaign->locationCategories[0]->name }}] {{ $campaign->product_name }}</a>
        </div>
        <div>
            <small class="text-gray-500 line-clamp-2">{{ $campaign->benefit }}</small>
        </div>
    </div>
</div>
