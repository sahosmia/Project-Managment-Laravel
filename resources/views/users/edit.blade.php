@extends('layouts.admin')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Create New User</h2>
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
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 w-full">
                Update User
            </button>
        </div>
    </form>
</div>
@endsection