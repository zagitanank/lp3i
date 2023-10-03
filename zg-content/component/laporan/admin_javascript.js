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

$("#mulai").prop('disabled', true);
$("#selesai").prop('disabled', true);
$(document).ready(function() {
	$('#mulai').datetimepicker({
		format: 'YYYY-MM-DD',
		showTodayButton: true,
		showClear: true
	});
    
    $('#selesai').datetimepicker({
		format: 'YYYY-MM-DD',
		showTodayButton: true,
		showClear: true
	});


	$("#mulai").mask("9999/99/99");
    $("#selesai").mask("9999/99/99");
    
    
});

$('#laporan').change(function() {
    if (this.value == '5') {
        $("#mulai").prop('disabled', false);
        $("#selesai").prop('disabled', false);
    }else{
        $("#mulai").prop('disabled', true);
        $("#selesai").prop('disabled', true);
    }
});