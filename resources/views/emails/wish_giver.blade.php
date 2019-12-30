@extends('layouts.emails_layout')

@section('content')
    <div class="container-fluid">
        <h3 class="text-center">MERCI !</h3>
        <p>Vous venez de faire vous engager à rendre meilleure la vie de <span class="font-weight-bold">{{ $user->username }}</span>.
            <br>Grâce à vous, le monde se porte mieux ! Vous pouvez entrer directement en contact avec lui via son adresse mail : {{ $user->email }}
            <br>
        </p>
    </div>
@endsection
