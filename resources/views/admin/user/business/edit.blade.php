<x-admin-layout>
    <div class="card">
        <form method="POST" action="{{ route('admin.user.business.update', $user) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="role" value="{{ \App\Enums\RoleEnum::BUSINESS_USER->value }}">
            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error for="name"></x-input-error>
            </div>

            <div class="mt-4">
                <x-label for="nick_name" value="{{ __('Nick name') }}" />
                <x-input id="nick_name" class="block mt-1 w-full" type="text" name="nick_name" :value="old('nick_name', $user->nick_name)" required autofocus autocomplete="nick_name" />
                <x-input-error for="nick_name"></x-input-error>
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error for="email"></x-input-error>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Update') }}
                </x-button>
            </div>
        </form>
    </div>
</x-admin-layout>
