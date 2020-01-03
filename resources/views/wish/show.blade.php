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
                @if(Auth::user()->id != $wish->wishBox->user_id)
                    <h5>@ {{ $wish->wishBox->user->username }}</h5>
                @endif
                <h3 id="create_box_title">{{ $wish->wishBox->title . ' - ' . $wish->title }}</h3>
                <br>

                <div class="uk-card uk-card-default uk-card-body">

                    <div uk-grid>
                        <div class="uk-width-1-3@s">
                            <img class="image"
                                 src="{{ asset(empty($wish->filename) ? 'img/default_wish_image.png' : 'img/wishes/'.$wish->filename) }}"
                                 width="250" height="250" alt="">
                        </div>
                        <div class="uk-width-expand@s">
                            <label for="" class="title uk-text-bold">Description</label>
                            <p>{{ $wish->description }}</p>

                            <label for="" class="title uk-text-bold">Priorité</label>
                            <p>{{ strtoupper(wish_priorities[$wish->priority]) }}</p>

                            <a class="btn btn-primary pr-5 pl-5" href="{{ $wish->link }}" target="_blank"
                               rel="noopener"><span uk-icon="icon: world; ratio:.7" class="pr-1"
                                                    style="padding-top: -25px !important;"></span>Consulter le lien</a>
                            @if (Auth::user()->id != $wish->wishBox->user_id)
                                @if($wish->wishBox->type == TYPE_WISH)
                                    @if($wish->user_id == null)
                                        <a class="btn btn-outline-success pr-5 pl-5">Offrir</a>
                                    @else
                                        <div class="uk-inline pt-2 pb-2 pl-5 pr-5 alert alert-success">Ce souhait est
                                            déjà
                                            offert !
                                        </div>
                                    @endif
                                @endif
                            @else
                                @if($wish->wishBox->type == TYPE_WISH)
                                    @if($wish->user_id != null)
                                        <div class="uk-inline pt-2 pb-2 pl-4 pr-4 mt-3 alert alert-success">
                                            Ce souhait vous est
                                            offert par <a
                                                    href="{{ route('user.show', $wish->user_id) }}">{{ $wish->user()->firstname . ' ' . $wish->user()->name }}</a>
                                        </div>
                                    @endif
                                @else
                                    <p>Les commentaires !</p>
                                @endif
                                <div class="mt-3">
                                    <a class="btn btn-outline-secondary pr-3 pl-3"
                                       href="{{ route('wish.edit', $wish->id) }}">Modifier</a>

                                    <a href="#" class="btn btn-outline-danger"
                                       onclick="$('#del_wish_{{ $wish->id }}').click()">{{ __('Supprimer') }}</a>

                                    <form method="post"
                                          action="{{ route('wish.destroy', $wish->id) }}">
                                        @method('delete')
                                        @csrf
                                        <input type="submit" id="del_wish_{{ $wish->id }}"
                                               style="display: none"
                                               onclick="return confirm('Vous souhaitez vraiment supprimer ce souhait ?')"/>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{--Comments for obtain gift--}}
                    @if (Auth::user()->id != $wish->wishBox->user_id && $wish->wishBox->type == TYPE_GIFT)
                        <br>
                        <label for="comment">Message</label>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <a href="" class="w-100 btn btn-outline-secondary">Obtenir</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection