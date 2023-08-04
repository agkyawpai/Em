<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ProjectSaveRequest
 * To validate project saving process
 * @author AungKyawPaing
 * @create  28/06/2023
 */
class ProjectSaveRequest extends FormRequest
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
     * @author AungKyawPaing
     * @create 28/06/2023
     * @return array
     */
    public function rules()
    {
        return [
            'project_name_modal' => [
                'required',
                'max:50',
                Rule::unique('projects', 'name')
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'project_name_modal.required' => 'Project Name is required.',
            'project_name_modal.max' => 'You can only type 50 characters.',
            'project_name_modal.unique' => 'Project Name already exists.'
        ];
    }
}
