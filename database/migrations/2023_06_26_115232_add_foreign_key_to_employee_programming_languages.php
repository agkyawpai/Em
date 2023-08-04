<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToEmployeeProgrammingLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_programming_languages', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->change();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->unsignedBigInteger('programming_language_id')->change();
            $table->foreign('programming_language_id')->references('id')->on('programming_languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_programming_languages', function (Blueprint $table) {
            //
        });
    }
}
