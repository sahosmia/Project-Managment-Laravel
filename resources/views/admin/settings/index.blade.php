@extends('layouts.admin')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg w-full w-full mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Settings</h2>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="max_member" class="input_label">Project Member Limit</label>
            <input type="number" name="max_member" id="max_member" class="input"
                value="{{ $settings['max_member']->value ?? old('max_member') }}" required>
            @error('max_member')
            <p class=" validate_error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-opacity-50 transition duration-200 ">
            Save Settings
        </button>
    </form>
</div>
@endsection
