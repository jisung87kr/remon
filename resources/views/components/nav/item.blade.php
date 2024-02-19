@props(['href' => $href])

<li class="nav-item nav-link">
    <a href="{{ $href }}">
        <span class="mr-2">⚬</span>
        <span>{{ $slot }}</span>
    </a>
</li>
