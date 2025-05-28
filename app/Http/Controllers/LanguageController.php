<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        // Lista de idiomas disponíveis
        $availableLocales = ['pt_BR', 'en'];

        // Verifica se o idioma solicitado está disponível
        if (in_array($lang, $availableLocales)) {
            Session::put('locale', $lang);
        }

        return redirect()->back();
    }
} 