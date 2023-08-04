<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

/**
 * Put admin login id in session to reuse.
 *
 * @author AungKyawPaing
 * @create  22/06/2023
 */
class AdminController extends Controller
{
    /**
     * validate admin and redirect index
     *
     * @author AungKyawPaing
     * @create  27/06/2023
     */
    public function loginValidate(LoginRequest $request)
    {
        $adminId = $request->input('employee_id');
        $password = $request->input('password');

        // admins and their passwords
        $admins = [
            '1' => 'admin1',
            '2' => 'admin2',
        ];

        // Check if adminId and the password matches
        if (array_key_exists($adminId, $admins) && $admins[$adminId] === $password) {
            $request->session()->put('adminId', $adminId);
            return redirect()->route('employees.index');
        }

        $errorMessage = 'Invalid admin credentials.';
        return redirect()->route('employees.login')->with('error', $errorMessage);
    }

    /**
     * Logout the user and end the session.
     * @author AungKyawPaing
     * @create 27/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect()->route('employees.login');
    }
}
