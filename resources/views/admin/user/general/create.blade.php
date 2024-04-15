<x-admin-layout>
    <div class="card">
        <form method="POST" action="{{ route('admin.user.general.store') }}">
            @csrf
            <input type="hidden" name="role" value="{{ \App\Enums\RoleEnum::GENERAL_USER->value }}">
            <div>
                <x-label for="name" value="이름" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error for="name"></x-input-error>
            </div>

            <div class="mt-4">
                <x-label for="email" value="이메일" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error for="email"></x-input-error>
            </div>

            <div class="mt-4">
                <x-label for="password" value="비밀번호" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error for="password"></x-input-error>
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="비민번호 확인" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error for="password_confirmation"></x-input-error>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('admin.user.general.index') }}" class="button button-light text-xs">목록</a>
                <button type="submit" class="button button-default">수정</button>
            </div>
        </form>
    </div>
</x-admin-layout>
