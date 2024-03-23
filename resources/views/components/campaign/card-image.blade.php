@props(['campaign' => $campaign, 'href' => $href])
<div {{ $attributes->merge(['class' => 'relative']) }}>
    {{ $slot }}
    <a href="{{ $href }}" class="overflow-hidden rounded block">
        @isset($campaign->thumbnails[0])
            <img src="{{Storage::url($campaign->thumbnails[0]['file_path'])}}" alt="" class="w-full">
        @else
            <img src="https://placeholder.co/300x300" alt="" class="w-full">
        @endisset
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
