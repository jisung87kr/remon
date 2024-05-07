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
        <div class="my-3 flex gap-x-2">
            @foreach($campaign->media as $media)
                <x-media-icon :media="$media->media"></x-media-icon>
            @endforeach
            <div class="ml-2 font-bold">{{ $campaign->application_end_at->diffForHumans() }} 마감</div>
        </div>
        <div>
            <div>
                @if($campaign->locationCategories->count() > 0)[{{ $campaign->locationCategories[0]->name }}]@endif
                {{ $campaign->product_name }}
            </div>
            @if($campaign->benefit)
                <small class="text-gray-500 line-clamp-2">{{ $campaign->benefit }}</small>
            @endif
        </div>
        <div class="my-2">
            <small>신청 {{ number_format($campaign->applications()->activeCount()->count()) }}</small><small class="text-gray-500"> / </small><small
                    class="text-gray-500">{{ number_format($campaign->applicant_limit) }}명</small>
        </div>
        <div class="flex gap-1">
            @foreach($campaign->options as $option)
                <div class="p-1 text-xs border text-gray-600">{{ $option->name }}</div>
            @endforeach
        </div>
    </div>
</div>
