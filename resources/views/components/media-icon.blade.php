@props(['media' => $media])
@switch($media)
    @case(App\Enums\Campaign\MediaEnum::NAVER_BLOG->value)
        <img src="{{ Vite::asset('resources/images/media/blog.svg') }}" alt="">
        @break
    @case(App\Enums\Campaign\MediaEnum::INSTAGRAM->value)
        <img src="{{ Vite::asset('resources/images/media/instagram.svg') }}"
             alt="">
        @break
    @case(App\Enums\Campaign\MediaEnum::YOUTUBE->value)
        <img src="{{ Vite::asset('resources/images/media/youtube.svg') }}"
             alt="" class="w-[20px]">
        @break
@endswitch
