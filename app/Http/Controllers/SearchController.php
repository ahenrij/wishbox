<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $research = $_POST['search'];
        $users = User::where('username', 'LIKE', '%'. $research .'%')
            ->orWhere('name', 'LIKE', '%'. $research .'%')
            ->orWhere('first_name', 'LIKE', '%'. $research .'%')
            ->select('name', 'first_name', 'username', 'email')
            ->get();

        return view('searchProfile', [ "users" => $users, "research" => $research]);
    }

    /**
     *
     */
    public function profile() {
        $userEmail = $_POST["email"];

        $user= User::where('email', '=', $userEmail)
                    ->first();

        return view('otherProfile', ["user" => $user]);
    }
}
