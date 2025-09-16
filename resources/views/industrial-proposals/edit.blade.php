@extends('layouts.admin')
@section('title', 'Edit Industrial Proposal')
@section('content')

<div class="bg-white p-8 rounded-xl shadow-lg w-full  mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Industrial Proposal</h2>
    <form action="{{ route('industrial-proposals.update', $industrial_proposal) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="flex gap-20">
            <div class="flex-1">
                <div class="mb-4">
                    <label for="name" class="input_label">Student Name</label>
                    <input type="text" id="name" name="name" class="input"
                        value="{{ $industrial_proposal->user->name }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="email" class="input_label">Student Email</label>
                    <input type="email" id="email" name="email" class="input"
                        value="{{ $industrial_proposal->user->email }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="skills" class="input_label">Skills</label>
                    <input type="text" id="skills" name="skills" class="input"
                        value="{{ $industrial_proposal->skills }}" readonly>
                    @error('skills')
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
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
                            <option value="pending" @selected($industrial_proposal->status == 'pending')>Pending
                            </option>
                            <option value="inprogress" @selected($industrial_proposal->status == 'inprogress')>In
                                Progress
                            </option>
                            <option value="complete" @selected($industrial_proposal->status == 'complete')>Complete
                            </option>
                        </select>
                        @error('status')
                        <p class="validate_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>



            </div>

            <div class="flex-1">


                <div id="company_manage">
                    <div class="mb-4">
                        <label for="company" class="input_label">Company Name</label>
                        <input type="text" id="company" name="company" class="input" placeholder="Enter your company"
                            value="{{ old('company', $industrial_proposal->company ?? "") }}"
                            @readonly($industrial_proposal)>
                        @error('company')
                        <p class=" validate_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>



                <div class="mb-4">
                    <label for="industrial_supervisor_name" class="input_label">Industrial Supervisor Name</label>
                    <input type="text" id="industrial_supervisor_name" name="industrial_supervisor_name" class="input"
                        @readonly($industrial_proposal) placeholder="Enter your industrial supervisor name"
                        value="{{ old('industrial_supervisor_name', $industrial_proposal->industrial_supervisor_name ?? "") }}">
                    @error('industrial_supervisor_name')
                    <p class=" validate_error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="industrial_supervisor_email" class="input_label">Industrial Supervisor Email</label>
                    <input type="email" id="industrial_supervisor_email" name="industrial_supervisor_email"
                        @readonly($industrial_proposal) class="input"
                        placeholder="Enter your industrial supervisor email"
                        value="{{ old('industrial_supervisor_email', $industrial_proposal->industrial_supervisor_email ?? "") }}">
                    @error('industrial_supervisor_email')
                    <p class=" validate_error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="industrial_supervisor_phone" class="input_label">Industrial Supervisor Phone</label>
                    <input type="text" id="industrial_supervisor_phone" name="industrial_supervisor_phone" class="input"
                        @readonly($industrial_proposal) placeholder="Enter your industrial supervisor phone"
                        value="{{ old('industrial_supervisor_phone', $industrial_proposal->industrial_supervisor_phone ?? "") }}">
                    @error('industrial_supervisor_phone')
                    <p class=" validate_error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-opacity-50 transition duration-200 ">
                        Update Proposal
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
    });
</script>
@endpush
@endsection
