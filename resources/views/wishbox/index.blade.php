@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="col-md-6">
                    <a href="{{ route($type.'box.create') }}" class="btn btn-primary pl-5 pr-5">
                        <span uk-icon="icon: plus; ratio: .7" class="pr-2"></span>
                        {{ __('Ajouter une boîte') }}
                    </a>
                </div>
                @if(!$isOwner)
                    <div class="col-md-6 mt-3">
                        <a href="{{ route($type.'box.index') }}" class="btn btn-secondary pl-5 pr-5">
                            <span uk-icon="icon: chevron-left; ratio: .7" class="pr-2"></span>{{ __('Mes boîtes') }}
                        </a>
                    </div>

                @else
                    <div class="col-md-6 mt-3">
                        <a href="{{ route($type.'box.others') }}" class="btn btn-secondary pl-3 pr-4">
                            <span uk-icon="icon: happy; ratio: .7" class="pr-2"></span>
                            {{ __('Boîtes des autres utilisateurs') }}
                        </a>
                    </div>
                @endif
            </div>
            <br><br>
            <div class="col-md-9">
                <div class="d-flex flex-row">
                    <h3>{{ __((($isOwner) ? 'Mes boîtes à ' : 'Les boîtes à ') . strtolower(wish_types[$type]) . (($type == TYPE_WISH) ? 's' : 'x')) }}</h3>
                    <span class="text-center ml-5" uk-icon="icon: search" style="margin-right: 35px; padding-top: 10px; cursor: pointer"></span>

                    <div style="min-width: 300px" class="uk-navbar-dropdown"
                         uk-drop="mode: click; pos:bottom-left; cls-drop: uk-navbar-dropdown;">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-expand">
                                    <input class="uk-search-input" id="search" type="text" onchange="filterBox()" placeholder="Recherche..." autofocus>
                                </form>
                            </div>
                            <div class="uk-width-auto">
                                <a class="uk-navbar-dropdown-close" href="#" uk-close></a>
                            </div>
                        </div>
                    </div>
                </div>

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
                                <div class="uk-card uk-card-default uk-card-body uk-inline" name="wishbox">

                                    <div class="circle  uk-position-top-right uk-text-bold">
                                        {{ $wishbox->total }}
                                    </div>

                                    {{--Options for owner--}}
                                    @if($isOwner)
                                        <div class="uk-position-top-right m-4">
                                            <span uk-icon="icon: more-vertical" style="cursor: pointer"></span>
                                            <div style="padding-top: 10px; padding-bottom: 10px !important;"
                                                 uk-dropdown>
                                                <ul class="uk-nav uk-dropdown-nav">
                                                    <li>
                                                        <a href="{{ route($type.'box.edit', $wishbox->id) }}">{{ __('Modifier') }}</a>
                                                    </li>
                                                    <li>
                                                        <a href="#"
                                                           onclick="$('#del_wishbox_{{ $wishbox->id }}').click()">{{ __('Supprimer') }}</a>
                                                    </li>
                                                    <form method="post"
                                                          action="{{ route($type.'box.destroy', $wishbox->id) }}">
                                                        @method('delete')
                                                        @csrf
                                                        <input type="submit" id="del_wishbox_{{ $wishbox->id }}"
                                                               style="display: none"
                                                               onclick="return confirm('Vous souhaitez vraiment supprimer cette boîte ?')"/>
                                                    </form>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif

                                    {{--Go to box content--}}
                                    <div class="uk-position-bottom-right m-4">
                                        <a href="{{ route($type.'box.show', $wishbox->id) }}"><span
                                                    uk-icon="icon: chevron-right"></span></a>
                                    </div>

                                    {{--Card content--}}
                                    <div class="uk-text wishboxTitle"value="{{ $wishbox->title }}">{{ substr($wishbox->title, 0, 25) . ((strlen($wishbox->title) > 25)? '...' : '') }}</div>
                                    <div>
                                        <span uk-icon="icon: clock; ratio:.6"></span>
                                        <small style="padding-left: 2px; font-size: 13px">{{ date_format(date_create($wishbox->deadline), 'd-m-Y') }}</small>
                                    </div>
                                    <div>
                                        @if($isOwner)
                                            @if($wishbox->visibility == VISIBILITY_PRIVATE)
                                                <span uk-icon="icon: lock; ratio:.6"></span>
                                            @elseif ($wishbox->visibility == VISIBILITY_PUBLIC)
                                                <span uk-icon="icon: world; ratio:.6"></span>
                                            @else
                                                <span uk-icon="icon: users; ratio:.6"></span>
                                            @endif
                                                <small style="padding-left: 2px; font-size: 13px">{{ visibilities[$wishbox->visibility] }}</small>
                                        @else
                                            <span uk-icon="icon: user; ratio:.6"></span>
                                            <small style="padding-left: 2px; font-size: 13px" class="wishboxUsername" value="{{ $wishbox->username }}">@ {{ $wishbox->username }}</small>
                                        @endif
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

@section('additionalPageScripts')
    <script type="text/javascript">
        function filterBox() {
            var wishbox = document.getElementsByName('wishbox');
            var search = document.getElementById('search').value.toLowerCase();

            // For each wishbox
            wishbox.forEach(function(item){
                // Get the title of the wisbox
                var title = item.querySelector('.wishboxTitle');
                var titleStr = title.getAttribute('value').toLowerCase();
                // Get the username of the wishbox
                var user = item.querySelector('.wishboxUsername');
                if (user != null) {
                    var userStr = user.getAttribute('value').toLowerCase();
                } else {
                    var userStr = '';
                }

                // If the title or the username of the wishbox doesn't matches with the research
                if (!titleStr.includes(search) && !userStr.includes(search)) {
                    // Hide the wishbox
                    item.parentElement.hidden = true;
                } else {
                    // Display the wishbox
                    item.parentElement.removeAttribute('hidden');
                }
            });
        }
    </script>
@endsection
