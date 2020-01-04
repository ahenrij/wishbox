@extends('layouts.emails_layout')

@section('content')
    <div class="container-fluid">
        <h3 class="text-center">Super, votre cadeau les intéresse !</h3>
        <p>Votre don a bien été réceptionné par <span class="font-weight-bold">{{ $user->username }}</span> !(<a href="{{ route('wish.show', $elementId) }}">Revoir le don !</a>).
            Merci pour ce geste que vous faites !
            <br>
        </p>
    </div>
@endsection
