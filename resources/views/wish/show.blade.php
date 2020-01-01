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
                <h3 id="create_box_title">{{ $wish->wishBox->title . ' - ' . $wish->title }}</h3>
                <br>

                <div class="uk-card uk-card-default uk-card-body">

                    <div uk-grid>
                        <div class="uk-width-1-3@s">
                            <img src="{{ $wish->filename }}" width="350" height="350" alt="">
                        </div>
                        <div class="uk-width-expand@s">
                            <label for="" class="title uk-text-bold">Description</label>
                            <p>{{ $wish->description }}</p>

                            <label for="" class="title uk-text-bold">Priorité</label>
                            <p>{{ strtoupper($wish->priority) }}</p>

                            <a class="btn btn-primary pr-5 pl-5" href="{{ $wish->link }}" target="_blank"
                               rel="noopener">Consulter le lien</a>
                            @if (Auth::user()->id != $wish->wishBox->user_id)
                                <a class="btn btn-outline-success pr-3 pl-3">Offrir</a>
                            @else
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection