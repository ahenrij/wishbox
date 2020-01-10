@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="offset-md-2">
                        <div class="uk-card-title ml-2">{{ __('Connexion') }}</div>
                        <small class="ml-2">Connectez vous à votre compte WishBox</small>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" class="form-connect">
                            @csrf
                            <div class="form-group">
                                <input
                                    type="text"
                                    id="email"
                                    name="email"
                                    class="form-control offset-md-2 col-md-8 @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="E-mail"
                                    required autofocus
                                    autocomplete="email"/>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control offset-md-2 col-md-8 @error('password') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="mot de passe"
                                    required autofocus
                                    autocomplete="password"/>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>

                            <div class="form-group offset-md-2 col-md-8">
                                <input class="form-check-input ml-1" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label ml-4" for="remember">
                                    {{ __('Se souvenir de moi') }}
                                </label>
                            </div>

                            <div class="form-group offset-md-2 col-md-8">
                                <button type="submit" class="btn btn-primary pl-4 pr-4">
                                    {{ __('Connexion') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié ?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
