@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row tm-page-cols-container">
            <div class="col-md-3">
                <button class="btn btn-outline-secondary pl-5 pr-5" onclick="javascript:history.back()">
                    <span uk-icon="icon: chevron-left; ratio: .7" class="pr-2"></span>
                    {{ __('Retour') }}
                </button>
                <br><br>
                <button class="btn btn-primary pl-5 pr-5">
                    <span uk-icon="icon: plus; ratio: .7" class="pr-2"></span>
                    {{ __('Ajouter un souhait') }}
                </button>
                <br><br>
                @include('displayCategories', compact('categories'))
            </div>
            <div class="col-md-9">
                <h3>{{ $wishbox->title }}</h3>

                <br>
                <div  id="tmGallery" class="tm-gallery uk-child-width-1-3@s" uk-grid>
                    @foreach($wishes as $wish)
                        <div class="tm-gallery-item category-{{ $wish->category_id }}">
                            <figure class="effect-bubba" style="width: 100%;">

                                <img src="{{ URL::to('/'). '/img/default_wish_image.png' }}" alt="{{ $wish->link }}"
                                     class="img-fluid"/>

                                <figcaption>
                                    <h2>Fresh <span>Bubba</span></h2>
                                    <p>Bubba likes to appear out of thin air.</p>
                                    <a href="#">View more</a>
                                </figcaption>
                            </figure>
                        </div>
                    @endforeach
                </div>
                <br>

                {{ $wishes->links() }}
            </div>
        </div>

    </div>
@endsection
