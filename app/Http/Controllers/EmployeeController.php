<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\EmployeeInterface;
use Illuminate\Support\Facades\Session;
use App\DBTransactions\Employee\SaveEmployee;
use App\DBTransactions\Employee\UpdateEmployee;
use App\DBTransactions\Employee\DeleteEmployee;
use App\Http\Requests\EmployeeRegisterRequest;
use App\Exports\EmployeeExport;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Interfaces\DocumentationInterface;
use App\Interfaces\EmployeeProgrammingLanguagesInterface;
use App\Interfaces\ProjectInterface;
use App\Logics\PdfGenerator;
use App\Models\Employee;
use Maatwebsite\Excel\Facades\Excel;

/**
 * employee controller
 *
 * @author AungKyawPaing
 * @create  21/06/2023
 */
class EmployeeController extends Controller
{
    protected $employeeInterface;
    protected $employeeProgrammingLanguagesInterface;
    protected $projectInterface;
    protected $documentationInterface;

    /**
     * Create a new controller instance.
     * @author Aung Kyaw Paing
     * @param  EmployeeInterface  $employeeInterface
     * @param EmployeeProgrammingLanguagesInterface $employeeProgrammingLangugaesInterface
     * @param  ProjectInterface  $projectInterface
     */
    public function __construct(EmployeeInterface $employeeInterface, EmployeeProgrammingLanguagesInterface $employeeProgrammingLanguagesInterface, ProjectInterface $projectInterface, DocumentationInterface $documentationInterface)
    {
        $this->employeeInterface = $employeeInterface; //EmployeeInterface is used
        $this->employeeProgrammingLanguagesInterface = $employeeProgrammingLanguagesInterface;  //EmployeeProgrammingLanguagesInterface is used
        $this->projectInterface = $projectInterface;  //ProjectInterface is used
        $this->documentationInterface = $documentationInterface;    //DocumentationInterface is used
    }

    /**
     * Display a listing of the employees.
     * @author AungKyawPaing
     * @create 21/06/2023
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // get the search data from the request
        $searchEmployeeId = $request->input('search');
        $searchCareerPath = $request->input('search_career_path');
        $searchLevel = $request->input('search_level');
        // Get the employees based on the search data or if there is no search data, get all data
        $employees = $this->employeeInterface->getAllEmployeeBySearch($searchEmployeeId, $searchCareerPath, $searchLevel);
        $active_employees = $this->employeeInterface->getAllActiveEmployee();
        $emp_not_paginated = $this->employeeInterface->getAllEmployeeNotPaginated();
        $currentPage = request()->query('page');
        //careerPaths and levels array to pass view form and reuse the actual name.
        $careerPaths = [
            1 => 'Front End',
            2 => 'Back End',
            3 => 'Full Stack',
            4 => 'Mobile',
        ];
        $levels = [
            1 => 'Beginner',
            2 => 'Junior Engineer',
            3 => 'Engineer',
            4 => 'Senior Engineer',
        ];
        return view('index', compact('employees', 'careerPaths', 'levels', 'active_employees', 'currentPage', 'emp_not_paginated'));
    }

    /**
     * Displays login form.
     * @author AungKyawPaing
     * @create 21/06/2023
     * @param
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Display the employee registration form.
     * @author AungKyawPaing
     * @create 21/06/2023
     * @param  Request  $request
     * @return array
     */
    public function register_form(Request $request)
    {
        $employee_id = $this->employeeInterface->getLastEmployee();
        return view('employee-register', compact('employee_id'));
    }

    /**
     * Register a new employee.
     * @author AungKyawPaing
     * @create 21/06/2023
     * @param  EmployeeRegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(EmployeeRegisterRequest $request)
    {
        $employee = $this->employeeInterface->checkExistingEmployee($request['employeeId']);
        if ($employee) {    //check if employee exists or not
            return redirect()->route('employees.index')->with('error_register', 'Employee already registered ');
        }
        $save = new SaveEmployee($request);
        $save = $save->executeProcess();
        if (!$save) {
            return redirect()->back();
        }
        Session::flash('success', 'Employee registered successfully.');
        return redirect()->back();
    }

    /**
     * This method allows the user to download the employee data in Excel format.
     * @author AungKyawPaing
     * @create 22/06/2023
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function exportExcel(Request $request)
    {
        // get the search data from the request
        $searchEmployeeId = $request->input('search');
        $searchCareerPath = $request->input('search_career_path');
        $searchLevel = $request->input('search_level');
        // Get the employees based on the search data or if there is no search data, get all data
        $employees = $this->employeeInterface->getAllEmployeeBySearch($searchEmployeeId, $searchCareerPath, $searchLevel);
        $emp_programming = $this->employeeProgrammingLanguagesInterface->getAllProgrammingLanguages();
        // define the Excel file name
        $fileName = uniqid() . 'employee_list.xlsx';

        // Download the Excel file using the EmployeeExport class
        return Excel::download(new EmployeeExport($employees, $emp_programming), $fileName);
    }

    /**
     * This method allows the user to download the employee data in PDF format.
     * @author AungKyawPaing
     * @create 22/06/2023
     * @param  Request  $request
     * @return void
     */
    public function downloadPDF(Request $request)
    {
        // get the search data from the request
        $searchEmployeeId = $request->input('search');
        $searchCareerPath = $request->input('search_career_path');
        $searchLevel = $request->input('search_level');
        // Get the employees based on the search data or if there is no search data, get all data
        $employees = $this->employeeInterface->getAllEmployeeBySearch($searchEmployeeId, $searchCareerPath, $searchLevel);
        $emp_programming = $this->employeeProgrammingLanguagesInterface->getAllProgrammingLanguages();
        // Generate the PDF using the PdfGenerator class
        PdfGenerator::generateEmployeeListPDF($employees, $emp_programming);
    }

    /**
     * Show the form for editing the specified employee.
     * @author AungKyawPaing
     * @create 23/06/2003
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // get the employee record
        $employee =  $this->employeeInterface->getEmployeeById($id);
        $currentPage = intval(request()->query('page', 1)); //get current page from url
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', 'Employee not found');
        }
        // Retriece programming languages of employee.
        $programmingLanguages = $this->employeeProgrammingLanguagesInterface->getProgrammingLanguageofEmployee($id);
        return view('update-form', compact('employee', 'programmingLanguages', 'currentPage'));
    }


    /**
     * Do update processs for the specified employee.
     * @author AungKyawPaing
     * @create 23/06/2023
     * @param  EmployeeUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EmployeeUpdateRequest $request, $id)
    {
        // get the employee record
        $employee =  $this->employeeInterface->getEmployeeById($id);
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', 'Employee not found');
        }
        $updateEmployee = new UpdateEmployee($request->all(), $employee->id);
        $result = $updateEmployee->executeProcess();

        // Check the result and return the response
        if ($result) {
            return redirect()->route('employees.index')->with('success_update', 'Employee updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update employee.');
        }
    }

    /**
     * Delete the specified employee by id.
     * @author AungKyawPaing
     * @create 26/06/2023
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $searchEmployeeId = request()->input('search');
        $searchCareerPath = request()->input('search_career_path');
        $searchLevel = request()->input('search_level');
        // get the employee record
        $employee =  $this->employeeInterface->getEmployeeById($id);
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', 'Employee not found');
        }
        $documentations = $this->documentationInterface->getDocumentations($id);    //get docs to delete
        $totalEmployees = $this->employeeInterface->getAllActiveEmployee(); // Get the total count of employees
        $perPage = 5;   // data per page
        $totalPages = ceil($totalEmployees / $perPage); //total pages calculate
        $currentPage = intval(request()->query('page', 1)); //get current page from url

        if ($currentPage > $totalPages) {   // if total page is greater than current page, assign total page as current page.
            $currentPage = $totalPages;
        }

        //delete process
        $delEmpandProgrammingLanguage = new DeleteEmployee($employee, $documentations);
        $result = $delEmpandProgrammingLanguage->executeProcess();

        if (!$result) {
            return redirect()->route('employees.index')->with('error_del', 'Error occur while deleting.');
        }
        $employeesInCurrentPage = $this->employeeInterface->getEmployees($currentPage, $perPage,  $searchEmployeeId, $searchCareerPath, $searchLevel);   //get count data of employees in current page
        // dd($employeesInCurrentPage);
        // check if there are employees in the current page with search queries
        if (($searchEmployeeId !== null || $searchCareerPath !== null || $searchLevel !== null)
            && $employeesInCurrentPage->isEmpty() && $currentPage > 1
        ) {
            $redirectPage = $currentPage - 1; // subtract 1 from current page if there are no employees and current page is greater than 1
            return redirect()->route('employees.index', [
                'page' => $redirectPage,
                'search' => $searchEmployeeId,
                'search_career_path' => $searchCareerPath,
                'search_level' => $searchLevel,
            ])->with('success_del', 'Employee deleted successfully');
        } elseif ($searchEmployeeId === null && $searchCareerPath === null && $searchLevel === null && $employeesInCurrentPage->isEmpty() && $currentPage > 1) {
            $redirectPage = $currentPage - 1; // substract 1 from current page if there are no search queries, no employees, and current page is greater than 1
            return redirect()->route('employees.index', [
                'page' => $redirectPage,
            ])->with('success_del', 'Employee deleted successfully');
        }
        $redirectPage = $currentPage;
        return redirect()->back()->with([
            'page' => $redirectPage,
            'success_del' => 'Employee deleted successfully',
            'search' => $searchEmployeeId,
            'search_career_path' => $searchCareerPath,
            'search_level' => $searchLevel,
        ]);
    }

    /**
     * Show Assign Form.
     * @author AungKyawPaing
     * @create 27/06/2023
     * @return \Illuminate\View\View
     */
    public function assign_form()
    {
        $employees = $this->employeeInterface->getAllEmployees();
        $projects = $this->projectInterface->getAllProjects();
        $projectsWithoutEmp = $this->projectInterface->getProjectWithNoEmp();
        return view('project-assignment', compact('employees', 'projects', 'projectsWithoutEmp'));
    }

    /**
     * Show Detail form of an employee
     * @author AungKyawPaing
     * @create 27/06/2023
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function detail($id)
    {
        $employee =  $this->employeeInterface->getEmployeeById($id);
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', 'Employee not found');
        }
        $currentPage = intval(request()->query('page', 1)); //get current page from url
        $programmingLanguages = $this->employeeProgrammingLanguagesInterface->getProgrammingLanguageofEmployee($id);
        $documentations = $this->documentationInterface->getDocumentations($id);
        $projects = $this->projectInterface->getProjectById($id);
        return view('employee-detail', compact('employee', 'programmingLanguages', 'documentations', 'projects', 'currentPage'));
    }
}
