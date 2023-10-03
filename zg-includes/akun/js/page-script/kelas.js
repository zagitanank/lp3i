(function () {
  "use strict";
  $("#show-hidden-row").DataTable({
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.childRowImmediate,
        type: "",
      },
    },
    dom: '<"toolbar">frtip',
  });

  $("#show-hidden-row").on("click", ".alertdel", function () {
    var id = $(this).attr("id");
    $("#alertdel").modal("show");
    $("#delid").val(id);
  });
})(jQuery);
