@props(['href' => $href, 'active' => false])
@php
    $activeClass = $active ? 'active' : '';
@endphp
<li {{ $attributes->merge(['class' => "nav-item nav-link {$activeClass}"]) }}>
    <a href="{{ $href }}">
        <span class="mr-2">⚬</span>
        <span>{{ $slot }}</span>
    </a>
</li>
