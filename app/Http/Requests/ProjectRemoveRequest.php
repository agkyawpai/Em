<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ProjectRemoveRequest
 * To validate removing process of project
 * @author AungKyawPaing
 * @create  30/06/2023
 */
class ProjectRemoveRequest extends FormRequest
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
    @author AungKyawPaing
     * @create 30/06/2023
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'Project Name is required.',
        ];
    }
}
