<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    //

    function profile() {
        return view('users.profile', [
            "template" => PROFILE_INFO_TEMPLATE
        ]);
    }

    function selectTheme(Request $request)
    {
        $input = $request->all();
        $input = (int)$input['theme'];

        // Control
        $response = $this->controlAjaxInput($input);
        if($response == "")
        {
            // Create cookie
            Cookie::queue(Cookie::make('theme-preference', 'Theme'.$input, 45000));
            $response = "Thème enregistré avec succès.";
        }

        return response()->json(['success'=>$response]);
    }

    /**
     * @param $input
     *          Var sent via ajax request
     * @return string
     *          Response string to the user :
     *              Enpty if the input is correct
     *              Else, error message
     */
    function controlAjaxInput($input)
    {
        // Not empty, numeric value between 1 and 3 (expected value range)
        if(!empty($input) && is_numeric($input) && ($input >= 1 && $input <= 3))
        {
            return "";
        }else
        {
            return "Erreur lors de la soumission. Veuillez réessayer.";
        }

    }

    public function edit(User $user)
    {
        return view('users.profile', [
            "template" => PROFILE_EDIT_FORM
        ]);
    }
    public function update(User $user)
    {
       
    }

}
