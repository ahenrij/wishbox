<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\UserProfileUpdateRequest;
use App\User;
use App\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //

    function profile() {
        $categories = Category::all();
        $user_categories = UserCategory::where('user_id', Auth::user()->id)->pluck('category_id')->toArray();

//        var_dump($user_categories); die();
        return view('users.profile', [
            "template" => PROFILE_INFO_TEMPLATE,
            'categories' => $categories,
            'user_categories' => $user_categories,
        ]);
    }

    function show($id) {
        $user  = User::where('id', $id)->first();
        return view('users.show', compact('user'));
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
        // Same user ?
        if(Auth::user()->id != $user->id)
        {
            return redirect()->back()->with('error', 'Vous n\'avez pas le droit de modifier ce profil.');
        }

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
        $user->password = $inputs['password'] != "" ? bcrypt($inputs['password']) : $user->password; // TODO encryption : which algorithm ? bcrypt ?
        $user->username = $inputs['username'];
        $user->email = $inputs['email'];

//        dd($inputs['profile']->getClientOriginalName());

        if(isset($inputs['profile']))
        {
            // A file is uploaded
//            $fileName = Str::random(); // length = 16 by default
//            $fileExtension = $inputs['profile']->getClientOriginalExtension();
//            $path = $inputs['profile']->storeAs(PROFILE_UPLOAD_FOLDER, $fileName.'.'.$fileExtension);
//            $path = $inputs['profile']->store(PROFILE_UPLOAD_FOLDER);
//            $path = $request->file('profile')->store(PROFILE_UPLOAD_FOLDER);

            $path = Storage::disk('public')->put(PROFILE_UPLOAD_FOLDER, $inputs['profile']);
//            dd($path);

            $user->profile = $path;
        }


        if ($user->save()) {
            return redirect()->route('profile')->with('success', 'Modifications enregistrées avec succès !');
        } else {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement.');
        }
    }
}
