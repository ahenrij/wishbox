@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('wishbox.create') }}" class="btn btn-primary pl-5 pr-5">
                    <span uk-icon="icon: plus; ratio: .7" class="pr-2"></span>
                    {{ __('Ajouter une boîte') }}
                </a>
            </div>
            <br><br>
            <div class="col-md-9">
                <h3>{{ __('Mes boîtes à souhaits') }}</h3>

                <br>
                <div class="uk-grid-match uk-child-width-1-3@s" uk-grid>
                    @foreach($wish_boxes as $wish_box)
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <div class="uk-text">{{ substr($wish_box->title, 0, 25) . ((strlen($wish_box->title) > 25)? '...' : '') }}</div>
                                <div>
                                    <span uk-icon="icon: clock; ratio:.6"></span>
                                    <small style="padding-left: 2px; font-size: 12px">{{ date_format(date_create($wish_box->deadline), 'd-m-Y') }}</small>
                                </div>
                                <div>
                                    @if($wish_box->visibility == VISIBILITY_PRIVATE)
                                        <span uk-icon="icon: lock; ratio:.6"></span>

                                    @elseif ($wish_box->visibility == VISIBILITY_PUBLIC)
                                        <span uk-icon="icon: world; ratio:.6"></span>
                                    @else
                                        <span uk-icon="icon: users; ratio:.6"></span>
                                    @endif
                                    <small style="padding-left: 2px; font-size: 12px">{{ visibilities[$wish_box->visibility] }}</small>
                                </div>
                                <div style="float: right; align-self: baseline">
                                    <a href="{{ route('wishbox.show', $wish_box->id) }}"><span
                                                uk-icon="icon: chevron-right"></span></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
