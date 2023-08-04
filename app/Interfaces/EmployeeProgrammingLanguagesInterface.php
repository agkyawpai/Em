<?php
namespace App\Interfaces;

/**
 * EmployeeProgrammingLanguages Interface
 * This interface defines the contract for retrieving programming languages of an employee.
 *
 * @author AungKyawPaing
 * @create 23/06/2023
 */
interface EmployeeProgrammingLanguagesInterface
{
    /**
     * Get the programming languages of a specific employee.
     * @author AungKyawPaing
     *@create 23/06/2023
     * @param int $id.
     * @return array
     */
    public function getProgrammingLanguageofEmployee($id);

    /**
     * Get all programming languages
     * @author AungKyawPaing
     * @create 06/07/2023
     * @param
     * @return array
     */
    public function getAllProgrammingLanguages();
}
