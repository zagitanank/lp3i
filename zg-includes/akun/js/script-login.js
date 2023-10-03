(function ($) {
  "use strict";

  /*----------------------------------------
     password show hide
     ----------------------------------------*/
  $(".show-hide").show();
  $(".show-hide span").addClass("show");

  $(".show-hide span").click(function () {
    if ($(this).hasClass("show")) {
      $('input[name="password"]').attr("type", "text");
      $(this).removeClass("show");
    } else {
      $('input[name="password"]').attr("type", "password");
      $(this).addClass("show");
    }
  });
  $('form button[type="submit"]').on("click", function () {
    $(".show-hide span").addClass("show");
    $(".show-hide")
      .parent()
      .find('input[name="password"]')
      .attr("type", "password");
  });

  $("#formLogin").submit(function (e) {
    $("#btnProses").attr("disabled", true);
    $("#btnProses").html(
      '<i class="fa fa-spin fa-spinner mr-2"></i> Proses Login'
    );
  });
})(jQuery);
