@extends('layouts.admin')
@section('title', 'Edit Company')
@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Edit Company</h2>

    <form action="{{ route('companies.update', $company) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="input_label">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter company's name" class="input"
                value="{{ old('name', $company->name) }}" required>
            @error('name')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>
        <!-- Phone Field -->
        <div class="mb-4">
            <label for="phone" class="input_label">Phone</label>
            <input type="text" id="phone" name="phone" placeholder="Enter company's phone" class="input"
                value="{{ old('phone', $company->phone) }}" required>
            @error('phone')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>
        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="input_label">Email</label>
            <input type="text" id="email" name="email" placeholder="Enter company's email" class="input"
                value="{{ old('email', $company->email) }}" required>
            @error('email')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>
        <!-- Location Field -->
        <div class="mb-4">
            <label for="location" class="input_label">Location</label>
            <input type="text" id="location" name="location" placeholder="Enter company's location" class="input"
                value="{{ old('location', $company->location) }}" required>
            @error('location')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>

        <!-- description Field -->
        <div class="mb-4">
            <label for="description" class="input_label">Description</label>
            <textarea id="description" name="description" placeholder="Enter description"
                class="input">{{ old('description', $company->description) }}</textarea>

            @error('description')
            <p class="validate_error">{{ $message }}</p>
            @enderror

        </div>

        <!-- Quantity Field -->
        <div class="mb-4">
            <label for="quantity" class="input_label">Quantity</label>
            <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" class="input"
                value="{{ old('quantity', $company->quantity) }}" required>
            @error('quantity')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>


        <!-- Submit Button -->
        <div class="flex items-center justify-center">
            <button type="submit"
                class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-opacity-50 transition duration-200 w-full">
                Update Company
            </button>
        </div>
    </form>
</div>
@endsection
