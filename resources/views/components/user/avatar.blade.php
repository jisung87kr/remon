@props(['user' => $user])
<div class="{{ $attributes->merge(['class' => ""]) }}">
    <div class="flex gap-3 items-center">
        <div class="avatar">
            <img src="https://ui-avatars.com/api/?name={{ $user->name }}" alt="" style="width: 35px;" class="rounded-full">
        </div>
        <div>
            <div class="font-bold">{{ $user->nick_name }}</div>
            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
        </div>
    </div>
</div>
