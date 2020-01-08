@extends('layouts.emails_layout')

@section('content')
    <div class="container-fluid">
        <h3 class="text-center">MERCI !</h3>
        <p>Votre cadeau a bien été réceptionné par <span class="font-weight-bold">{{ $user->username }}</span>.
            <button class="btn btn-primary"><a href="{{ route('wish.show', $elementId) }}">Revoir le souhait !</a> </button>
            <br>Nous vous remercions de la confiance que vous mettez en WishBox.
            <br>
        </p>
    </div>
@endsection
