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
                <form method="POST" action="{{ route('user.profile') }}" class="card w-25 mr-5 mb-5">
                    @csrf
                    <div onmouseover="style.cursor = 'pointer'" onclick="parentNode.submit()" >
                        <input type="hidden" name="email" value="{{ $user->email }}"/>
                        <h5 class="card-header" onhover="style.cursor = pointer">{{ $user->username }}</h5>
                        <div class="card-body">
                            <span>{{ $user->first_name }} &nbsp {{ $user->name }}</span>
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>

    </div>
@endsection
