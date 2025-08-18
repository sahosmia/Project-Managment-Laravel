<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" class="block mt-1 w-full input" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <input id="password" class="block mt-1 w-full input" type="password" name="password" required
                    autocomplete="current-password" />
                <i
                    class="fa-solid fa-eye-slash toggle-password absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"></i>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>



        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>