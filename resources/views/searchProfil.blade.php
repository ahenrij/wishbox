@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if (sizeof($users->toArray()) != 0)
            <h3 class="text-center">Membres correspondant à la recherche "{{ $research }}"</h3>
        @else
            <h3 class="text-center">Aucun profil ne correspond à la recherche "{{ $research }}"</h3>
        @endif
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            @foreach($users as $user)
                <div class="card w-25 mr-5 mb-5">
                    <h5 class="card-header">{{ $user->username }}</h5>
                    <div class="card-body">{{ $user->email }}</div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

