@props(['action' => ''])
<div {{ $attributes->merge(['class' => 'card !p-0']) }}>
    <form action="{{ $action }}">
        @isset($filter)
        <div class="py-3">
            <div class="mb-3 font-bold text-l">필터</div>
            {{ $filter }}
        </div>
        @endisset
        @isset($search)
        {{ $search }}
        @endisset
    </form>
    {{ $slot }}
</div>
