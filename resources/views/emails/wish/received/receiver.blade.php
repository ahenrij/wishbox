@extends('layouts.emails_layout')

@section('content')
    <div class="container-fluid">
        <h3 class="text-center">Vous avez demandé, quelqu'un vous l'offre</h3>
        <p>Vous venez de marquer votre souhait comme étant réceptionné ! L'équipe WishBox est ravie de savoir que ses utilisateurs
            sont satisfaits !
            <button class="btn btn-primary"><a href="{{ route('wish.show', $elementId) }}">Revoir le souhait !</a> </button>
            <br>Nous vous remercions de la confiance que vous mettez en WishBox.
            <br>
        </p>
    </div>
@endsection
