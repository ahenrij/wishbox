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
                <span class="uk-card-title">{{ $wish->wishBox->title . ' - ' }} <span class="uk-card-title" id="update_wish_title">{{ $wish->title }}</span></span>
                <br><br>

                <div class="uk-card uk-card-default uk-card-body">
                    <form method="post" action="{{ route('wish.update', $wish->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        @if(session()->has('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <img id="preview"
                                     style="border: 1px solid lightgray; border-radius: 5px; cursor: pointer; width: 150px; height: 150px"
                                     src="{{ asset(empty($wish->filename) ? 'img/default_wish_image.png' : 'img/wishes/'.$wish->filename) }}" alt="Fichier"
                                     onclick="$('#filename').click()">
                                <input id="filename" name="filename" type="file"
                                       class="@error('filename') is-invalid @enderror" style="display: none"/>
                            </div>
                            <div class="form-group col-md-8">
                                <div>
                                    <label class="mb-1" for="title">Titre</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><span uk-icon="icon: bookmark"></span></div>
                                        </div>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                               id="title"
                                               name="title" placeholder="Titre du souhait" onkeyup="updateTitle()"
                                               value="{{ empty(old('title')) ? $wish->title : old('title') }}">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1" for="type">Priorité</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><span uk-icon="icon: question"></span></div>
                                        </div>
                                        <select name="priority" id="priority" class="form-control">
                                            @foreach(wish_priorities as $key => $wish_priority)
                                                <option value="{{ $key }}"
                                                        @if($key == $wish->priority) selected @endif> {{ $wish_priority }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="mb-1" for="title">Lien utile</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><span uk-icon="icon: world"></span></div>
                                    </div>
                                    <input type="text" title="Lien"
                                           class="form-control @error('link') is-invalid @enderror" id="link"
                                           name="link" value="{{ empty(old('link')) ? $wish->link : old('link') }}"
                                           placeholder="Lien">
                                    @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="mb-1" for="type">Catégorie</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><span uk-icon="icon: question"></span></div>
                                    </div>
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach($categories as $key => $category)
                                            <option value="{{ $key }}" @if($key == $wish->category_id) selected @endif> {{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="wish_box_id" value="{{ $wish->wish_box_id }}"/>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="mb-1" for="description">Description</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><span uk-icon="icon: list"></span></div>
                                    </div>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description">{{ empty(old('description')) ? $wish->description : old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                                class="btn btn-primary pl-4 pr-4 float-right">{{ __('Sauvegarder') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalPageScripts')
    <script type="text/javascript">
      function readURL(input) {
        console.log("file changed", input);

        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
        }
      }

      $("#filename").change(function () {
        readURL(this);
      });

      function updateTitle() {
        var title = $('#title').val();
        if (title == '') {
          $('#update_wish_title').html('Nouveau souhait');
        } else {
          $('#update_wish_title').html(title);
        }
      }
    </script>
@endsection