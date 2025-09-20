@extends('layouts.admin')

@section('title', 'View Profile')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Profile Information') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __("Your account's profile information.") }}
                </p>

                <div class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                    </div>
                    @if ($user->role == "student")

                    <div>
                        <x-input-label for="student_id" :value="__('Student ID')" />
                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $user->student_id }}</p>
                    </div>
                    @endif
                    <div>
                        <x-input-label for="role" :value="__('Role')" />
                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $user->role }}</p>
                    </div>
                    <div>
                        <x-input-label for="phone" :value="__('Phone')" />
                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $user->phone }}</p>
                    </div>

                    @if ($user->role == 'faculty_member' && $user->rCell)
                    <div>
                        <x-input-label for="r_cell" :value="__('R-Cell')" />
                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $user->rCell->name }}</p>
                    </div>
                    @endif
                </div>

                <div class="flex items-center gap-4 mt-6">
                    <a href="{{ route('profile.edit') }}">
                        <x-primary-button>{{ __('Edit Profile') }}</x-primary-button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
