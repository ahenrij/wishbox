@extends('layouts.emails_layout')

@section('content')
    <div class="container-fluid">
        <h3 class="text-center">Super, votre cadeau les intéresse !</h3>
        <p>L'utilisateur <span class="font-weight-bold">{{ $user->username }}</span> est intéressé par un cadeau que vous offrez à la communauté WishBox (<a href="{{ route('wish.show', $elementId) }}">Revoir le don !</a>).
            Vous pouvez consulter le petit message qu'il vous a laissé en cliquant sur le bouton ci-dessous.
            <button class="btn btn-primary"><a href="{{ route('wish.show', $elementId) }}">Voir le message !</a> </button>
            <br>Grâce à vous, le monde se porte mieux ! Vous pouvez entrer directement en contact avec lui via son adresse mail : {{ $user->email }}
            <br>
        </p>
    </div>
@endsection
