@extends('layouts.admin')
@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Create New User</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="input_label">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter user's name" value="{{ old('name') }}"
                class="input" required>

            @error('name')
            <p class="validate_error">{{ $message }}</p>
            @enderror

        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="input_label">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter user's email" value="{{ old('email') }}"
                class="input" required>
            @error('email')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="input_label">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" class="input" required>

            @error('password')
            <p class="validate_error">{{ $message }}</p>
            @enderror

        </div>

        <!-- Role Select Field -->
        <div class="mb-6">
            <label for="role" class="input_label">Role</label>
            <div class="relative">
                <select id="role" name="role" class="input" required>
                    <option value="">Select a role</option>
                    <option @selected(old('role')=='admin' ) value="admin">Admin</option>
                    <option @selected(old('role')=='research_cell' ) value="research_cell">Research Cell</option>
                    <option @selected(old('role')=='supervisor' ) value="supervisor">Supervisor</option>
                    <option @selected(old('role')=='co-supervisor' ) value="co-supervisor">Co-Supervisor</option>
                    <option @selected(old('role')=='student' ) value="student">Student</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 6.757 7.586 5.343 9z" />
                    </svg>
                </div>
            </div>

            @error('role')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-center">
            <button type="submit"
                class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-opacity-50 transition duration-200 w-full">
                Create User
            </button>
        </div>
    </form>
</div>
@endsection