<?php

namespace App\Repositories;

use App\Interfaces\DocumentationInterface;
use Illuminate\Support\Facades\DB;

/**
 * provides methods for getting documentations of a project that an employee is working with.
 * Implements the Documentation interface.
 *
 * @author AungKyawPaing
 * @create  03/07/2023
 */
class DocumentationRepository implements DocumentationInterface
{
    /**
     * Get the documentations of a specific project that employee is working.
     * @author AungKyawPaing
     * @create 03/07/2023
     * @param int $id.
     * @return array
     */
    public function getDocumentations($empId)
    {
        $documentations = DB::table('documentations')
            ->join('projects', 'documentations.project_id', '=', 'projects.id')
            ->join('employee_projects', 'employee_projects.id' , '=' , 'documentations.employee_project_id')
            ->select('documentations.*', 'employee_projects.employee_id')->get()->toArray();
        return $documentations;
    }
}
// ->where('employee_projects.employee_id', $empId)
//             ->whereNull('documentations.deleted_at')
//             ->select('documentations.*')
//             ->get()->toArray();
