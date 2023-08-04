<?php

namespace App\DBTransactions\Employee;

use App\Classes\DBTransaction;
use App\Models\Employee;
use App\Models\EmployeeProgrammingLanguage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Class SaveEmployee
 * To save employee in employees table
 *
 * @author  AungKyawPaing
 * @create 21/06/2023
**/
class SaveEmployee extends DBTransaction
{
    private $request;

    /**
     * SaveEmployee constructor.
     * @author AungKyawPaing
     * @create 21/06/2023
     * @param $request
    */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Process the employee saving.
     * @author AungKyawPaing
     * @create 21/06/2023
     * @return array
    */
    public function process()
    {
        $admin = session()->get('adminId');
        $request = $this->request;
        $imageFile = $request['image'];
        $filename = uniqid() . $imageFile->getClientOriginalName();
        $imageFile->move('employee_photo', $filename);    //store in Spublic/employee_photo
        // begin db transaction
        DB::beginTransaction();

        try {
            $employee = new Employee;
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
            $employee->image = $filename;
            $employee->created_at = Carbon::now();
            $employee->updated_at = Carbon::now();
            $employee->created_by = $admin;
            $employee->updated_by = $admin;
            $employee->save();

            // To save employee's programming languages in employee_programming_languages pivot table.
            $programming_languages_arr = $request['programming_language'];
            foreach ($programming_languages_arr as $programming_language) { //to save employee's programming languages by row
                $programming_languages = new EmployeeProgrammingLanguage();
                $programming_languages->programming_language_id = $programming_language;
                $programming_languages->employee_id = $employee->id;
                $programming_languages->created_at = Carbon::now();
                $programming_languages->updated_at = Carbon::now();
                $programming_languages->created_by = $admin;
                $programming_languages->updated_by = $admin;
                $programming_languages->save();
            }

            DB::commit();
            return ['status' => true, 'error' => ''];
        } catch (\Exception $e) {
            // rollback the transaction
            DB::rollback();

            // delete the saved employee photo if any error occurred
            $filePath = public_path('employee_photo') . '/' . $filename;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            return ['status' => false, 'error' => 'Failed to save the employee.'];
        }
    }
}
