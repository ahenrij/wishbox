@extends('layouts.emails_layout')

@section('content')
    <div class="container-fluid">
        <h3 class="text-center">Vous avez demandé, quelqu'un vous l'offre</h3>
        <p>Votre souhait vient d'être accepté par <span class="font-weight-bold">{{ $user->username }} qui vous offrira donc le cadeau que vous demandez.</span>.
            <button class="btn btn-primary"><a href="{{ route('wish.show', $elementId) }}">Revoir le souhait !</a> </button>
            <br>Vous pouvez entrer directement en contact avec lui via son adresse mail : {{ $user->email }}
            <br>
        </p>
    </div>
@endsection
