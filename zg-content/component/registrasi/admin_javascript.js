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
 * Ini adalah file utama javascript Zagitanank yang memuat semua javascript di peserta.
 * This is a main javascript file from Zagitanank which contains all javascript in peserta.
 *
 */
//Initialize Select2 Elements

$(document).ready(function () {
  var table = $("#table-peserta").DataTable({
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
      url: "route.php?mod=peserta&act=datatable",
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

      $('[data-toggle="tooltip"]').tooltip();
    },
  });
});

function ceknim() {
  nim = $("#nim").val();

  $("#btnProses").attr("disabled", true);
  $("#btnProses").html(
    '<i class="fa fa-spin fa-spinner mr-2"></i> Proses Pencarian'
  );

  $.ajax({
    type: "GET",
    url: "https://siakad.polteklp3imks.ac.id/api/getmhsbynim.php",
    data: "nim=" + nim,
    dataType: "json",
    beforeSend: function () {},
    success: function (response) {
      if (response.kode == 200) {
        $("#nama").val(response.nama);
        $("#nim").val(response.nim);
        $("#prodi").val(response.nmprodi);
        $("#kdprodi").val(response.kdprodi);
      } else if (response.kode == 404) {
        alert("data tidak ditemukan");
      }
    },
  });
}

/* For jquery.chained.js */
$("#bkp").chained("#kategori");

$(".hapuskrs").click(function () {
  var id = $(this).attr("id");
  var periode = $(this).attr("periode");
  $("#alertdelkrs").modal("show");
  $("#delidkrs").val(id);
  $("#periodekrs").val(periode);
});
