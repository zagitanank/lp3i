(function () {
  ("use strict");

  window.addEventListener(
    "load",
    function () {
      var forms = document.getElementsByClassName("needs-validation");
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add("was-validated");
          },
          false
        );
      });
    },
    false
  );

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

  $("#ValidFormEdit").validate({
    highlight: function (element) {
      $(element)
        .closest(".control-group")
        .removeClass("success")
        .addClass("error");
    },
    success: function (element) {
      element
        .addClass("valid")
        .closest(".control-group")
        .removeClass("error")
        .addClass("success");
    },
    // highlight: function (element) {
    //   $(element).addClass("is-invalid").removeClass("is-valid");
    // },
    // success: function (element) {
    //   element.addClass("is-valid").removeClass("is-invalid");
    // },
    submitHandler: function (form) {
      // form validates so do the ajax
      $.ajax({
        type: $(form).attr("method"),
        url: $(form).attr("action"),
        data: $(form).serialize(),
        beforeSend: function () {
          //We add this before send to disable the button once we submit it so that we prevent the multiple click
          $("#btnSubmit").attr("disabled", true).html("Proses simpan...");
        },
        success: function (data, status) {
          // ajax done
          // do whatever & close the modal
          $("#btnSubmit").attr("disabled", false).html();

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

          $(this).modal("hide");
        },
      });
      return false; // ajax used, block the normal submit
    },
  });

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
