<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * To validate Employee data from Edit Form.
 *
 * @author AungKyawPaing
 * @create  23/06/2023
 */
class EmployeeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @author AungKyawPaing
     * @create 23/06/2023
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @author AungKyawPaing
     * @create 23/06/2023
     * @return array
     */
    public function rules()
    {
        $employeeId = $this->route('id'); //get employee id from rote parameter to check email
        return [
            'name' => [
                'required',
                'regex:/^[a-zA-Z\s]+$/',
                'max:50',
                Rule::unique('employees', 'name')->ignore($employeeId)->whereNull('deleted_at')
            ],
            'phone' => [
                'required',
                'numeric',
                'digits:11',
                'regex:/^0\d{10}$/',
            ],
            'nrc' => [
                'required',
                'regex:/^\d{1,2}\/[a-zA-Z]{4,8}\([A-Z]\)\d{6}$/',
                Rule::unique('employees', 'nrc')
                    ->ignore($employeeId)
                    ->whereNull('deleted_at') // to let employee to change nrc, but checks others nrc in db table excepts old nrc.
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')
                    ->ignore($employeeId)
                    ->whereNull('deleted_at') // to let employee to change email, but checks others email in db table excepts old email.
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
            'name.required' => 'The name field is required.',
            'name.regex' => 'The name field may only contain letters and spaces.',
            'name.unique' => 'That name already exists in our system.',
            'phone.required' => 'Phone Number field is required.',
            'phone.integer' => 'Phone Number field must be an integer.',
            'phone.digits' => 'Phone Number must be 11 numbers',
            'phone.regex' => 'Invalid Phone Number Format.',
            'nrc.required' => 'The NRC field is required.',
            'nrc.regex' => 'The NRC format is invalid.',
            'nrc.unique' => 'This NRC is already registered.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'dob.required' => 'The date of birth field is required.',
            'dob.before_or_equal' => 'The date of birth must be older than 18 years.',
            'address.required' => 'The address field is required.',
            'address.max' => 'The address must not exceed 255 characters.',
            'language.required' => 'At least one language must be selected.',
            'programming_language.required' => 'At least one programming language must be selected.',
            'career_path.required' => 'The career path field is required.',
            'level.required' => 'The level field is required.',
        ];
    }
}
