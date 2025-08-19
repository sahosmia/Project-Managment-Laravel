<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',

        ];
    }

}
