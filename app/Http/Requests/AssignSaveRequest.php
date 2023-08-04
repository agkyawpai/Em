<?php

namespace App\Http\Requests;

use App\Logics\AssignDateCheckLogic;
use App\Models\EmployeeProject;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AssignSaveRequest
 * To validate inputs from assign form.
 * @author AungKyawPaing
 * @create  28/06/2023
 */
class AssignSaveRequest extends FormRequest
{
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
            'employee_id' => 'required',
            'project_name' => 'required',
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $employeeId = $this->input('employee_id');
                    $endDate = $this->input('end_date');
                    if (!AssignDateCheckLogic::passesEmployeeProjectCheck($employeeId, $value, $endDate)) {
                        $fail('This employee is already assigned to another project during this duration.');
                    }
                },
            ],
            'end_date' => 'required|date|after_or_equal:start_date',
            'documentation' => 'required|array',
            'documentation.*' =>'required|file|max:500',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Please select an employee.',
            'project_name.required' => 'Please select a project.',
            'start_date.required' => 'Please enter the start date.',
            'start_date.date' => 'Please enter a valid start date.',
            'start_date.after_or_equal' => 'Start date must be greater than or equal today.',
            'end_date.after_or_equal' => 'End date must be greater than or equal start date.',
            'end_date.required' => 'Please enter the end date.',
            'documentation.*.required' => 'Please choose the documentation file.',
        ];
    }
}
