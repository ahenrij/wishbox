<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller {

    public function register() {
        $name = $_POST['name']; //récupération du nom du formulaire HTML
        $email = $_POST['email']; //récupération de l'identifiant du formulaire HTML
        $password = $_POST['password']; //récupération du mot de passe du formulaire HTML
        $passwordConfirm = $_POST['password_confirmation']; //récupération de la confirmation de mot de passe du formulaire HTML

        if ($password != $passwordConfirm) {
            return redirect('register')->with('status', 'Les deux mot de passes ne correspondent pas, veuillez réessayer.');
        }

        $user = new User;
        $user->username = $name;
        $user->email = $email;
        $user->password = $password;
        $user->save();





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
