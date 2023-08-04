<?php

namespace App\DBTransactions\Employee;

use App\Classes\DBTransaction;
use App\Models\Documentation;
use App\Models\Employee;
use App\Models\EmployeeProgrammingLanguage;
use App\Models\EmployeeProject;
use Illuminate\Support\Facades\File;

/**
 * Class DeleteEmployee
 * To delete employee in employees table and employee_programming-languages pivot table
 *
 * @author  AungKyawPaing
 * @create 26/06/2023
 */
class DeleteEmployee extends DBTransaction
{
    private $employee;
    private $documentations;

    /**
     * DeleteEmployee constructor.
     * @author AungKyawPaing
     * @create 26/06/2023
     * @param $employeeId
     */
    public function __construct($employee, $documentations)
    {
        $this->employee = $employee;
        $this->documentations = $documentations;
    }

    /**
     * Process the employee delete.
     * @author AungKyawPaing
     * @create 26/06/2023
     * @return array
     */
    public function process()
    {
        try {
            $employee = $this->employee;
            $documentations = $this->documentations;
            $employeeId = $employee->id;
            // soft delete the employee
            Employee::findOrFail($employeeId)->delete();
            //delete employee's photo
            $filePath = public_path('employee_photo/' . $employee->image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            // soft delete the employee's programming languages
            EmployeeProgrammingLanguage::where('employee_id', $employeeId)->delete();

            // soft delete the employee's employee_projects
            EmployeeProject::where('employee_id', $employeeId)->delete();

            foreach ($documentations as $documentation) {
                $docPath = $documentation->filepath;
                //delete doc
                if (File::exists($docPath)) {
                    File::delete($docPath);
                }
            }
            return ['status' => true, 'error' => ''];
        } catch (\Exception $e) {
            return ['status' => false, 'error' => 'Something went wrong during employee deletion.'];
        }
    }
}
