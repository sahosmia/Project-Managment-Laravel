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
                value="{{ old('name', $r_cell->name) }}">
            @error('name')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>

        <!-- description Field -->
        <div class="mb-4">
            <label for="description" class="input_label">Description</label>
            <textarea id="description" name="description" placeholder="Enter description"
                class="input">{{ old('description', $r_cell->description) }}</textarea>

            @error('description')
            <p class="validate_error">{{ $message }}</p>
            @enderror

        </div>

        <!-- Research Cell Head Field -->
        <div class="mb-4">
            <label for="research_cell_head" class="input_label">Research Cell Head</label>
            <select id="research_cell_head" name="research_cell_head" class="input select2">
                <option value="">Select a faculty member</option>
                @foreach ($faculty_members as $faculty)
                <option value="{{ $faculty->id }}" {{ old('research_cell_head', $r_cell->research_cell_head) ==
                    $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                @endforeach
            </select>

            @error('research_cell_head')
            <p class="validate_error">{{ $message }}</p>
            @enderror

        </div>


        <!-- Submit Button -->
        <div class="flex items-center justify-center">
            <button type="submit"
                class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-opacity-50 transition duration-200 w-full">
                Update R-Cell
            </button>
        </div>
    </form>
</div>
@endsection
