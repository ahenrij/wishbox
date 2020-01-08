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
                @if (Auth::user()->id == $wishbox->user_id && !$pending)
                    <button class="hoverShadow btn btn-primary pl-5 pr-5" onclick="location.href='{{ route('wish.create') }}'">
                        <span uk-icon="icon: plus; ratio: .7" class="pr-2"></span>
                        {{ __('Ajouter un '.wish_types[$type]) }}
                    </button>

                @endif

{{--                // En attende de réception--}}
                    {{--  Afficher si ce ne sont pas ses boîtes quand ce sont des gifts ou
                        ce sont ses boites à souhait qu'on affiche --}}
                @if ((Auth::user()->id != $wishbox->user_id && $wishbox->type == TYPE_GIFT) ||
                     Auth::user()->id == $wishbox->user_id && $wishbox->type == TYPE_WISH)
                    @if(!$pending)
                        <button class="hoverShadow btn btn-secondary pl-5 pr-3 mt-2" onclick="location.href='{{ route($type.'box.show.pending', [$wishbox->id, "pending"]) }}'">
                            <span uk-icon="icon: future; ratio: .7" class="pr-2"></span>
                            {{ __('En attente de réception') }}
                        </button>
                    @endif
                @endif

                <br><br>
                @include('categories.side', compact('categories'))
            </div>
            <div class="col-md-9">
                @if (!$isOwner)
                    <h5>@ {{ $wishbox->user->username }}</h5>
                @endif

                <h3>{{ $wishbox->title }}@if($pending) <span class="small font-italic">{{ "(En attente de réception dans cette boîte)" }}</span>@endif</h3>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <br>
                <div id="tmGallery" class="tm-gallery">
                    @foreach($wishes as $wish)
                        @include('wish.item', compact('wish', 'type'))
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
