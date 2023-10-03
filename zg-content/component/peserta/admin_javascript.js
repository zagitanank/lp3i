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
$('.select2').select2({
    placeholder: 'Pilih'
}).on('select2:opening', function(e) {
    $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Ketik Data...')
})

$('#universitas').typeahead({
    source: function (query, process) {
        return $.ajax({
            url:"route.php?mod=registrasi&act=universitas",
            type: 'post',
            data: { cari: query },
            dataType: 'json',
            success: function (result) {

                var resultList = result.map(function (item) {
                    var aItem = { id: item.iduniv, name: item.universitas };
                    return JSON.stringify(aItem);
                });

                return process(resultList);

            }
        });
    },

    matcher: function (obj) {
        var item = JSON.parse(obj);
        return item.name.toLowerCase().indexOf(this.query.toLowerCase())
    },

    sorter: function (items) {          
       var beginswith = [], caseSensitive = [], caseInsensitive = [], item;
        while (aItem = items.shift()) {
            var item = JSON.parse(aItem);
            if (!item.name.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(JSON.stringify(item));
            else if (item.name.indexOf(this.query)) caseSensitive.push(JSON.stringify(item));
            else caseInsensitive.push(JSON.stringify(item));
        }

        return beginswith.concat(caseSensitive, caseInsensitive)

    },


    highlighter: function (obj) {
        var item = JSON.parse(obj);
        var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
        return item.name.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
            return '<strong>' + match + '</strong>'
        })
    },

    updater: function (obj) {
        var item = JSON.parse(obj);
        $('#iduniv').attr('value', item.id);
        $('#universitas').attr('value', item.universitas);
        return item.name;
    }
}); 

$(document).ready(function() {
    var table = $('#table-peserta').DataTable({
        "autoWidth": false,
        "responsive": true,
        "order": [
            [1, 'desc']
        ],
        "columnDefs": [{
            "targets": 'no-sort',
            "orderable": false
        }],
        "stateSave": true,
        "serverSide": true,
        "processing": true,
        "pageLength": 10,
        "lengthMenu": [
            [10, 30, 50, 100, -1],
            [10, 30, 50, 100, "All"]
        ],
        "ajax": {
            'type': 'post',
            'url': 'route.php?mod=peserta&act=datatable'
        },
        "drawCallback": function(settings) {
            $("#titleCheck").click(function() {
                var checkedStatus = this.checked;
                $("table tbody tr td div:first-child input[type=checkbox]").each(function() {
                    this.checked = checkedStatus;
                    if (checkedStatus == this.checked) {
                        $(this).closest('table tbody tr').removeClass('table-select');
                        $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                        $('#totaldata').val($('form input[type=checkbox]:checked').size());
                    }
                    if (this.checked) {
                        $(this).closest('table tbody tr').addClass('table-select');
                        $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                        $('#totaldata').val($('form input[type=checkbox]:checked').size());
                    }
                });
            });
            $('table tbody tr td div:first-child input[type=checkbox]').on('click', function() {
                var checkedStatus = this.checked;
                this.checked = checkedStatus;
                if (checkedStatus == this.checked) {
                    $(this).closest('table tbody tr').removeClass('table-select');
                    $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                    $('#totaldata').val($('form input[type=checkbox]:checked').size());
                }
                if (this.checked) {
                    $(this).closest('table tbody tr').addClass('table-select');
                    $(this).closest('table tbody tr').find('input:hidden').attr('disabled', !this.checked);
                    $('#totaldata').val($('form input[type=checkbox]:checked').size());
                }
            });
            $('table tbody tr td div:first-child input[type=checkbox]').change(function() {
                $(this).closest('tr').toggleClass("table-select", this.checked);
            });
            $('.alertdel').click(function() {
                var id = $(this).attr("id");
                $('#alertdel').modal('show');
                $('#delid').val(id);
            });

            $('.penilaianwawancara').click(function() {
                var id = $(this).attr("id");
                $('#penilaianwawancara').modal('show');
                $('#pesertaid').val(id);
            });
            
            $('.resethasiltpa').click(function(){
				var id = $(this).attr("id");
				$('#resettpa').modal('show');
				$('#tpaid').val(id);
			});


            $('[data-toggle="tooltip"]').tooltip();
        }
    });
});

/*
window.onload = function() {
    $("#tabel_prestasi_akademik").hide();
    $("#ukuranlainnya").hide();
}
*/
$("#kotasekolah").change(function() { // Ketika user mengganti atau memilih data utama
            document.getElementById("sekolahasal").disabled = true;
            $("#loadingkotasekolah").show(); // Tampilkan loadingnya

            $.ajax({
                type: "POST", // Method pengiriman data bisa dengan GET atau POST
                url: 'route.php?mod=registrasi&act=smta', // Isi dengan url/path file php yang dituju
                data: {
                    kota_id: $("#kotasekolah").val()
                }, // data yang akan dikirim ke file yang dituju
                dataType: "json",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) { // Ketika proses pengiriman berhasil
                    $("#loadingkotasekolah").hide(); // Sembunyikan loadingnya
                    // set isi dari combobox sub
                    // lalu munculkan kembali combobox subnya

                    document.getElementById("sekolahasal").disabled = false;
                    $("#sekolahasal").html(response.data_smta).show();
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(thrownError); // Munculkan alert error
                }
            });
        });
$('#jenjang').change(function() {
    var jenjang = $(this).val();
    if (jenjang) {
        $.ajax({
            type: 'POST',
            url: 'route.php?mod=peserta&act=prodi',
            data: 'jenjang_id=' + jenjang,
            success: function(html) {
                $('#proditujuan').html(html);
            }
        });
    } else {
        $('#proditujuan').html('<option value="">Pilih Jenjang Dahulu</option>');
    }
});

$('#jenjang').change(function() {
    if (this.value == '3') {
        $("#menukampus").show();
        $("#menusekolah").hide();
    } else {
        $("#menusekolah").show();
        $("#menukampus").hide();
    }
});

$(document).ready(function() {

    var valuejenjang = $('#jenjang').val();
    if (valuejenjang == '3') {
        $("#menukampus").show();
        $("#menusekolah").hide();
    } else {
        $("#menusekolah").show();
        $("#menukampus").hide();
    }

    $('#passwordForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            'newpassword': {
                message: 'Password baru tidak valid',
                validators: {
                    notEmpty: {
                        message: 'Harus diisi'
                    },
                    stringLength: {
                        min: 6,
                        max: 15,
                        message: 'Panjang password 6 sampai 15'
                    }
                }
            },
            renewpassword: {
                validators: {
                    identical: {
                        field: 'newpassword',
                        message: 'Password tidak sama'
                    }
                }
            }
        }
    });
});