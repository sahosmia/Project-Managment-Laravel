@extends('layouts.admin')
@section('title', 'Create Department')
@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Create New Department</h2>
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="input_label">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter department's name" value="{{ old('name') }}"
                class="input" required>

            @error('name')
            <p class="validate_error">{{ $message }}</p>
            @enderror

        </div>



        <!-- description Field -->
        <div class="mb-4">
            <label for="description" class="input_label">Description</label>
            <textarea id="description" name="description" placeholder="Enter description" class="input"
                required>{{ old('description') }}</textarea>

            @error('description')
            <p class="validate_error">{{ $message }}</p>
            @enderror

        </div>



        <!-- Submit Button -->
        <div class="flex items-center justify-center">
            <button type="submit"
                class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-opacity-50 transition duration-200 w-full">
                Create Department
            </button>
        </div>
    </form>
</div>
@endsection