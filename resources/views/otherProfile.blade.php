@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center uk-grid-match">
            <div class="col-md-3">
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="uk-card-title text-center" id="usernameBox">{{ $user->username }}</div>
                    <br>
                    <div>
                        {{--TODO changer les choses pour afficher la bonne image (condition du if et contenu éventuellement)--}}
                        <img alt="Profil" src="@if(Auth::user()->profile != null && !empty(Auth::user()->profile)){{ URL::to('/'). '/storage/'.Auth::user()->profile }}@else{{  'img/avatar.png' }}@endif">
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="uk-card-title">Mes informations</div>
                    <br/>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-3">
                                <span class="font-weight-bold profile-info-label">Nom</span>
                                <br>
                                <small class="text-secondary">{{ $user->name }}</small>
                            </div>
                            <div class="mt-3">
                                <span class="font-weight-bold profile-info-label">Prénom(s)</span>
                                <br>
                                <small class="text-secondary">{{ $user->first_name }}</small>
                            </div>
                            <div class="mt-3">
                                <span class="font-weight-bold profile-info-label">Pseudo</span>
                                <br>
                                <small class="text-secondary">{{ $user->username }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-3">
                                <span class="font-weight-bold profile-info-label">Email</span>
                                <br>
                                <small class="text-secondary">{{ $user->email }}</small>
                            </div>
                            <div class="mt-3">
                                <span class="font-weight-bold profile-info-label">Adresse</span>
                                <br>
                                <small class="text-secondary">{{ $user->address }}</small>
                            </div>
                            <div class="mt-3">
                                <span class="font-weight-bold profile-info-label">Numéro de téléphone</span>
                                <br>
                                <small class="text-secondary">{{ $user->phone_number }}</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <br>
        <div class="uk-card uk-card-default uk-card-body">
            <a href="#" class="btn btn-primary mr-5">Les boîtes à souhaits de  {{ '@'.$user->username }}</a>
            <a href="#" class="btn btn-outline-primary">Les boîtes à cadeaux de  {{ '@'.$user->username }}</a>
        </div>
@endsection

