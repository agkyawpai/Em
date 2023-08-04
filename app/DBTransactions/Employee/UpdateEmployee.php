<?php

namespace App\DBTransactions\Employee;

use App\Classes\DBTransaction;
use App\Models\Employee;
use App\Models\EmployeeProgrammingLanguage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Class UpdateEmployee
 * To update employee in employees table
 *
 * @author  AungKyawPaing
 * @create 23/06/2023
 */
class UpdateEmployee extends DBTransaction
{
    private $request;
    private $employeeId;

    /**
     * UpdateEmployee constructor.
     * @author AungKyawPaing
     * @create 23/06/2023
     * @param $request
     * @param $employeeId
     */
    public function __construct($request, $employeeId)
    {
        $this->request = $request;
        $this->employeeId = $employeeId;
    }

    /**
     * Process the employee updating.
     * @author AungKyawPaing
     * @create 23/06/2023
     * @return array
     */
    public function process()
    {
        $admin = session()->get('adminId');
        $request = $this->request;
        $employeeId = $this->employeeId;
        // dd($request);
        $employee = Employee::find($employeeId);
        if (!$employee) {
            return ['status' => false, 'error' => 'Employee not found'];
        }

        $employee->employee_id = $request['employee_id'];
        $employee->name = trim($request['name']);
        $employee->nrc = $request['nrc'];
        $employee->phone = trim($request['phone']);
        $employee->email = trim($request['email']);
        $employee->gender = $request['gender'];
        $employee->date_of_birth = $request['dob'];
        $employee->address = trim($request['address']);
        $employee->language = implode(',', $request['language']);
        $employee->career_path = $request['career_path'];
        $employee->level = $request['level'];
        $employee->updated_at = Carbon::now();
        $employee->updated_by = $admin;
        // check if image is present in the request
        if (isset($request['image'])) {
            $oldPhoto = $employee->image;
            $filePath = public_path('employee_photo/' . $oldPhoto);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $imageFile = $request['image'];
            $filename = uniqid() . $imageFile->getClientOriginalName();
            $imageFile->move('employee_photo', $filename);    //store in storage/public/employee_photo
            $employee->image = $filename;
        }
        // Update the employee record in the database
        $employee->save();

        // To update employee's programming languages in employee_programming_languages pivot table.
        $programmingLanguagesArr = $request['programming_language'];
        $employeeProgrammingLanguages = EmployeeProgrammingLanguage::where('employee_id', $employeeId)->get();
        $existingProgrammingLanguages = $employeeProgrammingLanguages->pluck('programming_language_id')->toArray();

        // Remove programming languages if they are unchecked by the employee
        $languagesToRemove = array_diff($existingProgrammingLanguages, $programmingLanguagesArr);
        EmployeeProgrammingLanguage::where('employee_id', $employeeId)->whereIn('programming_language_id', $languagesToRemove)->delete();

        // Add new programming languages
        $languagesToAdd = array_diff($programmingLanguagesArr, $existingProgrammingLanguages);
        foreach ($languagesToAdd as $programmingLanguage) {
            $employeeProgrammingLanguage = new EmployeeProgrammingLanguage();
            $employeeProgrammingLanguage->programming_language_id = $programmingLanguage;
            $employeeProgrammingLanguage->employee_id = $employeeId;
            $employeeProgrammingLanguage->updated_at = Carbon::now();
            $employeeProgrammingLanguage->updated_by = $admin;
            $employeeProgrammingLanguage->save();
        }

        // Check if the employee was saved successfully
        if (!$employee && $employeeProgrammingLanguage) {
            return ['status' => false, 'error' => 'Failed'];
        }
        return ['status' => true, 'error' => ''];
    }
}
