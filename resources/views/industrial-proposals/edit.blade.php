@extends('layouts.admin')
@section('title', 'Edit Industrial Proposal')
@section('content')

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Industrial Proposal</h2>
    <form action="{{ route('industrial-proposals.update', $industrial_proposal) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="input_label">Student Name</label>
            <input type="text" id="name" name="name" class="input" value="{{ $industrial_proposal->user->name }}"
                readonly>
        </div>

        <div class="mb-4">
            <label for="email" class="input_label">Student Email</label>
            <input type="email" id="email" name="email" class="input" value="{{ $industrial_proposal->user->email }}"
                readonly>
        </div>

        <div class="mb-4">
            <label for="company_id" class="input_label">Company</label>
            <div class="relative">
                <select id="company_id" name="company_id" class="input select2">
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @selected($industrial_proposal->company_id == $company->id)>{{
                        $company->name }}</option>
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
                    <option value="{{ $supervisor->id }}" @selected($industrial_proposal->supervisor_id ==
                        $supervisor->id)>{{ $supervisor->name }}</option>
                    @endforeach
                </select>
                @error('supervisor_id')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="status" class="input_label">Status</label>
            <div class="relative">
                <select id="status" name="status" class="input">
                    <option value="pending" @selected($industrial_proposal->status == 'pending')>Pending</option>
                    <option value="inprogress" @selected($industrial_proposal->status == 'inprogress')>In Progress
                    </option>
                    <option value="complete" @selected($industrial_proposal->status == 'complete')>Complete</option>
                </select>
                @error('status')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-center mt-6">
            <button type="submit"
                class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-opacity-50 transition duration-200 w-full">
                Update Proposal
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
