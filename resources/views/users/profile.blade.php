@extends('layouts.app')

@section('additionalPageStylesheets')
    {{--    If this is edit form, load css for file upload field--}}
    @if (isset($user))
        <link href="{{ URL::to('/'). ('/css/file_uploader.css') }}" rel="stylesheet">
    @endif
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center uk-grid-match">
            <div class="col-md-3">
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="uk-card-title text-center" id="usernameBox">{{ Auth::user()->username }}</div>
                    <br>
                    <div class="uk-inline">
                        {{--TODO changer les choses pour afficher la bonne image (condition du if et contenu éventuellement)--}}
                        <img class="file-image rounded-circle ml-2" id="profile-pic" alt="Photo de profil"
                             src="@if(Auth::user()->profile != null && !empty(Auth::user()->profile)){{ URL::to('/'). '/storage/'.Auth::user()->profile }}@else{{  'img/avatar.png' }}@endif" style="height: 150px; width: 150px">
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="uk-card uk-card-default uk-card-body">
                    <div class="uk-card-title">Mes informations</div>
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
                    {{--Include profile info or edit form (var passed from controller)--}}
                    @include($template)

                </div>
            </div>
        </div>

        <div class="uk-card uk-card-default uk-card-body mt-4">
            <div class="uk-card-title">Mes préférences</div>

            <br>
            <h5 class="mt-2">Thème général du site</h5>
            <form name="preference-form">
                <div class="row">
                    @for ($i = 1; $i < 4; $i++)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="{{ $i }}" name="theme"
                                       id="theme{{ $i }}" {{ ($i == 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="theme{{ $i }}">
                                    Thème {{ $i . (($i == 1) ? '  (par défaut)' : '') }}
                                </label>
                                <div class="row">
                                    <div class="theme-demo theme{{ $i }}-color1"></div>
                                    <div class="theme-demo theme{{ $i }}-color2"></div>
                                    <div class="theme-demo theme{{ $i }}-color3"></div>
                                    <div class="theme-demo theme{{ $i }}-color4"></div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <button class="btn btn-primary btn-submit mt-2"><i class="fa fa-thumbs-up"></i>Appliquer</button>
            </form>

            <h5 class="mt-5">Catégories</h5>
            @foreach($categories as $category)
                <span style="cursor: pointer;" onclick="switchCategory({{ $category->id }})"
                      class="uk-badge m-2 p-2 pr-4 pt-3 pb-3 pl-4 @if(in_array($category->id, $user_categories)) uk-background-primary text-white @else uk-background-muted text-secondary @endif"
                      id="cat-{{ $category->id }}">{{ $category->title }}</span>
            @endforeach
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

      $(".btn-submit").click(function (e) {
        e.preventDefault();

        // Get selected theme
        var theme = document.querySelector('input[name="theme"]:checked').value;

        // alert(theme);
        $.ajax({
          type: 'POST',
          url: "{{ route('selectTheme') }}",
          data: {theme: theme},
          success: function (data) { // TODO handle error case
            // Get selected theme options (from theme_options.js)
            var selectedTheme = themeOptions["Theme" + theme]; // Ex : Theme2

            // Apply theme options
            var html = document.getElementsByTagName('html')[0];

            applyTheme(selectedTheme, html);
            alert(data.success);
          }
        });

      });

      // File uploader

      // Set image preview to old image first
      var src = $('#profile-pic').attr('src');
      $('#image-preview').attr('src', src);

      function readURL(input) {

        el = '.file-image';
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $(el).attr('src', e.target.result);
            $(el).attr('alt', 'Aperçu');
          };

          reader.readAsDataURL(input.files[0]);
          // $('#file-image').removeClass('hidden');
          $('#start').hide();
        }
      }


      function switchCategory(id) {

        $.ajax({
          type: 'POST',
          url: "{{ route('switchCategory') }}",
          data: {id: id},
          success: function (data) { // TODO handle error case

            var element = $('#cat-' + id);

            if (data === "added") {
              element.removeClass('uk-background-muted text-secondary');
              element.addClass('uk-background-primary text-white');

              UIkit.notification("<span uk-icon='icon: check'></span> La catégorie a été ajoutée a vos préférences !");

            } else {
              element.removeClass('uk-background-primary text-white');
              element.addClass('uk-background-muted text-secondary')

              UIkit.notification("<span uk-icon='icon: check'></span> La catégorie a été retirée de vos préférences !");
            }
          }
        });
      }
    </script>
@endsection

