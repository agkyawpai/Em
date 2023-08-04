<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class LoginRequest
 * To validate employee_id and password from login form.
 * @author AungKyawPaing
 * @create  21/06/2023
 */
class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => ['required', 'numeric', Rule::in(['1', '2'])],
            'password' => ['required', Rule::in(['admin1', 'admin2'])],
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.in' => 'Wrong Login Information.',
            'employee_id.required' => 'Wrong Login Information.',
            'password.required' => 'Wrong Login Information.',
            'employee_id.numeric' => 'Wrong Login Information.',
            'password.in' => 'Wrong Login Information.'
        ];
    }
}
