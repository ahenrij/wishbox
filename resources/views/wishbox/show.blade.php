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
                @include('categories.side', compact('categories'))
            </div>
            <div class="col-md-9">
                <h3>{{ $wishbox->title }}</h3>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <br>
                <div id="tmGallery" class="tm-gallery">
                    @foreach($wishes as $wish)
                        @include('wish.item', compact('$wish'))
                    @endforeach
                </div>
                <br>

                {{ $wishes->links() }}
            </div>
        </div>

    </div>
@endsection
@section('additionalPageScripts')
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/paginate_wish.js') }}"></script>
@endsection
