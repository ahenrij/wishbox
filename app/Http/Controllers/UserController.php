<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    //

    function profile() {
        return view('users.profile');
    }

    function selectTheme(Request $request)
    {
        $input = $request->all();
        $input = (int)$input['theme'];

        // Control
        if(empty($input) || !is_numeric($input))
        {
            return response()->json(['success'=>'Erreur lors de la soumission. Veuillez réessayer.']);
        }

        // Create or update cookie
        // Si thème par défaut, fin (et pas de traitement Js inutile pour appliquer le template par défaut). Sinon enregistrer.
        if($input != 1)
        {
            Cookie::queue(Cookie::make('theme-preference', 'Theme'.$input, 45000));
        }
//        if(Cookie::has('cookiename'))
//        {
//
//        }else
//        {
//
//        }

        //  var_dump((int)$input['theme']);

        return response()->json(['success'=>'Thème enregistré avec succès.']);
    }
}
