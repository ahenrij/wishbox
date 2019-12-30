<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller {

    public function login() {
        $email = $_POST['email']; //récupération de l'identifiant du formulaire HTML
        $password = $_POST['password']; //récupération du mot de passe du formulaire HTML

        $userPassword = User::select('password')
            ->where('email', $email)
            ->first();

        if (password_verify($password, $userPassword)) {
            return view('welcome');
        } else {
            return redirect('login')->with('status', 'L\'identifiant ou le mot de passe est incorect.');
        }

    }
}
