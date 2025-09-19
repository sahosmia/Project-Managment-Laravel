@extends('layouts.admin')
@section('title', 'Create User')
@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Create New User</h2>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="input_label">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter user's name" value="{{ old('name') }}"
                class="input">

            @error('name')
            <p class="validate_error">{{ $message }}</p>
            @enderror

        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="input_label">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter user's email" value="{{ old('email') }}"
                class="input">
            @error('email')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="input_label">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" class="input">

            @error('password')
            <p class="validate_error">{{ $message }}</p>
            @enderror

        </div>

        <!-- Role Select Field -->
        <div class="mb-6">
            <label for="role" class="input_label">Role
                <x-required />
            </label>
            <div class="relative">
                <select id="role" name="role" class="input select2">
                    <option value="">Select a role</option>
                    <option @selected(old('role')=='admin' ) value="admin">Admin</option>
                    <option @selected(old('role')=='faculty_member' ) value="faculty_member">Faculty Member</option>
                    <option @selected(old('role')=='student' ) value="student">Student</option>
                </select>

            </div>

            @error('role')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>


        {{-- Student Id --}}
        <div class="mb-6 hidden" id="student_id_filed">
            <label for="student_id" class="input_label">Student ID</label>
            <input type="text" id="student_id" name="student_id" placeholder="Enter Student ID" class="input"
                value="{{ old('student_id') }}">
            @error('student_id')
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

<script>
    $(document).ready(function() {
            $('#role').on('change', function() {
                if ($(this).val() === 'student') {
                    $('#student_id_filed').removeClass('hidden');
                } else {
                    $('#student_id_filed').addClass('hidden');
                }
            });
        });
</script>
@endsection
