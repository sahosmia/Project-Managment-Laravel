@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Edit User</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="input_label">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter user's name" class="input"
                value="{{ old('name', $user->name) }}" required>
            @error('name')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="input_label">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter user's email" class="input"
                value="{{ old('email', $user->email) }}" required>
            @error('email')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field (Optional - leave blank to keep current password) -->
        <div class="mb-4">
            <label for="password" class="input_label">New Password (optional)</label>
            <input type="password" id="password" name="password" placeholder="Leave blank to keep current password"
                class="input">
            @error('password')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>



        <!-- Role Select Field -->
        <div class="mb-6">
            <label for="role" class="input_label">Role</label>
            <div class="relative">
                <select id="role" name="role" class="input block appearance-none pr-8" required>
                    <option value="">Select a role</option>
                    <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                    <option value="student" @selected(old('role', $user->role) == 'student')>Student</option>
                    <option value="supervisor" @selected(old('role', $user->role) == 'supervisor')>Supervisor</option>
                    <option value="co-supervisor" @selected(old('role', $user->role) == 'co-supervisor')>Co-Supervisor
                    </option>
                    <option value="research_cell" @selected(old('role', $user->role) == 'research_cell')>Research Cell
                    </option>
                </select>
            </div>
            @error('role')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6 @if (old('role', $user->role) != 'co-supervisor') hidden @endif" id="supervisor-select">
            <label for="parent_id" class="input_label">Parent Supervisor</label>
            <div class="relative">
                <select id="parent_id" name="parent_id" class="input">
                    <option value="">Select a supervisor</option>
                    @foreach ($supervisors as $supervisor)
                    <option @selected(old('parent_id', $user->parent_id) == $supervisor->id) value="{{ $supervisor->id
                        }}">{{ $supervisor->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @error('parent_id')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>
        {{-- Student Id --}}
        <div class="mb-6 @if (old('role', $user->role) != 'student') hidden @endif" id="student_id_filed">
            <label for="student_id" class="input_label">Student ID</label>
            <input type="text" id="student_id" name="student_id" placeholder="Enter Student ID" class="input"
                value="{{ old('student_id', $user->student_id) }}">
            @error('student_id')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>
        <!-- Submit Button -->
        <div class="flex items-center justify-center">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 w-full">
                Update User
            </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
            $('#role').on('change', function() {
                if ($(this).val() === 'co-supervisor') {
                    $('#supervisor-select').removeClass('hidden');
                } else {
                    $('#supervisor-select').addClass('hidden');
                }
            });

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