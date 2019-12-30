<h3>Modifier le profil</h3>
{{--@if ($errors->any())--}}
{{--    <div class="alert alert-danger">--}}
{{--        <ul>--}}
{{--            @foreach ($errors->all() as $error)--}}
{{--                <li>{{ $error }}</li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--@endif--}}
<form method="post" action="{{route('users.update', $user)}}">
    @csrf
    @method('patch')

    <div class="form-row">
        <div class="form-group col-md-4">
            <label class="mb-1" for="name">Nom</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><span uk-icon="icon: pencil"></span></div>
                </div>
                <input required type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                       name="name" placeholder="Votre nom" value="{{ empty(old('name')) ? $user->name : old('name') }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-4">
            <label class="mb-1" for="first_name">Prénom</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><span uk-icon="icon: pencil"></span></div>
                </div>
                <input required type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                       name="first_name" placeholder="Votre prénom" value="{{ empty(old('first_name')) ? $user->first_name : old('first_name') }}">
                @error('first_name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-4">
            <label class="mb-1" for="username">Pseudo</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><span uk-icon="icon: user"></span></div>
                </div>
                <input required type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                       name="username" placeholder="Votre nom d'utilisateur" onkeyup="updatePseudo()" value="{{ empty(old('username')) ? $user->username : old('username') }}">
                @error('username')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="mb-1" for="email">Email</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><span uk-icon="icon: mail"></span></div>
                </div>
                <input required type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                       name="email" placeholder="Votre adresse mail" value="{{ empty(old('email')) ? $user->email : old('email') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="mb-1" for="phone_number">Téléphone</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><span uk-icon="icon: phone"></span></div>
                </div>
                <input required type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                       name="phone_number" placeholder="Votre numéro de téléphone" value="{{ empty(old('phone_number')) ? $user->phone_number : old('phone_number') }}">
                @error('phone_number')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label class="mb-1" for="address">Adresse</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><span uk-icon="icon: mail"></span></div>
                </div>
                <input required type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                       name="address" placeholder="Votre adresse" value="{{ empty(old('address')) ? $user->address : old('address') }}">
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="mb-1" for="password">Mot de passe</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><span uk-icon="icon: mail"></span></div>
                </div>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                       name="password" placeholder="Votre mot de passe" value="{{ empty(old('password')) ? "" : old('password') }}">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="mb-1" for="password_confirmation">Confirmation du mot de passe</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><span uk-icon="icon: phone"></span></div>
                </div>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                       name="password_confirmation" placeholder="Répéter le mot de passe" value="{{ empty(old('password_confirmation')) ? "" : old('password_confirmation') }}">
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Enregistrer</button>
</form>
