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
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-20 h-20 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center border-2 border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                            @if ($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                                class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-user text-3xl text-gray-400 dark:text-gray-500"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>

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
