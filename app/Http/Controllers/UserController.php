<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            "template" => PROFILE_EDIT_FORM,
            "user" => Auth::user(),
        ]);
    }
    public function update(UserProfileUpdateRequest $request, $id)
    {
        $inputs = $request->all();
        $user = User::where('id', $id)->first();

        if($user == null)
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement');

        $user->name = $inputs['name'];
        $user->first_name = $inputs['first_name'];
        $user->address = $inputs['address'];
        $user->phone_number = $inputs['phone_number'];
        $user->password = bcrypt($inputs['password']); // TODO encryption : which algorithm ? bcrypt ?
        $user->username = $inputs['username'];
        $user->email = $inputs['email'];

        if ($user->save()) {
            return redirect()->route('profile');
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement');
        }
    }
}
