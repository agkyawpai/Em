<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeProgrammingLanguage extends Pivot
{
    protected $table = 'employee_programming_languages';
    protected $primaryKey = 'id';
    use SoftDeletes;
}
