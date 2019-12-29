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
                <h3>{{ __('Nouvelle boîte') }}</h3>
                <br>
                <form method="post" action="{{ route('wishbox.store') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span uk-icon="icon: bookmark"></span></div>
                                </div>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Titre de la boîte">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span uk-icon="icon: question"></span></div>
                                </div>
                                <select name="type" id="type" class="form-control">
                                    @foreach(wish_types as $key => $wish_type)
                                        <option value="{{ $key }}"> {{ $wish_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span uk-icon="icon: calendar"></span></div>
                                </div>
                                <input type="date" title="Date butoir" class="form-control" id="deadline" name="deadline"
                                       placeholder="Date butoir">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><span uk-icon="icon: world"></span></div>
                                </div>
                                <select name="visibility" id="visibility" class="form-control">
                                    @foreach(visibilities as $key => $visibility)
                                        <option value="{{ $key }}"> {{ $visibility }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pl-4 pr-4 float-right">{{ __('Sauvegarder') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
