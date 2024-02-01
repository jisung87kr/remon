@props(['color' => 'default', 'size' => null, 'border' => false])

@php
    if($size == 'lg'){
        $borderClass = 'text-sm';
    } else {
        $sizeClass = 'text-xs';
    }

@endphp


@switch($color)
    @case('default')
        @php
            $borderClass = '';
            if($border){
                $borderClass = 'border border-blue-400';
            }
        @endphp
        <span {{ $attributes->merge(['class' => "bg-blue-100 text-blue-800 font-medium me-2 px-2.5 py-0.5 rounded $sizeClass $borderClass"]) }}>{{ $slot }}</span>
        @break
    @case('dark')
        @php
            $borderClass = '';
            if($border){
                $borderClass = 'border border-gray-500';
            }
        @endphp
        <span {{ $attributes->merge(['class' => "bg-gray-100 text-gray-800 font-medium me-2 px-2.5 py-0.5 rounded $sizeClass $borderClass"]) }}>{{ $slot }}</span>
        @break
    @case('red')
        @php
            $borderClass = '';
            if($border){
                $borderClass = 'border border-red-400';
            }
        @endphp
        <span {{ $attributes->merge(['class' => "bg-red-100 text-red-800 font-medium me-2 px-2.5 py-0.5 rounded $sizeClass $borderClass"]) }}>{{ $slot }}</span>
        @break
    @case('green')
        @php
            $borderClass = '';
            if($border){
                $borderClass = 'border border-green-400';
            }
        @endphp
        <span {{ $attributes->merge(['class' => "bg-green-100 text-green-800 font-medium me-2 px-2.5 py-0.5 rounded $sizeClass $borderClass"]) }}>{{ $slot }}</span>
        @break
    @case('yellow')
        @php
            $borderClass = '';
            if($border){
                $borderClass = 'border border-yellow-300';
            }
        @endphp
        <span {{ $attributes->merge(['class' => "bg-yellow-100 text-yellow-800 font-medium me-2 px-2.5 py-0.5 rounded $sizeClass $borderClass"]) }}>{{ $slot }}</span>
        @break
    @case('indigo')
        @php
            $borderClass = '';
            if($border){
                $borderClass = 'border border-indigo-400';
            }
        @endphp
        <span {{ $attributes->merge(['class' => "bg-indigo-100 text-indigo-800 font-medium me-2 px-2.5 py-0.5 rounded $sizeClass $borderClass"]) }}>{{ $slot }}</span>
        @break
    @case('purple')
        @php
            $borderClass = '';
            if($border){
                $borderClass = 'border border-purple-400';
            }
        @endphp
        <span {{ $attributes->merge(['class' => "bg-purple-100 text-purple-800 font-medium me-2 px-2.5 py-0.5 rounded $sizeClass $borderClass"]) }}>{{ $slot }}</span>
        @break
    @case('pink')
        @php
            $borderClass = '';
            if($border){
                $borderClass = 'border border-pink-400';
            }
        @endphp
        <span {{ $attributes->merge(['class' => "bg-pink-100 text-pink-800 font-medium me-2 px-2.5 py-0.5 rounded $sizeClass $borderClass"]) }}>{{ $slot }}</span>
        @break
@endswitch
