<?php

namespace App\Interfaces;

/**
 * Employee Interface
 * This interface defines the contract for retrieving employee data.
 *
 * @author AungKyawPaing
 * @create 21/06/2023
 */
interface EmployeeInterface
{
    /**
     * Get all employees based on search criteria.
     *
     * @param  int|null  $searchEmployeeId
     * @param  int|null  $searchCareerPath
     * @param  int|null  $searchLevel
     * @return array
     */
    public function getAllEmployeeBySearch($searchEmployeeId = null, $searchCareerPath = null, $searchLevel = null);

    /**
     * Get an employee by ID.
     *
     * @param  int  $id
     * @return Employee|null
     */
    public function getEmployeeById($id);

    /**
     * Get the ID of the last employee.
     *
     * @return int
     */
    public function getLastEmployee();

    /**
     * Get count number of all employee that are active.
     *
     * @return int
     */
    public function getAllActiveEmployee();

    /**
     * Get all employee that are active.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllEmployees();

    /**
     * method to check if new registered employee already exists.
     *
     * @return string
     */
    public function checkExistingEmployee($employeeId);

    /**
     * to get employees count in a page
     * @author AungKyawPaing
     * @create 11/07/2023
     * @return object
     */
    public function getEmployees($page, $perPage, $searchEmployeeId, $searchCareerPath, $searchLevel);

     /**
     * Get all employees not paginated data.
     * @author AungKyawPaing
     * @create 11/07/2023
     * @return object
     */
    public function getAllEmployeeNotPaginated();
}
