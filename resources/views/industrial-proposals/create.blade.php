@extends('layouts.admin')
@section('title', 'Submit Industrial Proposal')
@section('content')

<div class="bg-white p-8 rounded-xl shadow-lg w-full w-full mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Submit Industrial Proposal</h2>
    <form action="{{ route('industrial-proposals.store') }}" method="POST">
        @csrf
        <div class="flex gap-20 justify-between">
            <div class="flex-1">
                <div class="mb-4">
                    <label for="name" class="input_label">Name</label>
                    <input type="text" id="name" name="name" class="input" value="{{ $user->name }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="email" class="input_label">Email</label>
                    <input type="email" id="email" name="email" class="input" value="{{ $user->email }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="phone" class="input_label">Phone</label>
                    <input type="text" id="phone" name="phone" class="input" value="{{ $user->phone }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="skills" class="input_label">Skills (comma-separated)</label>
                    <input type="text" id="skills" name="skills" class="input" placeholder="e.g., PHP, Laravel, Vue.js"
                        value="{{ old('skills', $industrialProposal->skills ?? "") }}">
                    @error('skills')
                    <p class=" validate_error">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="supervisor_id" class="input_label">Supervisor</label>
                    <div class="relative">
                        <select id="supervisor_id" name="supervisor_id" class="input select2">
                            <option value="">Select Supervisor</option>
                            @foreach ($supervisors as $supervisor)
                            <option value="{{ $supervisor->id }}" {{ old('supervisor_id', $industrialProposal->
                                supervisor_id
                                ??
                                '') ==
                                $supervisor->id ? 'selected' : '' }}>
                                {{ $supervisor->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('supervisor_id')
                        <p class="validate_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>





            </div>
            <div class="flex-1">

                <div class="mb-4 {{$industrialProposal ? 'hidden' : '' }}">
                    <label class="input_label">Did you manage an internship on your own?</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="manage_own_internship" value="yes"
                                class="form-radio h-5 w-5 text-brand-600" {{ old('manage_own_internship')}} checked>
                            <span class="ml-2 text-gray-700">Yes, I manage</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="manage_own_internship" value="no"
                                class="form-radio h-5 w-5 text-brand-600" {{ old('manage_own_internship') }}>
                            <span class="ml-2 text-gray-700">No</span>
                        </label>
                    </div>
                </div>
                <div id="company_manage">
                    <div class="mb-4">
                        <label for="company" class="input_label">Company Name</label>
                        <input type="text" id="company" name="company" class="input" placeholder="Enter your company"
                            value="{{ old('company', $industrialProposal->company ?? "") }}"
                            @readonly($industrialProposal)>
                        @error('company')
                        <p class=" validate_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div id="company_selection">
                    <div class="mb-4">
                        <label for="company_id" class="input_label">Company</label>
                        <div class="relative">
                            <select id="company_id" name="company_id" class="input select2">
                                <option value="">Select Company</option>
                                @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id', $industrialProposal->company_id
                                    ?? '') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('company_id')
                            <p class="validate_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="industrial_supervisor_name" class="input_label">Industrial Supervisor Name</label>
                    <input type="text" id="industrial_supervisor_name" name="industrial_supervisor_name" class="input"
                        placeholder="Enter your industrial supervisor name"
                        value="{{ old('industrial_supervisor_name', $industrialProposal->industrial_supervisor_name ?? "") }}">
                    @error('industrial_supervisor_name')
                    <p class=" validate_error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="industrial_supervisor_email" class="input_label">Industrial Supervisor Email</label>
                    <input type="email" id="industrial_supervisor_email" name="industrial_supervisor_email"
                        class="input" placeholder="Enter your industrial supervisor email"
                        value="{{ old('industrial_supervisor_email', $industrialProposal->industrial_supervisor_email ?? "") }}">
                    @error('industrial_supervisor_email')
                    <p class=" validate_error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="industrial_supervisor_phone" class="input_label">Industrial Supervisor Phone</label>
                    <input type="text" id="industrial_supervisor_phone" name="industrial_supervisor_phone" class="input"
                        placeholder="Enter your industrial supervisor phone"
                        value="{{ old('industrial_supervisor_phone', $industrialProposal->industrial_supervisor_phone ?? "") }}">
                    @error('industrial_supervisor_phone')
                    <p class=" validate_error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-opacity-50 transition duration-200 ">
                        Submit Proposal
                    </button>
                </div>


            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });

        $('input[name="manage_own_internship"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('#company_selection').hide();
                $('#company_manage').show();
            } else {
                $('#company_selection').show();
                $('#company_manage').hide();
            }
        });

        // Trigger the change event on page load to set the initial state
        $('input[name="manage_own_internship"]:checked').trigger('change');
    });
</script>
@endpush
@endsection
