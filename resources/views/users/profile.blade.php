@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="uk-card-title">Profil</div>
                    <br>
                    <div>
                        {{ Auth::user()->name . ' ' . Auth::user()->first_name }}
                        <br>
                        <small class="text-secondary">{{ Auth::user()->email }}</small>


                        <br><br>
                        <p>{{ Auth::user()->phone_number }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
