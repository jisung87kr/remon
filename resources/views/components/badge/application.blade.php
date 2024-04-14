@props(['status' => $status])

@php
    use App\Enums\Campaign\ApplicationStatus;
    $className = 'badge-gray';
    switch ($status){
        case ApplicationStatus::APPLIED->value:
            $className = 'badge-default';
            break;
        case ApplicationStatus::CANCELED->value:
            $className = 'badge-gray';
            break;
        case ApplicationStatus::APPROVED->value:
            $className = 'badge-yellow';
            break;
        case ApplicationStatus::REJECTED->value:
            $className = 'badge-gray';
            break;
        case ApplicationStatus::PENDING->value:
            $className = 'badge-gray';
            break;
        case ApplicationStatus::POSTED->value:
            $className = 'badge-purple';
            break;
        case ApplicationStatus::COMPLETED->value:
            $className = 'badge-green';
            break;
    }
@endphp

<span {{ $attributes->merge(['class' => "badge {$className}"]) }}>{{$slot}}</span>
