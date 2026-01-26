<x-guest-layout>
    @section('title', 'OTP Verification')

    <h4 class="flex justify-center text-2xl font-bold mb-6 text-gray-800">OTP Verification</h4>

    @if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <!-- OTP -->
        <div>
            <x-input-label for="otp" :value="__('OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full input" type="text" name="otp" required autofocus />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Verify OTP') }}
            </x-primary-button>
        </div>
    </form>

    <form method="POST" action="{{ route('otp.resend') }}" class="mt-2 text-right">
        @csrf
        <button type="submit"
            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            {{ __('Resend OTP') }}
        </button>
    </form>
</x-guest-layout>
