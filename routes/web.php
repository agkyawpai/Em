<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('login');
// });

Route::get('/', 'EmployeeController@login')->name('employees.login');
Route::get('/logout', 'AdminController@logout')->name('employees.logout');
Route::post('/employee/loginvalidate', 'AdminController@loginValidate')->name('employees.loginValidate');
Route::group(['middleware' => ['admin.auth']], function () {
    Route::match(['get', 'post'], 'employee/list', 'EmployeeController@index')->name('employees.index')->middleware('admin.auth');

    Route::match(['get', 'post'], '/employee/register-form', 'EmployeeController@register_form')->name('employee.register_form');
    Route::post('/employee/register', 'EmployeeController@register')->name('employee.register');

    Route::get('/employees/export-excel', 'EmployeeController@exportExcel')->name('employees.export-excel');
    Route::get('/employees/download-pdf', 'EmployeeController@downloadPDF')->name('employees.download-pdf');

    Route::get('employee/{id}/edit', 'EmployeeController@edit')->name('employees.edit');
    Route::post('{id}', 'EmployeeController@update')->name('employees.update');

    Route::get('employee/{id}/detail', 'EmployeeController@detail')->name('employees.detail');

    Route::match(['get', 'delete'],'/employees/{id}/delete', 'EmployeeController@destroy')->name('employees.destroy');

    Route::get('/employee-assigns', 'EmployeeController@assign_form')->name('employees.assign-form');

    Route::match(['get', 'post'], 'project/save', 'ProjectController@save_pj')->name('projects.save');

    Route::post('/assign/save', 'AssignController@store')->name('assigns.save');

    Route::post('/projects/remove', 'ProjectController@remove_pj')->name('projects.remove');

    Route::get('/docs/download/{file}', 'DocumentationController@downloadDoc')->name('documentations.download');

    Route::get('language/{locale}', 'LanguageController@changeLanguage')->name('set.language');

});
