@extends('layouts.app')

@section('content')

    <div class="row" >
        <div class="col-md-12">
            <div id="carousel" class="carousel slide w-100" data-ride="carousel" style="max-height: 500px;">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner" style="max-height: 500px;">
                    <div class="carousel-item active">
                        <img src="{{ asset('img/welcome/carousel1.jpg') }}" height="500" alt="Present">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/welcome/carousel2.jpg') }}" alt="Teddy">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    <br><br>
    <div class="row">
        <h3 class="text-primary text-center w-100">Bienvenue sur WishBox !</h3>
        <p class="tm-mb-6 pr-5 pl-5 w-100 text-center">
            Wishbox est un site merveilleux dans lequel les voeux de tous sont exaucer !! Rejoignez la communauté de
            wishBox et recevez les cadeaux que vous souhaitez et offrez des cadeaux
            à qui vous voulez.
        </p>

        <h2 class="tm-text-secondary tm-mb-5">
            Echangez avec le monde entier
        </h2>
        <p class="tm-mb-6">
            Inscrivez vous dès maintenant et créez votre liste de souhait afin de recevoir vos cadeaux, parcourez les
            liste de souhaits d'autruis et réalisez leur rêve.
            Wishbox vous permet d'echanger des cadeaux avec le monde entier.
        </p>
    </div>

@endsection
