<?php

namespace App\DBTransactions\Project;

use App\Classes\DBTransaction;
use App\Models\Project;
use Carbon\Carbon;

/**
 * Class SaveProject
 * To save new added projects in `projects` table
 *
 * @author  AungKyawPaing
 * @create 28/06/2023
 */
class SaveProject extends DBTransaction
{
    private $request;
    /**
     * SaveProject constructor.
     * @author AungKyawPaing
     * @create 28/06/2023
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Process the project saving.
     * @author AungKyawPaing
     * @create 28/06/2023
     * @return array
     */
    public function process()
    {
        $admin = session()->get('adminId');
        $request = $this->request;
        $project = new Project;
        $project->name = trim($request->project_name_modal);
        $project->created_at = Carbon::now();
        $project->updated_at = Carbon::now();
        $project->created_by = $admin;
        $project->updated_by = $admin;
        $save = $project->save();
        if (!$save) {
            return ['status' => false, 'error' => 'Failed'];
        }
        return ['status' => true, 'error' => ''];
    }
}
