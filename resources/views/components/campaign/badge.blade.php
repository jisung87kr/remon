@props(['status' => $status])
@php
    switch ($status){
        case \App\Enums\Campaign\ProgressStatusEnum::READY->value:
            $className = 'badge-gray';
            break;
        case \App\Enums\Campaign\ProgressStatusEnum::Applying->value:
            $className = 'badge-default';
            break;
        case \App\Enums\Campaign\ProgressStatusEnum::Approving->value:
            $className = 'badge-yellow';
            break;
        case \App\Enums\Campaign\ProgressStatusEnum::IN_PROGRESS->value:
            $className = 'badge-green';
            break;
        case \App\Enums\Campaign\ProgressStatusEnum::RESULT->value:
            $className = 'badge-indigo';
            break;
        case \App\Enums\Campaign\ProgressStatusEnum::COMPLETED->value:
            $className = 'badge-purple';
            break;
        default:
            $className = 'badge-pink';
            break;
    }
@endphp
<span {{ $attributes->merge(['class' => "badge $className"]) }}>{{ \App\Enums\Campaign\ProgressStatusEnum::tryFrom($status)->label() }}</span>
