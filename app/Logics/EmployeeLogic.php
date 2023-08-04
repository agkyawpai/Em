<?php

namespace App\Logics;

class EmployeeLogic
{
    /**
     * Get the language names.
     *
     * This method returns the language names based on the provided language IDs.
     * @author AungKyawPaing
     * @create 22/06/2023
     * @param  string  $language  The comma-separated language IDs
     * @return string  The language names
     */
    public static function getLanguagesName($language)
    {
        $languages = [
            1 => 'English',
            2 => 'Japanese',
        ];

        $languageIds = explode(',', $language);
        $languageNames = [];

        foreach ($languageIds as $languageId) {
            if (isset($languages[$languageId])) {
                $languageNames[] = $languages[$languageId];
            }
        }

        return implode(', ', $languageNames);
    }

    /**
     * Get the career path name.
     *
     * This method returns the career path name based on the provided career path ID.
     * @author AungKyawPaing
     * @create 22/06/2023
     * @param  int  $careerPath  The career path ID
     * @return string  The career path name
     */
    public static function getCareerName($careerPath)
    {
        $careerPaths = [
            1 => 'Front End',
            2 => 'Back End',
            3 => 'Full Stack',
            4 => 'Mobile',
        ];

        if (isset($careerPaths[$careerPath])) {
            return $careerPaths[$careerPath];
        }

        return '';
    }

    /**
     * Get the level name.
     *
     * This method returns the level name based on the provided level ID.
     * @author AungKyawPaing
     * @create 22/06/2023
     * @param  int  $level  The level ID
     * @return string  The level name
     */
    public static function getLevelName($level)
    {
        $levels = [
            1 => 'Beginner',
            2 => 'Junior Engineer',
            3 => 'Engineer',
            4 => 'Senior Engineer',
        ];

        if (isset($levels[$level])) {
            return $levels[$level];
        }

        return '';
    }

    /**
     * Get the programming languages of specific employee in format ','
     * This method returns the prograrmming languages of employee .
     * @author AungKyawPaing
     * @create 06/07/2023
     * @param  string  $pemp_programming,$employeeId  The comma-separated programming languages
     * @return string  programming languages names
     */
    public static function getProgrammingLanguages($emp_programming, $employeeId)
    {
        $programmingLanguages = [];

        foreach ($emp_programming as $employeeLanguage) {
            if ($employeeLanguage->employee_id == $employeeId) {
                $programmingLanguages[] = $employeeLanguage->programming_language;
            }
        }

        return implode(', ', $programmingLanguages);
    }
}
