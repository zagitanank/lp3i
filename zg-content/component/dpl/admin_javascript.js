/*
 *
 * - Zagitanank Javascript
 *
 * - File : admin_javascript.js
 * - Version : 1.0
 * - Author : Clark
 * - License : MIT License
 *
 *
 * Ini adalah file utama javascript Zagitanank yang memuat semua javascript di dpl.
 * This is a main javascript file from Zagitanank which contains all javascript in dpl.
 *
 */
//Initialize Select2 Elements
$(".select2")
  .select2({
    placeholder: "Pilih",
  })
  .on("select2:opening", function (e) {
    $(this)
      .data("select2")
      .$dropdown.find(":input.select2-search__field")
      .attr("placeholder", "Ketik Data...");
  });

$(document).ready(function () {
  var table = $("#table-dpl").DataTable({
    autoWidth: false,
    responsive: true,
    order: [[1, "desc"]],
    columnDefs: [
      {
        targets: "no-sort",
        orderable: false,
      },
    ],
    stateSave: true,
    serverSide: true,
    processing: true,
    pageLength: 10,
    lengthMenu: [
      [10, 30, 50, 100, -1],
      [10, 30, 50, 100, "All"],
    ],
    ajax: {
      type: "post",
      url: "route.php?mod=dpl&act=datatable",
    },
    drawCallback: function (settings) {
      $("#titleCheck").click(function () {
        var checkedStatus = this.checked;
        $("table tbody tr td div:first-child input[type=checkbox]").each(
          function () {
            this.checked = checkedStatus;
            if (checkedStatus == this.checked) {
              $(this).closest("table tbody tr").removeClass("table-select");
              $(this)
                .closest("table tbody tr")
                .find("input:hidden")
                .attr("disabled", !this.checked);
              $("#totaldata").val(
                $("form input[type=checkbox]:checked").size()
              );
            }
            if (this.checked) {
              $(this).closest("table tbody tr").addClass("table-select");
              $(this)
                .closest("table tbody tr")
                .find("input:hidden")
                .attr("disabled", !this.checked);
              $("#totaldata").val(
                $("form input[type=checkbox]:checked").size()
              );
            }
          }
        );
      });
      $("table tbody tr td div:first-child input[type=checkbox]").on(
        "click",
        function () {
          var checkedStatus = this.checked;
          this.checked = checkedStatus;
          if (checkedStatus == this.checked) {
            $(this).closest("table tbody tr").removeClass("table-select");
            $(this)
              .closest("table tbody tr")
              .find("input:hidden")
              .attr("disabled", !this.checked);
            $("#totaldata").val($("form input[type=checkbox]:checked").size());
          }
          if (this.checked) {
            $(this).closest("table tbody tr").addClass("table-select");
            $(this)
              .closest("table tbody tr")
              .find("input:hidden")
              .attr("disabled", !this.checked);
            $("#totaldata").val($("form input[type=checkbox]:checked").size());
          }
        }
      );
      $("table tbody tr td div:first-child input[type=checkbox]").change(
        function () {
          $(this).closest("tr").toggleClass("table-select", this.checked);
        }
      );
      $(".alertdel").click(function () {
        var id = $(this).attr("id");
        $("#alertdel").modal("show");
        $("#delid").val(id);
      });
      $(".aktifdata").click(function () {
        var id = $(this).attr("id");
        $("#aktifdata").modal("show");
        $("#aktifid").val(id);
      });
      $(".verifikasi").click(function () {
        var id = $(this).attr("id");
        $("#verifkasiberkas").modal("show");
        $("#verifkasiberkasid").val(id);
      });

      $('[data-toggle="tooltip"]').tooltip();
    },
  });
});
