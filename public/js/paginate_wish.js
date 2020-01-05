/**
 * Created by TheFather <ahenrij@gmail.com> on 01/01/2020.
 */
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