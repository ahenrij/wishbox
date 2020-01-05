<div class="row">
    <div class="col-md-6">
        <div class="mt-3">
            <span class="profile-info-label">Nom</span>
            <br>
            <small class="font-weight-bold text-secondary">{{ Auth::user()->name }}</small>
        </div>
        <div class="mt-3">
            <span class="profile-info-label">Prénom(s)</span>
            <br>
            <small class="font-weight-bold text-secondary">{{ Auth::user()->first_name }}</small>
        </div>
        <div class="mt-3">
            <span class="profile-info-label">Pseudo</span>
            <br>
            <small class="font-weight-bold text-secondary">{{ Auth::user()->username }}</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mt-3">
            <span class="profile-info-label">Email</span>
            <br>
            <small class="font-weight-bold text-secondary">{{ Auth::user()->email }}</small>
        </div>
        <div class="mt-3">
            <span class="profile-info-label">Adresse</span>
            <br>
            <small class="font-weight-bold text-secondary">{{ Auth::user()->address }}</small>
        </div>
        <div class="mt-3">
            <span class="profile-info-label">Numéro de téléphone</span>
            <br>
            <small class="font-weight-bold text-secondary">{{ Auth::user()->phone_number }}</small>
        </div>
    </div>
</div>

<div class="mt-2">
    <a href="{{ route('users.edit', Auth::user()) }}"><button class="btn btn-primary"><i class="fa fa-edit"></i> Modifier</button></a>
</div>
