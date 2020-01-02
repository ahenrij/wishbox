<?php

namespace App\Http\Controllers;

use App\User;

class SearchController extends Controller
{
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

        return view('searchProfil', [ "users" => $users, "research" => $research]);
    }
}
