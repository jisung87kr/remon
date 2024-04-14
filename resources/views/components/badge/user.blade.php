@props(['status' => $status])

@php
    use App\Enums\User\StatusEnum;
    $className = 'badge-gray';
    switch ($status){
        case StatusEnum::ACTIVE->value:
            $className = 'badge-green';
            break;
        case StatusEnum::DEACTIVE->value:
            $className = 'badge-gray';
            break;
        case StatusEnum::SLEEP->value:
            $className = 'badge-yellow';
            break;
        case StatusEnum::LEAVE->value:
            $className = 'badge-red';
            break;
    }
@endphp

<span {{ $attributes->merge(['class' => "badge {$className}"]) }}>{{$slot}}</span>
