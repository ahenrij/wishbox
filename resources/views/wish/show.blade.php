@extends('layouts.app')

@section('additionalPageStylesheets')
    {{--  Si ce sont des cadeaux et que c'est l'utilisateur courant qui offre, afficher les commentaires--}}
    @if($wish->wishBox->type == TYPE_GIFT && $wish->wishBox->user_id == \Illuminate\Support\Facades\Auth::user()->id)
        <link href="{{ URL::to('/'). ('/css/comments.css') }}" rel="stylesheet">
    @endif
@endsection

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
                @if($wish->wishBox->type == TYPE_GIFT && $wish->wishBox->user_id == \Illuminate\Support\Facades\Auth::user()->id)
                    <a href="#comments">Voir les commentaires <i class="fa fa-arrow-alt-circle-down"></i></a>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
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

                            @if($wish->status == WISH_ON_THE_WAY)
                                <a href="{{ route($type.'.received', [$wish->id]) }}" class="btn btn-outline-success">{{ __('J\'ai reçu !') }}</a>
                            @endif

                        @if (Auth::user()->id != $wish->wishBox->user_id)
                                @if($wish->wishBox->type == TYPE_WISH)
                                    @if($wish->user_id == null)
                                        <a href="{{ route('wish.offer.wish', $wish->id) }}" class="btn btn-outline-success pr-5 pl-5"
                                           onclick="return confirm('Voulez-vous poursuivre et offrir ce cadeau ?')">Offrir</a>
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
                                @endif
                                <div class="mt-3">
                                    <a class="btn btn-outline-secondary pr-3 pl-3"
                                       href="{{ route($type.'.edit', $wish->id) }}">Modifier</a>

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

                    {{--Comment to obtain gift--}}
                    @if (Auth::user()->id != $wish->wishBox->user_id && $wish->wishBox->type == TYPE_GIFT && $wish->status == WISH_JUST_CREATED)
                        <form name="obtainGift" action="{{ route('gift.get', $wish->id) }}">
                        <br>
                        <label for="message">Message (max. 2500 caractères)</label>
                        <div class="row">
                            <div class="col-md-8">
{{--                                TODO retirer le texte--}}
                                <textarea id="message" name="message" class="form-control">Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux ! Je veux !</textarea>
                            </div>
                        </div>
                        <button class="btn btn-outline-secondary mt-2"><a href="" class="w-100 ">Obtenir</a></button>
                        </form>
                    @endif
                </div>

                {{--  Si ce sont des cadeaux et que c'est l'utilisateur courant qui offre, afficher les commentaires--}}
                @if($wish->wishBox->type == TYPE_GIFT && $wish->wishBox->user_id == \Illuminate\Support\Facades\Auth::user()->id)
                    <div class="uk-card uk-card-default uk-card-body mt-4" id="comments">
                        <h4 class="text-center">Les intérêts manifestés</h4>
                        @if ($comments != null && count($comments) > 0)
                            <div>
                                @foreach($comments as $comment)

                                    <div class="media comment-box mb-2" id="comment-{{ $comment->user_id }}">
                                        <img class="align-self-center rounded-circle mr-3 ml-1 hoverShadow" src="{{ $comment->profile }}" alt="Profil"
                                             width="150" height="150">
                                        <div class="media-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="mt-0 text-left"><a class="profile-link" href="{{ route('user.show', $comment->user_id) }}">{{ $comment->username }}</a></h5>
                                                </div>
                                                <div class="col-md-6 text-right pr-4">
                                                    <span class="small font-weight-bold">{{ date('d-m-Y à H:i:s', strtotime($comment->datePublication)) }}</span>
                                                </div>
                                            </div>
                                            <p>
                                                {{ $comment->message }}
                                            </p>

                                            <a href="{{ route('wish.offer.gift',[$wish->id, $comment->user_id]) }}"
                                               onclick="return confirm('Voulez-vous poursuivre et offrir votre cadeau à cet utilisateur ?')"
                                               >
                                                <button class="btn btn-primary hoverShadow mb-2"><i class="fa fa-heart"></i> Offrir</button>
                                            </a>

                                        </div>
                                    </div>
                                @endforeach
                                <span id="paginate-comments">
                                    {{ $comments->links() }}
                                </span>
                            </div>
                        @else
                            <p class="text-center">Aucune manifestation d'intérêt pour le moment. Vous pouvez partager le lien vers votre
                                cadeau sur vos réseaux sociaux pour qu'il ait plus de visibilité.
                                <br>
                                <button onclick='copyToClipboard("{{ route("wish.show", $wish->id) }}")' class="btn btn-primary"><i class="fa fa-copy"></i> Copier le lien dans le presse papier</button>
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('additionalPageScripts')
    <script>
        // Add id to url generated to scroll after page changing (pagination) -- function in app.js
        appendAnchorLinkData("paginate-comments", "comments");

        function copyToClipboard(str) {
            const el = document.createElement('textarea');  // Create a <textarea> element
            el.value = str;                                 // Set its value to the string that you want copied
            el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
            el.style.position = 'absolute';
            el.style.left = '-9999px';                      // Move outside the screen to make it invisible
            document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
            const selected =
                document.getSelection().rangeCount > 0        // Check if there is any content selected previously
                    ? document.getSelection().getRangeAt(0)     // Store selection if found
                    : false;                                    // Mark as false to know no selection existed before
            el.select();                                    // Select the <textarea> content
            document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
            document.body.removeChild(el);                  // Remove the <textarea> element
            if (selected) {                                 // If a selection existed before copying
                document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
                document.getSelection().addRange(selected);   // Restore the original selection
            }
            UIkit.notification("<span uk-icon='icon: check'></span> Lien copié dans le presse papier");
        };
    </script>
@endsection
