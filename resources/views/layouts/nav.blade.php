<ul class="navbar-nav ml-auto mr-0">
    @guest
    <li class="nav-item {{ (routeBaseName() == 'login') ? 'active' : '' }}">
        <div class="tm-nav-link-highlight"></div>
        <a class="nav-link" href="{{ url('login') }}">Connexion</a>
    </li>
    <li class="nav-item {{ (routeBaseName() == 'register') ? 'active' : '' }}">
        <div class="tm-nav-link-highlight"></div>
        <a class="nav-link" href="{{ url('register') }}">Inscription</a>
    </li>
    @else
        <li class="nav-item">
            <div class="text-center" style="margin-right: 35px; padding-top: 10px; cursor: pointer">
                <span uk-icon="icon: search"></span>
            </div>
            <div style="min-width: 300px" class="uk-navbar-dropdown"
                 uk-drop="mode: click; pos:bottom-left; cls-drop: uk-navbar-dropdown;">
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                    <div class="uk-width-expand">
                        <form class="uk-search uk-search-navbar uk-width-1-1" method="POST" action=" {{ route('search') }}">
                            @csrf
                            <input class="uk-search-input" name="search" type="search" minlength="1" placeholder="Search..." autofocus>
                        </form>
                    </div>
                    <div class="uk-width-auto">
                        <a class="uk-navbar-dropdown-close" href="#" uk-close></a>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item {{ (routeBaseName() == 'home') ? 'active' : '' }}">
            <div class="tm-nav-link-highlight"></div>
            <a class="nav-link" href="{{ route('home') }}">Accueil</a>
        </li>
        <li class="nav-item {{ (routeBaseName() == 'profile') ? 'active' : '' }}">
            <div class="tm-nav-link-highlight"></div>
            <a class="nav-link" href="{{ route('profile') }}">Profil</a>
        </li>
        <li class="nav-item {{ (routeBaseName() == 'wishbox') ? 'active' : '' }}">
            <div class="tm-nav-link-highlight"></div>
            <a class="nav-link" href="{{ route('wishbox.index') }}">Je souhaite</a>
        </li>
        <li class="nav-item {{ (routeBaseName() == 'giftbox') ? 'active' : '' }}">
            <div class="tm-nav-link-highlight"></div>
            <a class="nav-link" href="{{ route('giftbox.index') }}">Je donne !</a>
        </li>
        <li class="nav-item {{ (routeBaseName() == 'about') ? 'active' : '' }}">
            <div class="tm-nav-link-highlight"></div>
            <a class="nav-link" href="{{ route('about') }}">A propos</a>
        </li>
        <li class="nav-item" style="padding-top: 5px; margin-left: 5px; cursor: pointer">
            <div class="text-center">
                <img src="{{  URL::to('/'). '/img/avatar.png' }}" class="" width="38px" height="38px" alt="">
                <span uk-icon="icon: chevron-down"></span>
            </div>
            <div uk-dropdown>
                <ul class="uk-nav uk-dropdown-nav">
                    <li class="">{{ Auth::user()->first_name . ' ' . Auth::user()->name }}</li>
                    <li class="uk-active">
                        <small>{{ Auth::user()->email }}</small>
                    </li>
                    <br>
                    <li class="uk-nav-divider"></li>
                    <br>
                    <li>
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger text-white">Déconnexion</button>
                        </form>
                    </li>
                </ul>
            </div>
        </li>
    @endif
</ul>
