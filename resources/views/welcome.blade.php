@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="tm-page-col-right">
            <div id="welcomeCarousel" class="carousel slide h-auto w-75" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('img/Welcome/Carousel1.jpg') }}" alt="Present">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/Welcome/Carousel2.jpg') }}" alt="Teddy">
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

    <br/>
    <h2 class="tm-text-secondary tm-mb-5">
        Bienvenue sur WishBox
    </h2>
    <p class="tm-mb-6">
        Wishbox est un site merveilleux dans lequel les voeux de tous sont exaucer !! Rejoignez la communauté de wishBox et recevez les cadeaux que vous souhaitez et offrez des cadeaux
        à qui vous voulez.
    </p>

    <h2 class="tm-text-secondary tm-mb-5">
        Echangez avec le monde entier
    </h2>
    <p class="tm-mb-6">
        Inscrivez vous dès maintenant et créez votre liste de souhait afin de recevoir vos cadeaux, parcourez les liste de souhaits d'autruis et réalisez leur rêve.
        Wishbox vous permet d'echanger des cadeaux avec le monde entier.
    </p>

@endsection
