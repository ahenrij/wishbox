@extends('layouts.emails_layout')

@section('content')
    <div class="container-fluid">
        <h3 class="text-center">Vous avez demandé, il/elle vous l'offrira certainement !</h3>
        <p>Votre demande pour recevoir un cadeau publié par <span class="font-weight-bold">{{ $user->username }}</span> à été prise en compte.
            <button class="btn btn-primary"><a href="{{ route('wish.show', $elementId) }}">Revoir le don !</a> </button>
            <br>Vous pouvez entrer directement en contact avec lui via son adresse mail : {{ $user->email }}
            <br>
        </p>
    </div>
@endsection
