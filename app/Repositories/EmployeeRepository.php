<?php

namespace App\Repositories;

use App\Interfaces\EmployeeInterface;
use App\Models\Employee;
use App\Models\EmployeeProgrammingLanguage;

/**
 * provides methods for getting employee data from the database.
 * Implements the EmployeeInterface interface.
 *
 * @author AungKyawPaing
 * @create  21/06/2023
 */
class EmployeeRepository implements EmployeeInterface
{

    /**
     * Get an employee by ID.
     * @author AungKyawPaing
     * @create 21/06/2023
     * @param  int  $id
     * @return Employee||null
     */
    public function getEmployeeById($id)
    {
        return Employee::find($id);
    }

    /**
     * Get the ID of the last employee.
     * @author AungKyawPaing
     * @create 21/06/2023
     * @return int
     */
    public function getLastEmployee()
    {
        $employees = Employee::withTrashed()->count();
        return $employees;
    }

    /**
     * Get all employees based on search criteria.
     * @author AungKyawPaing
     * @create 21/06/2023
     * @param  int|null  $searchEmployeeId
     * @param  int|null  $searchCareerPath
     * @param  int|null  $searchLevel
     * @return array
     */
    public function getAllEmployeeBySearch($searchEmployeeId = null, $searchCareerPath = null, $searchLevel = null)
    {
        $query = Employee::query();
        if (!empty($searchEmployeeId) && !empty($searchCareerPath) && !empty($searchLevel)) {
            $query->where('employee_id', 'like', '%' . $searchEmployeeId . '%')
                ->where('career_path', $searchCareerPath)
                ->where('level', $searchLevel);
        } elseif (!empty($searchEmployeeId) && !empty($searchCareerPath)) {
            $query->where('employee_id', 'like', '%' . $searchEmployeeId . '%')
                ->where('career_path', $searchCareerPath);
        } elseif (!empty($searchEmployeeId) && !empty($searchLevel)) {
            $query->where('employee_id', 'like', '%' . $searchEmployeeId . '%')
                ->where('level', $searchLevel);
        } elseif (!empty($searchCareerPath) && !empty($searchLevel)) {
            $query->where('career_path', $searchCareerPath)
                ->where('level', $searchLevel);
        } elseif (!empty($searchEmployeeId)) {
            $query->where('employee_id', 'like', '%' . $searchEmployeeId . '%');
        } elseif (!empty($searchCareerPath)) {
            $query->where('career_path', $searchCareerPath);
        } elseif (!empty($searchLevel)) {
            $query->where('level', $searchLevel);
        }
        return $query->orderBy('updated_at', 'desc')->paginate(5)->appends([
            'search' => $searchEmployeeId,
            'search_career_path' => $searchCareerPath,
            'search_level' => $searchLevel
        ]);
    }

    /**
     * Get count number of all employee that are active.
     * @author AungKyawPaing
     * @create 27/06/2023
     * @return int
     */
    public function getAllActiveEmployee()
    {
        $employees = Employee::count();
        return $employees;
    }

    /**
     * Get all employee that are active.
     * @author AungKyawPaing
     * @create 03/07/2023
     * @return int
     */
    public function getAllEmployees()
    {
        return Employee::whereNull('deleted_at')->get();
    }

    /**
     * method to check if new registered employee already exists.
     * @author AungKyawPaing
     * @create 03/07/2023
     * @return string
     */
    public function checkExistingEmployee($employeeId)
    {
        $existingEmployee = Employee::where('employee_id', $employeeId)->whereNull('deleted_at')->first();
        return $existingEmployee;
    }

    /**
     * to get employees count
     * @author AungKyawPaing
     * @create 11/07/2023
     * @return object
     */
    public function getEmployees($currentPage, $perPage, $searchEmployeeId, $searchCareerPath, $searchLevel)
    {
        $query = Employee::query();

        if ($searchEmployeeId != null) {
            $query->where('employee_id', $searchEmployeeId);
        }
        if ($searchCareerPath != null) {
            $query->where('career_path', $searchCareerPath);
        }
        if ($searchLevel != null) {
            $query->where('level', $searchLevel);
        }

        $employees = $query->paginate($perPage, ['*'], 'page', $currentPage);

        return $employees;
    }

    /**
     * Get all employees not paginated data.
     * @author AungKyawPaing
     * @create 11/07/2023
     * @return object
     */
    public function getAllEmployeeNotPaginated()
    {
        $query = Employee::all();
        return $query;
    }

}
