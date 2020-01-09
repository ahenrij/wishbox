@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="uk-card-title">A propos</div>
                    <br>
                    <div>

                        <div class="row">
                            <div class="offset-md-3 col-md-4">
                                <img src="{{ URL::to('/') . '/img/icon.png' }}" class="m-5 w-100" alt="icon wishbox"
                                     style="height: 120px;"/>
                            </div>
                        </div>

                        <p class="uk-text-center">
                            <b style="font-family: 'Century Gothic'">WishBox</b> est une
                            plateforme qui permet à tous de recevoir le cadeau parfait et utile. <br>
                            <small class="uk-text-center">Copyright 2019</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
