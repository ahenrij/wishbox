@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="uk-card-title text-center" id="usernameBox">{{ Auth::user()->username }}</div>
                    <br>
                    <div>
                        {{--TODO changer les choses pour afficher la bonne image (condition du if et contenu éventuellement)--}}
                        <img src="@if(Auth::user()->profile != null){{ Auth::user()->profile }}@else{{  'img/avatar.png' }}@endif">
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="uk-card-title">Mes informations</div>
                    <br>
                    {{--Include profile info or edit form (var passed from controller)--}}
                    @include($template)

                </div>
            </div>
        </div>

        <div class="uk-card uk-card-default uk-card-body mt-2">
            <div class="uk-card-title">Mes préférences</div>
                <h5 class="mt-2">Thème général du site</h5>
                <form name="preference-form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" name="theme" id="theme1" checked>
                                <label class="form-check-label" for="theme1">
                                    Thème 1 (par défaut)
                                </label>
                                <div class="row">
                                    <div class="theme-demo theme1-color1"></div>
                                    <div class="theme-demo theme1-color2"></div>
                                    <div class="theme-demo theme1-color3"></div>
                                    <div class="theme-demo theme1-color4"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="2" name="theme" id="theme2">
                                <label class="form-check-label" for="theme2">
                                    Thème 2
                                </label>
                                <div class="row">
                                    <div class="theme-demo theme2-color1"></div>
                                    <div class="theme-demo theme2-color2"></div>
                                    <div class="theme-demo theme2-color3"></div>
                                    <div class="theme-demo theme2-color4"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="3" name="theme" id="theme3">
                                <label class="form-check-label" for="theme3">
                                    Thème 3
                                </label>
                                <div class="row">
                                    <div class="theme-demo theme3-color1"></div>
                                    <div class="theme-demo theme3-color2"></div>
                                    <div class="theme-demo theme3-color3"></div>
                                    <div class="theme-demo theme3-color4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-submit mt-2"><i class="fa fa-thumbs-up"></i> Appliquer</button>
                </form>
        </div>
    </div>
@endsection

@section('additionalPageScripts')
    <script type="text/javascript">

        function updatePseudo() {
            var username = $('#username').val();
            if (username != '') {
                $('#usernameBox').html(username);
            }
        }

        // AJAX

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".btn-submit").click(function(e){
            e.preventDefault();

            // Get selected theme
            var theme = document.querySelector('input[name="theme"]:checked').value;

            // alert(theme);
            $.ajax({
                type:'POST',
                url:"{{ route('selectTheme') }}",
                data:{theme:theme},
                success:function(data){ // TODO handle error case
                    // Get selected theme options (from theme_options.js)
                    var selectedTheme = themeOptions["Theme"+theme]; // Ex : Theme2

                    // Apply theme options
                    var html = document.getElementsByTagName('html')[0];

                    applyTheme(selectedTheme, html);
                    alert(data.success);
                }
            });

        });

    </script>
@endsection

