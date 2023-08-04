<?php

namespace App\Logics;

use App\Models\EmployeeProject;
use Carbon\Carbon;

class FreeEmpLogic
{
    /**
     * Check if employee is free today.
     *
     * This method returns true or false by checking if employee is free today or not.
     * @author AungKyawPaing
     * @create 10/07/2023
     * @param  int $employeeId
     * @return bool
     */
    public function empFreeTdy($employeeId)
    {
        $today = date('Y-m-d');

        // checking if the employee has any project duration today
        $projects = EmployeeProject::where('employee_id', $employeeId)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->exists();

        return !$projects; // return true if no project duration found, false if project exists
    }

    /**
     * project detail to show when hovered
     *
     * @author AungKyawPaing
     * @create 10/07/2023
     * @param  int $employeeId $today
     * @return string
     */
    public static function getProjectDetails($employeeId, $today)
    {
        $project = EmployeeProject::join('projects', 'employee_projects.project_id', '=', 'projects.id')
            ->where('employee_id', $employeeId)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();
        if ($project) {
            // return the project details
            return "Current Assignment: {$project->name}\nStart Date:" . Carbon::parse($project->start_date)->format('d-m-Y') . "\n" . "End Date: " . Carbon::parse($project->end_date)->format('d-m-Y');
        }

        // nearest assignment date
        $nearestAssignment = EmployeeProject::join('projects', 'employee_projects.project_id', '=', 'projects.id')
            ->where('employee_id', $employeeId)
            ->whereDate('start_date', '>', $today)
            ->orderBy('start_date')
            ->first();

        if ($nearestAssignment) {
            // return the nearest assignment date
            return "Nearest Assignment: {$nearestAssignment->name}\nStart Date: " . Carbon::parse($nearestAssignment->start_date)->format('d-m-Y') . "\nEnd Date: " . Carbon::parse($nearestAssignment->end_date)->format('d-m-Y');
        }
        return 'No Assignments!';
    }
}
