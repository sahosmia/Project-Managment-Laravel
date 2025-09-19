<x-guest-layout>
    @section('title', 'Register')

    <h4 class="flex justify-center text-2xl font-bold mb-6 text-gray-800">Register</h4>


    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full input" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full input" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full input" type="text" name="phone" :value="old('phone')"
                required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- User Type -->
        <div class="mt-4">
            <x-input-label :value="__('Register as')" />
            <div class="flex mt-2">
                <div class="flex items-center me-4">
                    <input id="role_student" type="radio" value="student" name="role"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        checked>
                    <label for="role_student"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Student</label>
                </div>
                <div class="flex items-center">
                    <input id="role_faculty" type="radio" value="faculty_member" name="role"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="role_faculty" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Faculty
                        Member</label>
                </div>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Student ID -->
        <div class="mt-4">
            <x-input-label for="student_id" :value="__('Student ID (Optional)')" />
            <x-text-input id="student_id" class="block mt-1 w-full input" type="text" name="student_id"
                :value="old('student_id')" />
            <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full input" type="password" name="password" required
                    autocomplete="new-password" />
                <i
                    class="fa-solid fa-eye-slash toggle-password absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"></i>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full input" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <i
                    class="fa-solid fa-eye-slash toggle-password absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"></i>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
