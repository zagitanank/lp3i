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
$('.select2').select2({
    placeholder: 'Pilih'
}).on('select2:opening', function(e) {
    $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Ketik Data...')
})

$("#kotasekolah").change(function() { // Ketika user mengganti atau memilih data utama
            document.getElementById("sekolahasal").disabled = true;
            $("#loadingkotasekolah").show(); // Tampilkan loadingnya

            $.ajax({
                type: "POST", // Method pengiriman data bisa dengan GET atau POST
                url: 'route.php?mod=dpl&act=smta', // Isi dengan url/path file php yang dituju
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
            url: 'route.php?mod=dpl&act=prodi',
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

    
	var table = $('#table-dpl').DataTable({
		"autoWidth": false,
		"responsive": true,
		"order": [[1, 'desc']],
		"columnDefs": [{
		  "targets" : 'no-sort',
		  "orderable" : false
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
			'url': 'route.php?mod=dpl&act=datatable'
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
			$('table tbody tr td div:first-child input[type=checkbox]').on('click', function () {
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
			$('.alertdel').click(function(){
				var id = $(this).attr("id");
				$('#alertdel').modal('show');
				$('#delid').val(id);
			});
            $('.aktifdata').click(function(){
				var id = $(this).attr("id");
				$('#aktifdata').modal('show');
				$('#aktifid').val(id);
			});
            $('.verifikasi').click(function(){
				var id = $(this).attr("id");
				$('#verifkasiberkas').modal('show');
				$('#verifkasiberkasid').val(id);
			});
			
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
    
    
});
