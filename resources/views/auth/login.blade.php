@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Connexion') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" class="form-connect">
                            @csrf
                            <div class="form-group">
                                <input
                                    type="text"
                                    id="email"
                                    name="email"
                                    class="form-control border-top-0 border-right-0 border-left-0 @error('email') is-invalid @enderror"
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
                                    class="form-control border-top-0 border-right-0 border-left-0 @error('password') is-invalid @enderror"
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

                            <div class="form-group">
                                <input class="form-check-input ml-1" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label ml-4" for="remember">
                                    {{ __('Se souvenir de moi') }}
                                </label>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
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
