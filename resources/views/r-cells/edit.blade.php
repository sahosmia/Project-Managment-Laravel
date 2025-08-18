@extends('layouts.admin')
@section('title', 'R-Cell Edit')
@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Create New R-Cell</h2>

    <form action="{{ route('r_cells.update', $r_cell) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="input_label">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter r-cell's name" class="input"
                value="{{ old('name', $r_cell->name) }}" required>
            @error('name')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>

        <!-- description Field -->
        <div class="mb-4">
            <label for="description" class="input_label">Description</label>
            <textarea id="description" name="description" placeholder="Enter description" class="input"
                required>{{ old('description', $r_cell->description) }}</textarea>

            @error('description')
            <p class="validate_error">{{ $message }}</p>
            @enderror

        </div>


        <!-- Submit Button -->
        <div class="flex items-center justify-center">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 w-full">
                Update R-Cell
            </button>
        </div>
    </form>
</div>
@endsection
