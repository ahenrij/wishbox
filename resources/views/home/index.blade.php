@extends('layouts.app')

@section('content')
    {{--<div class="container">--}}

    <div class="row tm-welcome-row">
        <div class="col-12">
            <div
                    class="tm-welcome-parallax tm-center-child"
                    data-parallax="scroll"
                    data-image-src="img/home/banner.jpg"
                    {{--data-image-src="img/blooming-bg.jpg"--}}
            >
                <div class="tm-bg-black-transparent tm-parallax-overlay">
                    <h1 style="font-family: 'Century Gothic'">WishBox</h1>
                    <h6 style="font-family: 'Century Gothic'">Tu veux l'avoir ? Il suffit de demander !</h6>
                </div>
            </div>
        </div>
    </div>

    {{--WISHES--}}
    <div class="text-center" id="wishes">
        <h3>Les souhaits publiés</h3>
        <a href="#gifts ">Aller aux dons <i class="fa fa-arrow-alt-circle-down"></i></a>
    </div>
    <section class="row tm-pt-4">
        <div class="col-12 tm-page-cols-container">
            <div class="tm-page-col-left">
                @if (count($categories) > 0 && (count($wishes) > 0))
                    @include('categories.side', ['categories' => $categories])
                @endif

            </div>
            <div class="tm-page-col-right">
                {{--            @if (count($wishes) > 0)--}}
                <div id="tmGallery" class="tm-gallery">
                    @foreach($wishes as $wish)
                        @include('wish.item', compact('wishes'))
                    @endforeach
                </div>
{{--                @include('home.show_gifts_or_wishes', ['elements' => $wishes])--}}
                {{--@else--}}
                {{--<h4 class="text-center">Aucun souhait pour le moment.</h4>--}}
                {{--@endif--}}

                <span id="paginate-wishes">
                {{ $wishes->links() }}
            </span>
            </div>
        </div>
    </section>


    {{--GIFTS--}}
    <div class="text-center" id="gifts">
        <h3>Les dons publiés</h3>
        <a href="#wishes ">Aller aux souhaits <i class="fa fa-arrow-alt-circle-up"></i></a>
    </div>
    <section class="row tm-pt-4">
        <div class="col-12 tm-page-cols-container">
            <div class="tm-page-col-left">
                @if (count($categories) > 0 && count($gifts) > 0)
                    @include('categories.side', compact('categories'))
                @endif

            </div>
            <div class="tm-page-col-right">
                <div id="tmGallery" class="tm-gallery">
                    @foreach($wishes as $wish)
                        @include('wish.item', compact('gifts'))
                    @endforeach
                </div>
                {{--            @if (count($gifts) > 0)--}}
{{--                @include('home.show_gifts_or_wishes', ['elements' => $gifts])--}}
                {{--@else--}}
                {{--<h4 class="text-center">Aucun don pour le moment.</h4>--}}
                {{--@endif--}}

                <span id="paginate-gifts">
                    {{ $gifts->links() }}
                </span>
            </div>
        </div>
    </section>
    {{--</div>--}}

@endsection
@section('additionalPageScripts')
    <script src="{{ ('js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ ('js/isotope.pkgd.min.js') }}"></script>

    <script>
      // Edit pagination links to get scroll after page reload by adding an anchor
      // Wishes
      appendAnchorLinkData("paginate-wishes", "wishes");

      // Gifts
      appendAnchorLinkData("paginate-gifts", "gifts");

      //--
      $(function () {
          /* Isotope Gallery */

        // init isotope
        var $gallery = $(".tm-gallery").isotope({
          itemSelector: ".tm-gallery-item",
          layoutMode: "fitRows"
        });
        // layout Isotope after each image loads
        $gallery.imagesLoaded().progress(function () {
          $gallery.isotope("layout");
        });

        $(".filters-button-group").on("click", "a", function () {
          var filterValue = $(this).attr("data-filter");
          $gallery.isotope({filter: filterValue});
          console.log("Filter value: " + filterValue);
        });

          /* Tabs */
        $(".tabgroup > div").hide();
        $(".tabgroup > div:first-of-type").show();
        $(".tabs a").click(function (e) {
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

