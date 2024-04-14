<x-admin-layout>
    <div class="card">
        <form method="POST" action="{{ route('admin.user.business.update', $user) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="role" value="{{ \App\Enums\RoleEnum::BUSINESS_USER->value }}">
            <div>
                <x-label for="name" value="이름" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error for="name"></x-input-error>
            </div>

            <div class="mt-4">
                <x-label for="nick_name" value="닉네임" />
                <x-input id="nick_name" class="block mt-1 w-full" type="text" name="nick_name" :value="old('nick_name', $user->nick_name)" required autofocus autocomplete="nick_name" />
                <x-input-error for="nick_name"></x-input-error>
            </div>

            <div class="mt-4">
                <x-label for="email" value="이메일" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error for="email"></x-input-error>
            </div>

            <div class="flex items-center justify-end mt-4 gap-3">
                <a href="{{ route('admin.user.business.index') }}" class="button button-light text-xs">목록</a>
                <button type="submit" class="button button-default">수정</button>
            </div>
        </form>
    </div>
</x-admin-layout>
