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
                @if($wishboxes->isNotEmpty())
                    <div class="uk-grid-match uk-child-width-1-3@s" uk-grid>
                        @foreach($wishboxes as $wishbox)
                            <div>
                                <div class="uk-card uk-card-default uk-card-body uk-inline">

                                    <div class="circle uk-background-primary uk-position-top-right uk-text-bold">
                                        {{ $wishbox->total }}
                                    </div>

                                    {{--Options for owner--}}
                                    <div class="uk-position-top-right m-4">
                                        <span uk-icon="icon: more-vertical" style="cursor: pointer"></span>
                                        <div style="padding-top: 10px; padding-bottom: 10px !important;" uk-dropdown>
                                            <ul class="uk-nav uk-dropdown-nav">
                                                <li>
                                                    <a href="{{ route('wishbox.edit', $wishbox->id) }}">{{ __('Modifier') }}</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                       onclick="$('#del_wishbox_{{ $wishbox->id }}').click()">{{ __('Supprimer') }}</a>
                                                </li>
                                                <form method="post"
                                                      action="{{ route('wishbox.destroy', $wishbox->id) }}">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="submit" id="del_wishbox_{{ $wishbox->id }}"
                                                           style="display: none"
                                                           onclick="return confirm('Vous souhaitez vraiment supprimer cette boîte ?')"/>
                                                </form>
                                            </ul>
                                        </div>
                                    </div>

                                    {{--Go to box content--}}
                                    <div class="uk-position-bottom-right m-4">
                                        <a href="{{ route('wishbox.show', $wishbox->id) }}"><span
                                                    uk-icon="icon: chevron-right"></span></a>
                                    </div>

                                    {{--Card content--}}
                                    <div class="uk-text">{{ substr($wishbox->title, 0, 25) . ((strlen($wishbox->title) > 25)? '...' : '') }}</div>
                                    <div>
                                        <span uk-icon="icon: clock; ratio:.6"></span>
                                        <small style="padding-left: 2px; font-size: 13px">{{ date_format(date_create($wishbox->deadline), 'd-m-Y') }}</small>
                                    </div>
                                    <div>
                                        @if($wishbox->visibility == VISIBILITY_PRIVATE)
                                            <span uk-icon="icon: lock; ratio:.6"></span>
                                        @elseif ($wishbox->visibility == VISIBILITY_PUBLIC)
                                            <span uk-icon="icon: world; ratio:.6"></span>
                                        @else
                                            <span uk-icon="icon: users; ratio:.6"></span>
                                        @endif
                                        <small style="padding-left: 2px; font-size: 13px">{{ visibilities[$wishbox->visibility] }}</small>
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
