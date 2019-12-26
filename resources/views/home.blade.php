@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="uk-card uk-card-default uk-card-body">
                <div class="uk-card-title">Bienvenue</div>

                <div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Content de vous (re)voir <b class="text-primary">{{ Auth::user()->name }}</b> !
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
