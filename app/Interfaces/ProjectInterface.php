<?php

namespace App\Interfaces;

/**
 * Project Interface
 * This interface defines the contract for retrieving projects in projects table.
 *
 * @author AungKyawPaing
 * @create 28/06/2023
 */
interface ProjectInterface
{
    /**
     * Get all projects
     * @author AungKyawPaing
     * @create 28/06/2023
     * @return array
     */
    public function getAllProjects();

    /**
     * Get projects by employee's id.
     * @author AungKyawPaing
     * @create 03/07/2023
     * @return array
     **/
    public function getProjectById($id);

    /**
     * Get projects with no employees.
     * @author AungKyawPaing
     * @create 03/07/2023
     * @return array
     **/
    public function getProjectWithNoEmp();
}
