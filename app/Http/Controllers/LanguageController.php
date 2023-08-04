<?php

namespace App\Http\Controllers;

/**
 * language controller
 *
 * @author AungKyawPaing
 * @create  05/06/2023
 */
class LanguageController extends Controller
{
    /**
     * set language in session
     * @author AungKyawPaing
     * @create 05/06/2023
     * @param  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLanguage($locale)
    {
        if (in_array($locale, ['en', 'mm'])) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
