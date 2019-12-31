@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div id="carousel" class="carousel slide w-100" data-ride="carousel" style="max-height: 500px;">
                <ol class="carousel-indicators">
                    <li data-target="#carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner uk-inline" style="max-height: 500px;">
                    <div class="carousel-item active uk-inline">
                        <img src="{{ asset('img/welcome/carousel1.jpg') }}" alt="Present">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/welcome/carousel2.jpg') }}" alt="Teddy">
                    </div>
                    {{--Shadow on carousel--}}
                    <div class="w-100 h-100 uk-position-center" style="background: #00000026 !important;"></div>
                </div>
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    <br><br>
    <div class="uk-child-width-expand@s uk-grid-match" uk-grid>
        <div>
            <div class="uk-card uk-card-default uk-card-body">
                <div class="uk-card-title text-primary">Bienvenue sur WishBox !</div>
                <br>
                <p> Wishbox est un site merveilleux dans lequel les voeux de tous sont exaucer !! Rejoignez la
                    communauté de
                    wishBox et recevez les cadeaux que vous souhaitez et offrez des cadeaux
                    à qui vous voulez.</p>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body">
                <div class="uk-card-title text-primary">Echangez avec le monde entier</div>
                <br>
                <p>Inscrivez vous dès maintenant et créez votre liste de souhait afin de recevoir vos cadeaux, parcourez
                    les
                    liste de souhaits d'autruis et réalisez leur rêve.
                    Wishbox vous permet d'echanger des cadeaux avec le monde entier.</p>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body">
                <div class="uk-card-title text-primary">And Something else...</div>
                <br>
                <p>Guys i'm not inspired for this, I didn't even try to think about it for now</p>
            </div>
        </div>
    </div>

    <div class="uk-inline w-100 uk-margin-large" style="background: #2d2d2d !important;" uk-grid>
        <button class="uk-button uk-button-primary uk-position-center" onclick="window.location='{{ url("/register") }}'">Commencer maintenant</button>
    </div>

@endsection
