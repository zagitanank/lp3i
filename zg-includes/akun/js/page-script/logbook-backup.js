(function () {
  ("use strict");
  $("#show-hidden-row").DataTable({
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.childRowImmediate,
        type: "",
      },
    },
    info: false,
    ordering: false,
    paging: false,
    dom: '<"toolbar">frtip',
  });

  $("#show-hidden-row").on("click", ".alertdel", function () {
    var id = $(this).attr("id");
    $("#alertdel").modal("show");
    $("#delid").val(id);
  });

  $("#logbook-detail-dosen").DataTable({
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.childRowImmediate,
        type: "",
      },
    },
    dom: '<"toolbar">frtip',
  });

  $("#logbook-dosen").DataTable({
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.childRowImmediate,
        type: "",
      },
    },
  });

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

  $("#btnReset").on("click", function () {
    $('input[type="radio"]').prop("checked", false);
  });

  $("#btnSubmit").on("click", function () {
    if ($("#validationTextarea").val() == "") {
      swal("Error!", "Gagal menyimpan !", "warnings");
    } else {
      // e.preventDefault();
      var $this = $(this); //submit button selector using ID
      var $caption = $this.html(); // We store the html content of the submit button
      var form = "#ValidFormEdit"; //defined the #form ID
      // var formData = $(form).serialize(); //serialize the form into array
      var route = $(form).attr("action"); //get the route using attribute action

      // Ajax config
      // url: "zagi-component/zg-penentuan/proses.php",
      //           type: "POST",
      //           data: $(".zagitanankEdit").serialize(), //serialize() untuk mengambil semua data di dalam form
      //           //dataType: "html",
      //           dataType: "html",
      //           cache: false,
      $.ajax({
        type: "POST", //we are using POST method to submit the data to the server side
        url: route, // get the route value
        data: $(".zagitanankEdit").serialize(), // our serialized array data for server side
        dataType: "html",
        cache: false,
        beforeSend: function () {
          //We add this before send to disable the button once we submit it so that we prevent the multiple click
          $this.attr("disabled", true).html("Proses simpan...");
        },
        success: function (response) {
          $this.attr("disabled", false).html($caption);
          $("#form-penilaian-logbook").modal("hide");
          //swal("Berhasil!", "Respon Tersimpan !", "success");

          // swal("Berhasil", "Respon Tersimpan !", {
          //   buttons: false,
          //   timer: 4000,
          //   className: "alert-light-dark",
          // });

          swal({
            title: "Berhasil!",
            text: "Respon Tersimpan !",
            type: "success",
            showConfirmButton: true,
            timer: 4000,
          }).then(function () {
            window.location.reload();
          });

          // Reset form
          resetForm(form);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          swal("Error!", "Gagal menyimpan !", "warnings");
          setTimeout(2000);
        },
        // success: function (response) {
        //   //once the request successfully process to the server side it will return result here
        //   $this.attr("disabled", false).html($caption);

        //   // Reload lists of employees
        //   // all();

        //   // We will display the result using alert
        //   Swal.fire({
        //     icon: "success",
        //     title: "Success.",
        //     text: response,
        //   });

        //   // Reset form
        //   resetForm(form);
        // },
        // error: function (XMLHttpRequest, textStatus, errorThrown) {
        //   // You can put something here if there is an error from submitted request
        // },
      });
    }
  });

  // $("#ValidFormEdit")
  //   .bootstrapValidator({
  //     excluded: [":disabled"],
  //     feedbackIcons: {
  //       valid: "fa fa-check-circle",
  //       invalid: "fa fa-exclamation-circle",
  //       validating: "fa fa-history",
  //     },
  //   })

  //   .on("success.form.bv", function (e) {
  //     // Prevent form submission
  //     e.preventDefault();

  //     // Get the form instance
  //     var $form = $(e.target);

  //     // Get the BootstrapValidator instance
  //     var bv = $form.data("bootstrapValidator");

  //     swal(
  //       {
  //         title: "Konfirmasi Perbaharui Data",
  //         text: "Data Akan diperbaharui pada Database",
  //         type: "info",
  //         showCancelButton: true,
  //         confirmButtonColor: "#006436",
  //         confirmButtonText: "Ya, Perbaharui!",
  //         cancelButtonColor: "#e5391d",
  //         cancelButtonText: "Batal",
  //         closeOnConfirm: false,
  //         showLoaderOnConfirm: true,
  //       },
  //       function () {
  //         //apabila sweet alert d confirm maka akan mengirim data ke simpan.php melalui proses ajax
  //         $.ajax({
  //           url: "zagi-component/zg-penentuan/proses.php",
  //           type: "POST",
  //           data: $(".zagitanankEdit").serialize(), //serialize() untuk mengambil semua data di dalam form
  //           //dataType: "html",
  //           dataType: "html",
  //           cache: false,
  // success: function (response) {
  //   setTimeout(function () {
  //     swal(
  //       {
  //         title: "Data Berhasil Diperbaharui",
  //         type: "success",
  //       },
  //       function () {
  //         window.location = "admin.php?mod=penentuan";
  //       }
  //     );
  //   }, 1000);
  // },
  // error: function (xhr, ajaxOptions, thrownError) {
  //   setTimeout(function () {
  //     swal("Error", "Tolong Cek Koneksi Lalu Ulangi", "error");
  //   }, 1000);
  // },
  //         });
  //       }
  //     );
  //   });

  // $(".data-attributes span").peity("donut");

  // radial chart js
  function radialCommonOption(data) {
    return {
      series: data.radialYseries,
      chart: {
        height: 130,
        type: "radialBar",
        dropShadow: {
          enabled: true,
          top: 3,
          left: 0,
          blur: 10,
          color: data.dropshadowColor,
          opacity: 0.35,
        },
      },
      plotOptions: {
        radialBar: {
          hollow: {
            size: "60%",
          },
          track: {
            strokeWidth: "60%",
            opacity: 1,
            margin: 5,
          },
          dataLabels: {
            showOn: "always",
            value: {
              color: "var(--body-font-color)",
              fontSize: "14px",
              show: true,
              offsetY: -10,
            },
          },
        },
      },
      colors: data.color,
      stroke: {
        lineCap: "round",
      },
      responsive: [
        {
          breakpoint: 1500,
          options: {
            chart: {
              height: 130,
            },
          },
        },
      ],
    };
  }

  // Statistik Jam Semua
  const radialSemua = {
    color: [warnaRadial],
    dropshadowColor: warnaRadial,
    radialYseries: [nilaiPersen],
  };

  const radialchart = document.querySelector("#jam-semua");
  if (radialchart) {
    var radialprogessChart = new ApexCharts(
      radialchart,
      radialCommonOption(radialSemua)
    );
    radialprogessChart.render();
  }

  // Statistik Jam Minggu ini
  const radialPekan = {
    color: [warnaRadial],
    dropshadowColor: warnaRadial,
    radialYseries: [nilaiPersen],
  };

  const radialchartPekan = document.querySelector("#jam-pekan");
  if (radialchartPekan) {
    var radialprogessChartPekan = new ApexCharts(
      radialchartPekan,
      radialCommonOption(radialPekan)
    );
    radialprogessChartPekan.render();
  }
})(jQuery);

// $(document).on("click", "#btnSubmit", function (e) {
//   var data = $("#zagitanankEdit").serialize();
//   var form = "#ValidFormEdit"; //defined the #form ID
//   var route = $(form).attr("action"); //get the route using attribute action

//   $.ajax({
//     data: data,
//     type: "post",
//     url: route,
//     success: function (dataResult) {
//       var dataResult = JSON.parse(dataResult);
//       if (dataResult.statusCode == 200) {
//         $("#form-penilaian-logbook").modal("hide");
//         swal("Berhasil!", "Respon Tersimpan !", "success");
//         setTimeout(200000);
//         location.reload();
//       } else if (dataResult.statusCode == 201) {
//         //alert(dataResult);
//         swal("Error!", "Gagal menyimpan !", "warnings");
//         setTimeout(2000);
//       }
//     },
//   });
// });
