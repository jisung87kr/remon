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
<div class="card">
    <div class="card-body">
        <div class="relative">
            <a href="{{ route($routeName, $campaign) }}" class="overflow-hidden rounded block">
                <img src="https://placeholder.co/300x300" alt="" class="w-full">
            </a>
            <button class="absolute right-3 top-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart"
                     width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff"
                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/>
                </svg>
            </button>
        </div>
        <div class="my-3 flex gap-x-2">
            @foreach($campaign->media as $media)
                <x-media-icon :media="$media->media"></x-media-icon>
            @endforeach
            <div class="ml-2 font-bold">{{ $campaign->applicant_end_at->diffForHumans() }} 마감</div>
        </div>
        <div>
            <div>[{{ $campaign->locationCategories[0]->name }}] {{ $campaign->product_name }}</div>
            <small class="text-gray-500 line-clamp-2">{{ $campaign->benefit }}</small>
        </div>
        <div class="my-2">
            <small>신청 {{ number_format($campaign->applicants()->count()) }}</small><small class="text-gray-500"> / </small><small
                    class="text-gray-500">{{ number_format($campaign->applicant_limit) }}명</small>
        </div>
        <div class="flex gap-1">
            @foreach($campaign->options as $option)
                <div class="p-1 text-xs border text-gray-600">{{ $option->name }}</div>
            @endforeach
        </div>
    </div>
</div>
