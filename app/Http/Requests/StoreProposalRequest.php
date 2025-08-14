<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProposalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Set to true if you want to authorize all users to submit proposals.
        // You might add logic here to check if the authenticated user has the 'student' role.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'academic_year' => ['required', 'integer', 'min:' . (date('Y') - 5), 'max:' . (date('Y') + 1)],
            'semester' => ['required', Rule::in(['Fall', 'Summer', 'Spring'])],
            'course_type' => ['required', Rule::in(['Project', 'Thesis'])],
            'course_title' => ['required', 'string', 'max:255'],
            'course_code' => ['required', 'string', 'max:50'],
            'proposed_title' => ['required', 'string', 'max:255'],
            'problem_statement' => ['required', 'string'],
            'motivation' => ['required', 'string'],
            'rcell_id' => ['required', 'exists:r_cells,id'], // Ensure r_cells table exists
            'supervisor_id' => ['required', 'exists:users,id', Rule::exists('users', 'id')->where(function ($query) {
                $query->where('role', 'supervisor');
            })],
            'cosupervisor_id' => ['nullable', 'exists:users,id', Rule::exists('users', 'id')->where(function ($query) {
                $query->where('role', 'co-supervisor');
            })],

            // Validation for dynamic group members
            'members' => ['required', 'array', 'min:1'], // At least one member is required
            'members.*.user_id' => [
                'required',
                'distinct', // Ensures each selected user is unique within the group
                'exists:users,id',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'student'); // Ensure selected user is a student
                }),
            ],
            'members.*.student_id' => ['required', 'string', 'max:50'],
       
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'department_id.required' => 'The department field is required.',
            'department_id.exists' => 'The selected department is invalid.',
            'academic_year.required' => 'The academic year field is required.',
            'academic_year.integer' => 'The academic year must be a number.',
            'academic_year.min' => 'The academic year must be at least :min.',
            'academic_year.max' => 'The academic year cannot be greater than :max.',
            'semester.required' => 'The semester field is required.',
            'semester.in' => 'The selected semester is invalid.',
            'course_type.required' => 'The course type field is required.',
            'course_type.in' => 'The selected course type is invalid.',
            'course_title.required' => 'The course title field is required.',
            'course_code.required' => 'The course code field is required.',
            'proposed_title.required' => 'The proposed title field is required.',
            'problem_statement.required' => 'The problem statement field is required.',
            'motivation.required' => 'The motivation field is required.',
            'rcell_id.required' => 'The research cell field is required.',
            'rcell_id.exists' => 'The selected research cell is invalid.',
            'supervisor_id.required' => 'The assigned supervisor field is required.',
            'supervisor_id.exists' => 'The selected supervisor is invalid.',
            'cosupervisor_id.exists' => 'The selected co-supervisor is invalid.',

            'members.required' => 'At least one group member is required.',
            'members.array' => 'Group members data must be an array.',
            'members.min' => 'At least one group member is required.',
            'members.*.user_id.required' => 'Member name is required for all group members.',
            'members.*.user_id.distinct' => 'Each group member must be unique.',
            'members.*.user_id.exists' => 'Selected member is invalid.',
            'members.*.student_id.required' => 'Student ID is required for all group members.',
           
        ];
    }
}
