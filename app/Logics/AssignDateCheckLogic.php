<?php

namespace App\Logics;

use App\Models\EmployeeProject;
use Carbon\Carbon;

class AssignDateCheckLogic
{
    /**
     * check if the new project assigned employee is available and not assigned other projects on that duration
     * @author AungKyawPaing
     * @create 28/06/2023
     * @return bool
     */
    public static function passesEmployeeProjectCheck($employeeId, $startDate, $endDate)
    {
        $start_date = Carbon::parse($startDate);
        $end_date = Carbon::parse($endDate);
        // logic to check if employee has another assign in that startdate enddate duration.
        $existingAssignments = EmployeeProject::where('employee_id', $employeeId)
            ->where('start_date', '<=', $end_date)
            ->where('end_date', '>=', $start_date)
            ->count();

        return $existingAssignments === 0;  //true if new start date and end date is free from other projects and false for duplicate date.
    }
}
