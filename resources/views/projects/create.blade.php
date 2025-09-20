@extends('layouts.admin')
@section('title', 'Project & Thesis Proposal Submit')
@section('content')

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-6xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Create New Project & Thesis Proposal</h2>
    <form action="{{route('projects.store')}}" method="POST">
        @csrf


        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            <!-- Department -->
            <div>
                <label for="department_id" class="input_label">Department</label>
                <div class="relative">
                    <select id="department_id" name="department_id" class="input select2">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected(old('department_id')==$department->id)>{{
                            $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Academic Year -->
            <div>
                <label for="academic_year" class="input_label">Academic Year</label>
                <div class="relative">
                    <select id="academic_year" name="academic_year" class="input select2">
                        <option value="">Select Year</option>
                        @php
                        $currentYear = date('Y');
                        for ($i = $currentYear + 1; $i >= $currentYear - 5; $i--) {
                        echo "<option value='{$i}' " . (old('academic_year') == $i ? 'selected' : '') . ">{$i}</option>
                        ";
                        }
                        @endphp
                    </select>
                    @error('academic_year')
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Semester -->
            <div>
                <label for="semester" class="input_label">Semester</label>
                <div class="relative">
                    <select id="semester" name="semester" class="input select2">
                        <option value="">Select Semester</option>
                        <option @selected(old('semester')=='fall' ) value="Fall">Fall</option>
                        <option @selected(old('semester')=='summer' ) value="Summer">Summer</option>
                        <option @selected(old('semester')=='spring' ) value="Spring">Spring</option>
                    </select>
                    @error('semester')
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Course Type -->
            <div>
                <label for="course_type" class="input_label">Course Type</label>
                <div class="relative">
                    <select id="course_type" name="course_type" class="input select2">
                        <option value="">Select Course Type</option>
                        <option @selected(old('course_type')=='project' ) value="Project">Project</option>
                        <option @selected(old('course_type')=='thesis' ) value="Thesis">Thesis</option>
                    </select>
                    @error('course_type')
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Course Title -->
            <div>
                <label for="course_title" class="input_label">Course Title</label>
                <input type="text" id="course_title" name="course_title" class="input" placeholder="Enter course title"
                    value="{{ old('course_title', 'Project & Thesis') }}" readonly> {{-- Kept readonly as per your code
                --}}
                @error('course_title')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Course Code -->
            <div>
                <label for="course_code" class="input_label">Course Code</label>
                <input type="text" id="course_code" name="course_code" class="input" placeholder="Enter course code"
                    value="{{ old('course_code') }}">
                @error('course_code')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Group Member's Information -->
        <div class="mb-6 mt-6 border border-gray-200 rounded-lg p-4 bg-gray-50">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Group Member's Information</h3>
            <div id="group-members-container">
                <!-- Initial member fields -->
                <div class="group-member-item mb-4 p-3 border border-gray-300 rounded-lg bg-white relative">
                    <h4 class="font-medium text-gray-800 mb-3">Member 1</h4>
                    <label for="member_user_id_0" class="input_label">Member Name</label>
                    <div class="relative">
                        <select id="member_user_id_0" name="members[0][user_id]" class="input member-select select2">
                            <option value="">Select Member</option>
                            @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(old('members.0.user_id', auth()->id())
                                == $student->id)>
                                {{ $student->name }} ({{$student->student_id}})
                            </option>
                            @endforeach
                        </select>

                        @error('members.0.user_id')
                        <p class="validate_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="button" id="add-member-btn"
                class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                Add Another Member
            </button>
        </div>

        <div class="grid grid-cols-1 gap-x-6 gap-y-4">
            <!-- Proposed Title -->
            <div>
                <label for="proposed_title" class="input_label">Proposed Title</label>
                <input type="text" id="proposed_title" name="proposed_title" class="input"
                    placeholder="Enter proposed project/thesis title" value="{{ old('proposed_title') }}">
                @error('proposed_title')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Problem Statement -->
            <div>
                <label for="problem_statement" class="input_label">Problem Statement</label>
                <textarea id="problem_statement" name="problem_statement" class="input h-32 resize-y"
                    placeholder="Describe the problem your project addresses">{{ old('problem_statement') }}</textarea>
                @error('problem_statement')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Motivation of the Work -->
            <div>
                <label for="motivation" class="input_label">Motivation of the Work</label>
                <textarea id="motivation" name="motivation" class="input h-32 resize-y"
                    placeholder="Explain why this work is important and what inspired it">{{ old('motivation') }}</textarea>
                @error('motivation')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mt-4">
            <!-- Intended Research Cell to Join -->
            <div>
                <label for="rcell_id" class="input_label">Intended Research Cell to Join</label>
                <div class="relative">
                    <select id="rcell_id" name="rcell_id" class="input select2">
                        <option value="">Select Research Cell</option>
                        @foreach ($rcells as $rcell)
                        <option value="{{ $rcell->id }}" @selected(old('rcell_id')==$rcell->id)>
                            {{ $rcell->name . ' (' . ($rcell->researchCellHead->name ?? 'N/A') . ')' }}
                        @endforeach
                    </select>
                    @error('rcell_id') {{-- Corrected: matches name attribute --}}
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Assigned Supervisor -->
            <div>
                <label for="supervisor_id" class="input_label">Assigned Supervisor</label>
                <div class="relative">
                    <select id="supervisor_id" name="supervisor_id" class="input select2">
                        <option value="">Select Supervisor</option>
                        @foreach ($faculty_members as $faculty)
                        <option value="{{ $faculty->id }}" @selected(old('supervisor_id')==$faculty->id)>{{
                            $faculty->name }}</option>
                        @endforeach
                    </select>
                    @error('supervisor_id')
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Assigned Co-Supervisor -->
            {{-- <div>
                <label for="cosupervisor_id" class="input_label">Assigned Co-Supervisor (optional)</label>
                <div class="relative">
                    <select id="cosupervisor_id" name="cosupervisor_id" class="input select2">
                        <option value="">Select Co-Supervisor</option>
                        @foreach ($faculty_members as $faculty)
                        <option value="{{ $faculty->id }}" @selected(old('cosupervisor_id')==$faculty->id)>{{
                            $faculty->name }}</option>
                        @endforeach
                    </select>
                    @error('cosupervisor_id')
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
                </div>
            </div> --}}
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-center mt-6">
            <button type="submit"
                class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-opacity-50 transition duration-200 w-full">
                Submit Proposal
            </button>
        </div>
    </form>
</div>

<script>
    const allStudents = @json($students->keyBy('id'));
    const oldMembers = @json(old('members', []));

    document.addEventListener('DOMContentLoaded', function() {
        let memberCount = 1;
        const groupMembersContainer = document.getElementById('group-members-container');
        const addMemberBtn = document.getElementById('add-member-btn');

        // Function to attach event listeners to member select dropdowns
        function attachMemberSelectListeners() {
            document.querySelectorAll('.member-select').forEach(selectElement => {
                selectElement.removeEventListener('change', handleMemberSelectChange);
                selectElement.addEventListener('change', handleMemberSelectChange);
            });
        }

        // The handler for the member select change event is now empty as there is no student ID field
        function handleMemberSelectChange(event) {
            // No action needed
        }

        function attachRemoveListeners() {
            document.querySelectorAll('.remove-member-btn').forEach(button => {
                button.onclick = function() {
                    if (groupMembersContainer.children.length > 1) {
                        this.closest('.group-member-item').remove();
                        updateMemberTitles();
                    } else {
                        // Using console.log instead of alert()
                        console.log("At least one group member is required.");
                    }
                };
            });
        }

        function updateMemberTitles() {
            const memberItems = groupMembersContainer.querySelectorAll('.group-member-item');
            memberItems.forEach((item, index) => {
                const titleElement = item.querySelector('h4');
                if (titleElement) {
                    titleElement.textContent = `Member ${index + 1}`;
                }
                item.querySelectorAll('input, select').forEach(input => {
                    const nameAttr = input.getAttribute('name');
                    if (nameAttr && nameAttr.startsWith('members[')) {
                        const fieldName = nameAttr.split('][')[1].replace(']', '');
                        input.setAttribute('name', `members[${index}][${fieldName}]`);
                        input.setAttribute('id', `member_${fieldName}_${index}`);
                    }
                });
            });
        }

        function addMemberWithOldData(member, index) {
            const newMemberHtml = `
                <div class="group-member-item mb-4 p-3 border border-gray-300 rounded-lg bg-white relative">
                    <button type="button" class="remove-member-btn absolute top-2 right-2 text-red-500 hover:text-red-700 text-xl font-bold leading-none">&times;</button>
                    <h4 class="font-medium text-gray-800 mb-3">Member ${index + 1}</h4>
                    <label for="member_user_id_${index}" class="input_label">Member Name</label>
                    <div class="relative">
                        <select id="member_user_id_${index}" name="members[${index}][user_id]" class="input member-select select2">
                            <option value="">Select Member</option>
                            ${Object.values(allStudents).map(student =>
                                `<option value="${student.id}" ${student.id == member.user_id ? 'selected' : ''}>${student.name} (${student.student_id})</option>`
                            ).join('')}
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 6.757 7.586 5.343 9z" />
                            </svg>
                        </div>
                    </div>
                </div>
            `;
            groupMembersContainer.insertAdjacentHTML('beforeend', newMemberHtml);
            // Re-initialize Select2 for the new element
            $(`#member_user_id_${index}`).select2({
                width: '100%'
            });
            attachRemoveListeners();
            attachMemberSelectListeners();
            memberCount++;
        }

        // Render old members (if > 1)
        if (oldMembers.length > 1) {
            for (let i = 1; i < oldMembers.length; i++) {
                addMemberWithOldData(oldMembers[i], i);
            }
            memberCount = oldMembers.length;
        }

        addMemberBtn.addEventListener('click', function() {
            addMemberWithOldData({}, memberCount);
        });

        // Initial listeners for first (default) member
        attachRemoveListeners();
        attachMemberSelectListeners();

        // Initialize Select2 for all existing select elements
        $('.select2').select2({
            width: '100%'
        });

        const rcellSelect = document.getElementById('rcell_id');
        const supervisorSelect = document.getElementById('supervisor_id');
        const oldSupervisorId = '{{ old('supervisor_id') }}';

        rcellSelect.addEventListener('change', function() {
            const rcellId = this.value;
            supervisorSelect.innerHTML = '<option value="">Loading...</option>'; // Clear existing options

            if (rcellId) {
                fetch(`/api/rcells/${rcellId}/supervisors`)
                    .then(response => response.json())
                    .then(supervisors => {
                        supervisorSelect.innerHTML = '<option value="">Select Supervisor</option>';
                        supervisors.forEach(supervisor => {
                            const option = document.createElement('option');
                            option.value = supervisor.id;
                            option.textContent = supervisor.name;
                            if (supervisor.id == oldSupervisorId) {
                                option.selected = true;
                            }
                            supervisorSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching supervisors:', error);
                        supervisorSelect.innerHTML = '<option value="">Could not load supervisors</option>';
                    });
            } else {
                supervisorSelect.innerHTML = '<option value="">Select Research Cell First</option>';
            }
        });

        // Trigger change event if a research cell was already selected (e.g., due to validation failure)
        if (rcellSelect.value) {
            rcellSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection
