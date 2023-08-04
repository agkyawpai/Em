<?php

namespace App\Http\Controllers;

use App\DBTransactions\Assign\SaveAssign;
use App\Http\Requests\AssignSaveRequest;
use App\Interfaces\EmployeeInterface;

/**
 * assign controller
 *
 * @author AungKyawPaing
 * @create  28/06/2023
 */
class AssignController extends Controller
{
    protected $employeeInterface;
    public function __construct(EmployeeInterface $employeeInterface)
    {
        $this->employeeInterface = $employeeInterface; //EmployeeInterface is used
    }
     /**
     * Saving assign of an employee
     * @author AungKyawPaing
     * @create 28/06/2023
     * @param  AssignSaveRequest  $request
     * @return \Illuminate\View\View\Illuminate\Http\RedirectResponse
     */
    public function store(AssignSaveRequest $request)
    {
        $id = (int)$request['employee_id'];
        $employee =  $this->employeeInterface->getEmployeeById($id);
        if (!$employee) {    //check if employee exists or not
            return redirect()->route('employees.assign-form')->with('error_assign', 'Employee not found');
        }
        $save = new SaveAssign($request);
        $save = $save->executeProcess();
        if ($save) {
            return redirect()->route('employees.assign-form')
                ->with('success', 'Assign added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to add Assign.');
        }
    }
}
