<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * To validate Employee data from Register Form.
 *
 * @author AungKyawPaing
 * @create  21/06/2023
 */
class EmployeeRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @author AungKyawPaing
     * @create 22/06/2023
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @author AungKyawPaing
     * @create 22/06/2023
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpeg,png|max:2048',
            'name' => [
                'required',
                'regex:/^[a-zA-Z\s]+$/',
                'max:50',
                Rule::unique('employees', 'name')->whereNull('deleted_at')
            ],
            'nrc' => [
                'required',
                Rule::unique('employees', 'nrc')->whereNull('deleted_at'),
                'regex:/^\d{1,2}\/[a-zA-Z]{4,8}\([A-Z]\)\d{6}$/',
            ],
            'phone' => [
                'required',
                'numeric',
                'digits:11',
                'regex:/^0\d{10}$/',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->whereNull('deleted_at'),
            ],
            'gender' => 'required',
            'dob' => 'required|date|before_or_equal:' . now()->subYears(18),    //validate if employee's age is over 18.
            'address' => 'required|max:255',
            'language' => 'required',
            'programming_language' => 'required',
            'career_path' => 'required',
            'level' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'The image field is required.',
            'image.mimes' => 'The image must be a JPG or PNG file.',
            'name.required' => 'The name field is required.',
            'name.regex' => 'The name field may only contain letters and spaces.',
            'name.unique' => 'That name already exists in our system.',
            'nrc.required' => 'The NRC field is required.',
            'nrc.regex' => 'The NRC format is invalid.',
            'nrc.unique' => 'This NRC is already registered.',
            'phone.required' => 'Phone Number field is required.',
            'phone.integer' => 'Phone Number field must be an integer.',
            'phone.digits' => 'Phone Number must be 11 nmbers',
            'phone.regex' => 'Invalid Phone Number Format.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email is already taken.',
            'dob.required' => 'The date of birth field is required.',
            'dob.before_or_equal' => 'You must be 18 years old or above.',
            'address.required' => 'The address field is required.',
            'address.max' => 'The address must not exceed 255 characters.',
            'language.required' => 'At least one language must be selected.',
            'programming_language.required' => 'At least one programming language must be selected.',
            'career_path.required' => 'The career path field is required.',
            'level.required' => 'The level field is required.',
        ];
    }
}
