@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row tm-page-cols-container">
            <div class="col-md-3">
                <button class="btn btn-outline-secondary pl-5 pr-5" onclick="javascript:history.back()">
                    <span uk-icon="icon: chevron-left; ratio: .7" class="pr-2"></span>
                    {{ __('Retour') }}
                </button>
                <br><br>
                <button class="btn btn-primary pl-5 pr-5">
                    <span uk-icon="icon: plus; ratio: .7" class="pr-2"></span>
                    {{ __('Ajouter un souhait') }}
                </button>
                <br><br>
                @include('displayCategories', compact('categories'))
            </div>
            <div class="col-md-9">
                <h3>{{ $wishbox->title }}</h3>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <br>
                <div  id="tmGallery" class="tm-gallery uk-child-width-1-3@s" uk-grid>
                    @foreach($wishes as $wish)
                        <div class="tm-gallery-item category-{{ $wish->category_id }} {{ "status".$wish->status }}">
                            <figure class="effect-bubba" style="width: 100%;">

                                <img src="{{ URL::to('/'). '/img/default_wish_image.png' }}" alt="{{ $wish->link }}"
                                     class="img-fluid"/>

                                <figcaption>
                                    <h2>Fresh <span>Bubba</span></h2>
                                    <p>Bubba likes to appear out of thin air.</p>
                                    {{--TODO remove link Little "hack for the moment just to have a link for each wish. This link will be on the show page of a wish--}}
                                    <a href="{{ route('wish.offer', $wish->id) }}">View more</a>
                                </figcaption>
                            </figure>
                        </div>
                    @endforeach
                </div>
                <br>

                {{ $wishes->links() }}
            </div>
        </div>

    </div>
@endsection
@section('additionalPageScripts')
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>

    <script>
      // Edit pagination links to get scroll after page reload by adding an anchor
      // Wishes
      var $links = $('#paginate-wishes li a');

      var href='';
      $links.each(function(){
        href = $(this).attr('href');
        $(this).attr('href', href+'#wishes');
      });

      // Gifts
      $links = $('#paginate-gifts li a');

      href='';
      $links.each(function(){
        href = $(this).attr('href');
        $(this).attr('href', href+'#gifts');
      });
      //--
      $(function() {
          /* Isotope Gallery */

        // init isotope
        var $gallery = $(".tm-gallery").isotope({
          itemSelector: ".tm-gallery-item",
          layoutMode: "fitRows"
        });
        // layout Isotope after each image loads
        $gallery.imagesLoaded().progress(function() {
          $gallery.isotope("layout");
        });

        $(".filters-button-group").on("click", "a", function() {
          var filterValue = $(this).attr("data-filter");
          $gallery.isotope({ filter: filterValue });
          console.log("Filter value: " + filterValue);
        });

          /* Tabs */
        $(".tabgroup > div").hide();
        $(".tabgroup > div:first-of-type").show();
        $(".tabs a").click(function(e) {
          e.preventDefault();
          var $this = $(this),
            tabgroup = "#" + $this.parents(".tabs").data("tabgroup"),
            others = $this
              .closest("li")
              .siblings()
              .children("a"),
            target = $this.attr("href");
          others.removeClass("active");
          $this.addClass("active");

          // Scroll to tab content (for mobile)
          if ($(window).width() < 992) {
            $("html, body").animate(
              {
                scrollTop: $("#tmGallery").offset().top
              },
              200
            );
          }
        });
      });
    </script>
@endsection
