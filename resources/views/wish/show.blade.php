@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-outline-secondary pl-5 pr-5" onclick="javascript:history.back()">
                    <span uk-icon="icon: chevron-left; ratio: .7" class="pr-2"></span>
                    {{ __('Retour') }}
                </button>
                <br><br>
            </div>
            <div class="col-md-9">
                <h3 id="create_box_title">{{ $wish->title }}</h3>
                <br>

                <div class="uk-card uk-card-default uk-card-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection