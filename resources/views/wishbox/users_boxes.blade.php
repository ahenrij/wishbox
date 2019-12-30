@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="col-md-6">
                    <a href="/wishbox" class="btn btn-secondary pl-5 pr-5">
                        <span uk-icon="icon: triangle-left; ratio: .7" class="pr-2"></span>
                        {{ __('Mes boîtes') }}
                    </a>
                </div>
                <div class="col-md-6 mt-3">
                    <a href="{{ route('wishbox.create') }}" class="btn btn-primary pl-4 pr-5">
                        <span uk-icon="icon: plus; ratio: .7" class="pr-2"></span>
                        {{ __('Ajouter une boîte') }}
                    </a>
                </div>
            </div>
            <br><br>
            <div class="col-md-9">
                <h3>{{ __('Les boîtes à souhaits') }}</h3>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <br>
                @if($wishboxes->isNotEmpty())
                    <div class="uk-grid-match uk-child-width-1-3@s" uk-grid>
                        @foreach($wishboxes as $wishbox)
                            <div>
                                <div class="uk-card uk-card-default uk-card-body uk-inline">

                                    <div class="circle uk-background-primary uk-position-top-right uk-text-bold">
                                        {{ $wishbox->total }}
                                    </div>

                                    {{--Go to box content--}}
                                    <div class="uk-position-bottom-right m-4">
                                        <a href="{{ route('wishbox.show', $wishbox->id) }}"><span
                                                uk-icon="icon: chevron-right"></span></a>
                                    </div>

                                    {{--Card content--}}
                                    <div class="uk-text">{{ substr($wishbox->title, 0, 25) . ((strlen($wishbox->title) > 25)? '...' : '') }}</div>
                                    <div>
                                        <span uk-icon="icon: clock; ratio:.6"></span>
                                        <small style="padding-left: 2px; font-size: 13px">{{ date_format(date_create($wishbox->deadline), 'd-m-Y') }}</small>
                                    </div>
                                    <div>
                                        <span uk-icon="icon: user; ratio:.6"></span>
                                        <small style="padding-left: 2px; font-size: 13px">{{ $wishbox->user }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="w-100 text-center">Aucune donnée disponible</div>
                @endif
                <br>

                {{ $wishboxes->links() }}
            </div>
        </div>
    </div>
@endsection
