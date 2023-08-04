<?php

namespace App\Http\Controllers;

use App\DBTransactions\Project\DeleteProject;
use App\DBTransactions\Project\SaveProject;
use App\Http\Requests\ProjectSaveRequest;
use App\Interfaces\EmployeeInterface;
use App\Interfaces\ProjectInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectInterface;
    protected $employeeInterface;

    /**
     * Create a new controller instance.
     * @author Aung Kyaw Paing
     * @create 28/06/2023
     * @param  ProjectInterface  $projectInterface
     */
    public function __construct(EmployeeInterface $employeeInterface, ProjectInterface $projectInterface)
    {
        $this->employeeInterface = $employeeInterface; //EmployeeInterface is used
        $this->projectInterface = $projectInterface;  //ProjectInterface is used
    }

    /**
     * to save projects process
     * @author AungKyawPaing
     * @create 28/06/2023
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function save_pj(ProjectSaveRequest $request)
    {
        $save = new SaveProject($request);
        $save = $save->executeProcess();
        if ($save) {
            return redirect()->route('employees.assign-form')
                ->with('success-pj', 'Projects added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to add project.');
        }
    }

     /**
     * Remove projects and checks other employees assigned to that project.
     * @author AungKyawPaing
     * @create 30/06/2023
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove_pj(Request $request)
    {
        $remove = new DeleteProject($request);
        $remove_pj = $remove->executeProcess();      //process dbtransaction
        $error_msg = $remove->process()['error'];   //get exception error message from process method of DeleteProject
        if ($remove_pj) {
            return redirect()->route('employees.assign-form')->with('success-pj-remove', 'Project has been successfully deleted.');
        } else {
            return redirect()->route('employees.assign-form')->with('error-pj-remove', $error_msg);
        }
    }
}
