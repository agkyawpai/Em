<?php

namespace App\Repositories;

use App\Interfaces\EmployeeProgrammingLanguagesInterface;
use App\Models\EmployeeProgrammingLanguage;
use Illuminate\Support\Facades\DB;

/**
 * provides methods for getting programming languages of employees from the database.
 * Implements the EmployeeProgrammingInterface interface.
 *
 * @author AungKyawPaing
 * @create  23/06/2023
 */
class EmployeeProgrammingLanguagesRepository implements EmployeeProgrammingLanguagesInterface
{
    /**
     * Get the programming languages of a specific employee.
     * @author AungKyawPaing
     * @create 23/06/2023
     * @param int $id.
     * @return array
     */
    public function getProgrammingLanguageofEmployee($id)
    {
        $programming_languages = [];
        $emp_prog_lang = EmployeeProgrammingLanguage::where('employee_id', $id)->select('programming_language_id')->get()->toArray();
        foreach ($emp_prog_lang as $programming_language) {     //push into new array to only get the id
            array_push($programming_languages, $programming_language['programming_language_id']);
        }
        return $programming_languages;
    }

     /**
     * Get all programming languages
     * @author AungKyawPaing
     * @create 06/07/2023
     * @param
     * @return array
     */
    public function getAllProgrammingLanguages()
    {
        $programming_languages = DB::table('employee_programming_languages')
        ->join('programming_languages', 'employee_programming_languages.programming_language_id', '=', 'programming_languages.id')
        ->select('employee_programming_languages.employee_id', 'programming_languages.name as programming_language')
        ->get()->toArray();
        return $programming_languages;
    }
}
