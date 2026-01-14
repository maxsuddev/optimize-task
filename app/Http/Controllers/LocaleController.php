<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LocaleController extends Controller
{
    public function switch($locale)
    {
        $availableLocales = ['uz', 'ru', 'en'];
        if (in_array($locale, $availableLocales)) {
            Session::put('locale', $locale);
        }
        return Redirect::back();
    }
}
