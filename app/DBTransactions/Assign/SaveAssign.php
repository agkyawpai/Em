<?php

namespace App\DBTransactions\Assign;

use App\Classes\DBTransaction;
use App\Models\Documentation;
use App\Models\EmployeeProject;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class SaveAssign
 * To save new assignments in the `employee_projects` table
 *
 * @author AungKyawPaing
 * @created 28/06/2023
 */
class SaveAssign extends DBTransaction
{
    private $request;

    /**
     * SaveAssign constructor.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Process the assignment saving.
     * @author AungKyawPaing
     * @create 28/06/2023
     * @return array
     */
    public function process()
    {
        $admin = session()->get('adminId');
        $request = $this->request;
        $employeeId = $request['employee_id'];
        $projectName = $request['project_name'];
        $documentations = $request['documentation'];
        $startDate = $request['start_date'];
        $endDate = $request['end_date'];

        // get the project id based on the project name
        $project = Project::where('name', $projectName)->first();
        $projectId = $project['id'];

        DB::beginTransaction();

        try {
            $employeeProject = new EmployeeProject;
            $employeeProject->employee_id = $employeeId;
            $employeeProject->project_id = $projectId;
            $employeeProject->start_date = $startDate;
            $employeeProject->end_date = $endDate;
            $employeeProject->created_at = Carbon::now();
            $employeeProject->updated_at = Carbon::now();
            $employeeProject->created_by = $admin;
            $employeeProject->updated_by = $admin;

            $save_assign = $employeeProject->save();
            if ($save_assign) {
            /*
            * Documentation saving process
            */
                foreach ($documentations as $documentation) {
                    // set a unique filename
                    $filename = uniqid() . '_' . $documentation->getClientOriginalName();
                    // store the file in the public directory
                    $filepath = 'documentations/' . $filename;
                    $documentation->move('documentations', $filename);
                    // calculate file size and set it as KB
                    $filesize = round(filesize($filepath) / 1024, 2) . 'KB';

                    $documentation = new Documentation();
                    $documentation->filename = $filename;
                    $documentation->filepath = $filepath;
                    $documentation->filesize = $filesize;
                    $documentation->employee_project_id = $employeeProject->id;
                    $documentation->project_id = $projectId;
                    $documentation->created_at = Carbon::now();
                    $documentation->updated_at = Carbon::now();
                    $documentation->created_by = $admin;
                    $documentation->updated_by = $admin;
                    $save_documentation = $documentation->save();
                }
            }
            DB::commit();
            return ['status' => true, 'error' => ''];
        } catch (\Exception $e) {
            // rollback the transaction
            DB::rollback();
            // delete the saved documentations if any error occurred
            foreach ($documentations as $documentation) {
                $filePath = public_path('documentations') . DIRECTORY_SEPARATOR . $filename;
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            return ['status' => false, 'error' => 'Failed to save the assignment.'];
        }
    }
}
