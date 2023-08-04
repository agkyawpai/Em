<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeProject extends Model
{
    protected $table = 'employee_projects';
    protected $primaryKey = 'id';
    use SoftDeletes;
}
