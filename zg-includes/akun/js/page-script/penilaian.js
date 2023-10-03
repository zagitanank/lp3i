(function () {
  ("use strict");

  $("#logbook-nilai").DataTable({
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.childRowImmediate,
        type: "",
      },
    },
    info: false,
    ordering: false,
    paging: false,
  });

})(jQuery);
