@extends('layouts.admin')
@section('title')
{{ auth()->user()->role === 'admin' ? 'Update Project & Thesis Proposal' : 'Edit & Resubmit Project & Thesis Proposal'
}}
@endsection
@section('content')

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-6xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
        {{ auth()->user()->role === 'admin' ? 'Update Project & Thesis Proposal' : 'Edit & Resubmit Project & Thesis
        Proposal' }}
    </h2>
    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            <!-- Department -->
            <div>
                <label for="department_id" class="input_label">Department</label>
                <div class="relative">
                    <select id="department_id" name="department_id" class="input select2">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected(old('department_id', $project->
                            department_id)==$department->id)>{{
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
                        $selected = old('academic_year', $project->academic_year) == $i ? 'selected' : '';
                        echo "<option value='{$i}' {$selected}>{$i}</option>";
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
                        <option @selected(old('semester', $project->semester) == 'fall') value="Fall">Fall</option>
                        <option @selected(old('semester', $project->semester) == 'summer') value="Summer">Summer
                        </option>
                        <option @selected(old('semester', $project->semester) == 'spring') value="Spring">Spring
                        </option>
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
                        <option @selected(old('course_type', $project->course_type) == 'project')
                            value="Project">Project</option>
                        <option @selected(old('course_type', $project->course_type) == 'thesis') value="Thesis">Thesis
                        </option>
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
                    value="{{ old('course_title', $project->course_title) }}" readonly>
                @error('course_title')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Course Code -->
            <div>
                <label for="course_code" class="input_label">Course Code</label>
                <input type="text" id="course_code" name="course_code" class="input" placeholder="Enter course code"
                    value="{{ old('course_code', $project->course_code) }}">
                @error('course_code')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Group Member's Information -->
        <div class="mb-6 mt-6 border border-gray-200 rounded-lg p-4 bg-gray-50">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Group Member's Information</h3>
            @php
            $current_members = old('members', $project->members->map(function($m) { return ['user_id' => $m->id]; }));
            @endphp
            <div id="group-members-container">
                @forelse ($current_members as $key => $member)
                <div class="group-member-item mb-4 p-3 border border-gray-300 rounded-lg bg-white relative">
                    <h4 class="font-medium text-gray-800 mb-3">Member {{ $loop->iteration }}</h4>
                    <label for="member_user_id_{{ $key }}" class="input_label">Member Name</label>
                    <div class="relative">
                        <select id="member_user_id_{{ $key }}" name="members[{{ $key }}][user_id]"
                            class="input member-select select2">
                            <option value="">Select Member</option>
                            @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected($member['user_id']==$student->id)>
                                {{ $student->name }} ({{$student->student_id}})
                            </option>
                            @endforeach
                        </select>
                        @error('members.'.$key.'.user_id')
                        <p class="validate_error">{{ $message }}</p>
                        @enderror
                    </div>
                    @if ($loop->index > 0)
                    <button type="button"
                        class="remove-member-btn absolute top-2 right-2 text-red-500 hover:text-red-700 text-xl font-bold leading-none">&times;</button>
                    @endif
                </div>
                @empty
                <!-- Initial member fields if none are present -->
                <div class="group-member-item mb-4 p-3 border border-gray-300 rounded-lg bg-white relative">
                    <h4 class="font-medium text-gray-800 mb-3">Member 1</h4>
                    <label for="member_user_id_0" class="input_label">Member Name</label>
                    <div class="relative">
                        <select id="member_user_id_0" name="members[0][user_id]" class="input member-select select2">
                            <option value="">Select Member</option>
                            @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(old('members.0.user_id')==$student->id)>
                                {{ $student->name }} ({{$student->student_id}})
                            </option>
                            @endforeach
                        </select>
                        @error('members.0.user_id')
                        <p class="validate_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @endforelse
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
                    placeholder="Enter proposed project/thesis title"
                    value="{{ old('proposed_title', $project->title) }}">
                @error('proposed_title')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Problem Statement -->
            <div>
                <label for="problem_statement" class="input_label">Problem Statement</label>
                <textarea id="problem_statement" name="problem_statement" class="input h-32 resize-y"
                    placeholder="Describe the problem your project addresses">{{ old('problem_statement', $project->problem_statement) }}</textarea>
                @error('problem_statement')
                <p class="validate_error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Motivation of the Work -->
            <div>
                <label for="motivation" class="input_label">Motivation of the Work</label>
                <textarea id="motivation" name="motivation" class="input h-32 resize-y"
                    placeholder="Explain why this work is important and what inspired it">{{ old('motivation', $project->motivation) }}</textarea>
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
                        <option value="{{ $rcell->id }}" @selected(old('rcell_id', $project->r_cell_id) == $rcell->id)>
                            {{ $rcell->name . ' (' . ($rcell->researchCellHead->name ?? 'N/A') . ')' }}
                        </option>
                        @endforeach
                    </select>
                    @error('rcell_id')
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
                        <option value="{{ $faculty->id }}" @selected(old('supervisor_id', $project->supervisor_id) ==
                            $faculty->id)>{{
                            $faculty->name }}</option>
                        @endforeach
                    </select>
                    @error('supervisor_id')
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Assigned Co-Supervisor -->
            <div>
                <label for="cosupervisor_id" class="input_label">Assigned Co-Supervisor (optional)</label>
                <div class="relative">
                    <select id="cosupervisor_id" name="cosupervisor_id" class="input select2">
                        <option value="">Select Co-Supervisor</option>
                        @foreach ($faculty_members as $faculty)
                        <option value="{{ $faculty->id }}" @selected(old('cosupervisor_id', $project->
                            cosupervisor_id) == $faculty->id)>{{
                            $faculty->name }}</option>
                        @endforeach
                    </select>
                    @error('cosupervisor_id')
                    <p class="validate_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-center mt-6">
            <button type="submit"
                class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-opacity-50 transition duration-200 w-full">
                {{ auth()->user()->role === 'admin' ? 'Update Proposal' : 'Edit & Resubmit Proposal' }} </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const groupMembersContainer = document.getElementById('group-members-container');
        const addMemberBtn = document.getElementById('add-member-btn');
        const allStudents = @json($students);
        let memberCount = {{ count($current_members) }};

        function createMemberOption(student, selected_id = null) {
            const option = document.createElement('option');
            option.value = student.id;
            option.textContent = `${student.name} (${student.student_id})`;
            if (student.id === selected_id) {
                option.selected = true;
            }
            return option;
        }

        function createMemberSelect(index, selected_id = null) {
            const select = document.createElement('select');
            select.id = `member_user_id_${index}`;
            select.name = `members[${index}][user_id]`;
            select.className = 'input member-select select2';
            select.innerHTML = '<option value="">Select Member</option>';
            allStudents.forEach(student => {
                select.appendChild(createMemberOption(student, selected_id));
            });
            return select;
        }

        function addNewMember(selected_id = null) {
            const index = memberCount++;
            const newItem = document.createElement('div');
            newItem.className = 'group-member-item mb-4 p-3 border border-gray-300 rounded-lg bg-white relative';

            const title = document.createElement('h4');
            title.className = 'font-medium text-gray-800 mb-3';
            title.textContent = `Member ${index + 1}`;

            const label = document.createElement('label');
            label.className = 'input_label';
            label.setAttribute('for', `member_user_id_${index}`);
            label.textContent = 'Member Name';

            const selectDiv = document.createElement('div');
            selectDiv.className = 'relative';
            const select = createMemberSelect(index, selected_id);
            selectDiv.appendChild(select);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-member-btn absolute top-2 right-2 text-red-500 hover:text-red-700 text-xl font-bold leading-none';
            removeBtn.innerHTML = '&times;';

            newItem.appendChild(title);
            newItem.appendChild(label);
            newItem.appendChild(selectDiv);
            newItem.appendChild(removeBtn);

            groupMembersContainer.appendChild(newItem);

            // Initialize select2
            $(select).select2({ width: '100%' });
        }

        addMemberBtn.addEventListener('click', function() {
            addNewMember();
        });

        groupMembersContainer.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-member-btn')) {
                if (groupMembersContainer.querySelectorAll('.group-member-item').length > 1) {
                    e.target.closest('.group-member-item').remove();
                    // Update titles and indices
                    groupMembersContainer.querySelectorAll('.group-member-item').forEach((item, index) => {
                        item.querySelector('h4').textContent = `Member ${index + 1}`;
                        const select = item.querySelector('select');
                        select.name = `members[${index}][user_id]`;
                        select.id = `member_user_id_${index}`;
                        item.querySelector('label').setAttribute('for', `member_user_id_${index}`);
                    });
                    memberCount--;
                } else {
                    console.log("At least one group member is required.");
                }
            }
        });

        // Initialize select2 for all existing select elements
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@endsection
