@extends('layouts.admin')
@section('title', 'Submit Industrial Proposal')
@section('content')

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Submit Industrial Proposal</h2>
    <form action="{{ route('industrial-proposals.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="skills" class="input_label">Skills (comma-separated)</label>
            <input type="text" id="skills" name="skills" class="input" placeholder="e.g., PHP, Laravel, Vue.js" value="{{ old('skills') }}">
            @error('skills')
            <p class="validate_error">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="company_id" class="input_label">Company</label>
            <div class="relative">
                <select id="company_id" name="company_id" class="input select2">
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>{{ $company->name }}</option>
                    @endforeach
                </select>
                @error('company_id')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="supervisor_id" class="input_label">Supervisor</label>
            <div class="relative">
                <select id="supervisor_id" name="supervisor_id" class="input select2">
                    <option value="">Select Supervisor</option>
                    @foreach ($supervisors as $supervisor)
                    <option value="{{ $supervisor->id }}" @selected(old('supervisor_id') == $supervisor->id)>{{ $supervisor->name }}</option>
                    @endforeach
                </select>
                @error('supervisor_id')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-center mt-6">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 w-full">
                Submit Proposal
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@endpush
@endsection
