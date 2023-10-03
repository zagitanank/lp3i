<?php 
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']) AND $_SESSION['login'] == 0) {
	header('location:index.php');
	exit;
}

include_once '../zg-includes/core/config.php';
include_once '../zg-includes/core/core.php';

$laporan = new PoCore();
$settings = $laporan->podb->from('setting')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laporan </title>
    <link rel="shortcut icon" href="../<?=DIR_INC;?>/images/favicon.png" />
	<link type="text/css" rel="stylesheet" href="../<?=DIR_INC;?>/css/bootstrap.min.css" />
    <script type="text/javascript" src="../<?=DIR_INC;?>/js/jquery/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="../<?=DIR_INC;?>/js/bootstrap/bootstrap.min.js"></script>
</head>

<div class="row" style="padding: 20px;" >
            <div class="col-md-12">
                <center><button class="btn btn-primary" id="tombolExport"><i class="fa fa-file-excel-o"></i> Export Excel</button></center>
            <hr />
                <div class="table-responsive">
                    <h4 style="width: 100%; text-align: center; font-weight: bold; line-height: 1px; padding: 10px;">DAFTAR WAWANCARA CALON MABA</h4>
                    <h3 style="width: 100%; text-align: center; font-weight: bold; line-height: 1px; padding: 10px;"><?=strtoupper($settings[4]['value']);?></h3>
                    <h4 style="width: 100%; text-align: center; font-weight: bold; line-height: 1px; padding: 10px;">PERIODE <?=$_POST['tahunajaran'];?></h4>


<table id="tabelExport"  class="table table-bordered table-hover">
<thead style="width: 100%; ">

    <tr>
        <th class="text-center"><strong>NO</strong></th>
        <th class="text-center"><strong>NO. PESERTA</strong></th>
        <th class="text-center"><strong>NAMA LENGKAP</strong></th>
        <th class="text-center"><strong>PRODI TUJUAN</strong></th>
        <th class="text-center"><strong>WAWANCARA VIA</strong></th>
        <th class="text-center"><strong>NO. WHATSAPP</strong></th>
        <th class="text-center"><strong>NO. PONSEL</strong></th>
        <th class="text-center"><strong>EMAIL</strong></th>
        <th class="text-center"><strong>TGL. WAWANCARA</strong></th>
    </tr>
</thead>

<tbody>
<?php
    $no = 1;
    if($_POST['prodi']=='all'){
         if(empty($_POST['mulai'])){
             $dataWawancara = $laporan->podb->from('wawancara')
                                  ->where('jadwal_sudah', 'N')
                                  ->groupBy('id_peserta')
                                  ->orderBy('jadwal_tanggal ASC');
         }else{
             $dataWawancara = $laporan->podb->from('wawancara')
                                  ->where('(jadwal_tanggal BETWEEN "'.$_POST['mulai'].'" AND "'.$_POST['selesai'].'") ')
                                  ->where('jadwal_sudah', 'N')
                                  ->groupBy('id_peserta')
                                  ->orderBy('jadwal_tanggal ASC');
         }
         
    }else{
        $dataWawancara = $laporan->podb->from('wawancara')
                                  ->where('(jadwal_tanggal BETWEEN "'.$_POST['mulai'].'" AND "'.$_POST['selesai'].'") ')
                                  ->where('jadwal_sudah', 'N')
                                  ->where('pilihan_pertama LIKE $_POST[prodi]')
                                  ->groupBy('id_peserta')
                                  ->orderBy('jadwal_tanggal ASC');
    }
    
    foreach($dataWawancara as $dw){
        $peserta = $laporan->podb->from('peserta')->where('id_peserta', $dw['id_peserta'])->fetch();
        $prodi   = $laporan->podb->from('program_studi')->where('prodiKode', $peserta['pilihan_pertama'])->fetch();
        $timestamp = strtotime($dw['jadwal_tanggal']);
        $hari    = date('D', $timestamp);
?>
    <tr>
        <td><?=$no;?></td>
        <td><?=$peserta['no_peserta'];?></td>
        <td><?=ucwords(strtolower($peserta['nama_lengkap_peserta']));?></td>
        <td><?=$prodi['prodiNamaSingkat'];?></td>
        <td><?=$dw['wawancara_via'];?></td>
        <td><?=$peserta['no_wa_peserta'];?></td>
        <td><?=$peserta['telp_peserta'];?></td>
        <td><?=$peserta['email_peserta'];?></td>
        <td><center><?=$laporan->getHari($hari);?>/<?=$laporan->tanggal_indo2($dw['jadwal_tanggal']);?></center></td>
        
    </tr>

<?php $no++; } ?>
</tbody>
</table>

    </div>
    <center><button class="btn btn-primary" id="tombolExport"><i class="fa fa-file-excel-o"></i> Export Excel</button></center>
    </div>
</div>
    
    <script type="text/javascript" src="../<?=DIR_INC;?>/js/excel/jquery.base64.js"></script>
    <script type="text/javascript" src="../<?=DIR_INC;?>/js/excel/jquery.btechco.excelexport.js"></script>
	<script>
            $(document).ready(function () {
                $("#tombolExport").click(function () {
                    $("#tabelExport").btechco_excelexport({
                        containerid: "tabelExport"
                       , datatype: $datatype.Table
                    });
                });
            });
	</script>
</body>

</html>