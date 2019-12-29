<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('login');
    }

    public function connexion() {
        $email = $_POST['email']; //récupération de l'identifiant du formulaire HTML
        $password = $_POST['password']; //récupération du mot de passe du formulaire HTML

        $userPassword = User::select('password')
            ->where('email', $email)
            ->first();

        if (password_verify($password, $userPassword)) {
            return view('welcome');
        } else {
            return view('login');
        }

    }
}
