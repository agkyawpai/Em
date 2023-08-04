<?php

namespace App\DBTransactions\Project;

use App\Classes\DBTransaction;
use Illuminate\Support\Facades\DB;

/**
 * Class DeleteProject
 * To delete projects in `projects` table but check if the project is assigned to other employees
 *
 * @author  AungKyawPaing
 * @create 30/06/2023
 */
class DeleteProject extends DBTransaction
{
    private $request;

    /**
     * DeleteProject constructor.
     * @author AungKyawPaing
     * @create 30/06/2023
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Process the project deleting.
     * @author AungKyawPaing
     * @create 30/06/2023
     * @return array
     */
    public function process()
    {
        $request = $this->request;
        $projectId = $request['project_id'];
        // dd($projectId);
        try {
            // check if the project is assigned to any employees
            $assignedEmployees = DB::table('employee_projects')
                ->join('employees', 'employee_projects.employee_id', '=', 'employees.id')
                ->select('employees.name')
                ->where('employee_projects.project_id', $projectId)
                ->whereNull('employees.deleted_at')
                ->get();
            if ($assignedEmployees->count() > 0) {  //check if the project is worked by one employee or not
                throw new \Exception("Project cannot be deleted,it is assigned to other employees.");
            }
            if($projectId == NULL) {
                throw new \Exception("Please Select Project to Remove");
            }

            // delete the project
            DB::table('projects')->where('id', $projectId)->delete();
            DB::commit();
            return ['status' => true, 'error' => ''];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false, 'error' => $e->getMessage()];
        }
    }
}
