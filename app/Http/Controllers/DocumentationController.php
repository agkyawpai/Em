<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/**
 * documentation controller
 *
 * @author AungKyawPaing
 * @create  03/07/2023
 */
class DocumentationController extends Controller
{
    /**
     * For downloading docs in detail form
     * @author AungKyawPaing
     * @create 03/07/2023
     * @param
     * @return Response
     */
    public function downloadDoc($file)
    {
        // check if the file exists in the storage path
        if (file_exists('documentations/' . $file)) {
            $path = public_path('documentations/' . $file);
            return response()->download($path, $file);
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }
}
