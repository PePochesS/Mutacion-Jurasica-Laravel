<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('pages.opciones');
    }

    public function switchLocale(Request $request)
    {
        $locale = $request->input('locale');

        if (!in_array($locale, ['es', 'en'])) {
            $locale = 'es';
        }

        session(['locale' => $locale]);

        return back();
    }
}
