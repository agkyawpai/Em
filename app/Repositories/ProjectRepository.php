<?php

namespace App\Repositories;

use App\Interfaces\ProjectInterface;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

/**
 * provides methods for retrieving projects data from the database.
 * Implements the ProjectInterface contract.
 *
 * @author AungKyawPaing
 * @create  28/06/2023
 */
class ProjectRepository implements ProjectInterface
{
    /**
     * Get all projects in project table
     * @author AungKyawPaing
     * @create 28/06/2023
     * @return array
     **/
    public function getAllProjects()
    {
        $projects = Project::all();
        return $projects;
    }

    /**
     * Get projects by employee's id(PK).
     * @author AungKyawPaing
     * @create 03/07/2023
     * @return array
     **/
    public function getProjectById($id)
    {
        $project = DB::table('projects')->join('employee_projects', 'employee_projects.project_id', '=', 'projects.id')
            ->where('employee_projects.employee_id', $id)
            ->select('employee_projects.id as employee_project_id','projects.id', 'projects.name', 'start_date', 'end_date')
            ->orderBy('start_date', 'asc')
            ->get()->toArray();
        return $project;
    }

    /**
     * Get projects with no employees.
     * @author AungKyawPaing
     * @create 03/07/2023
     * @return array
     **/
    public function getProjectWithNoEmp()
    {
        $projectsWithoutEmployees = Project::leftJoin('employee_projects', 'projects.id', '=', 'employee_projects.project_id')
            ->select('projects.*')
            ->whereNull('employee_projects.id')
            ->get()->toArray();
        return $projectsWithoutEmployees;
    }
}
