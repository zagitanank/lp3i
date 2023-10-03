<?php
if (empty($_SESSION['namauser']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
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
    <link rel="shortcut icon" href="../<?= DIR_INC; ?>/images/favicon.png" />
    <link type="text/css" rel="stylesheet" href="../<?= DIR_INC; ?>/css/bootstrap.min.css" />
    <script type="text/javascript" src="../<?= DIR_INC; ?>/js/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../<?= DIR_INC; ?>/js/bootstrap/bootstrap.min.js"></script>
</head>

<div class="row" style="padding: 20px;">

    <div class="col-md-12">
        <center><button class="btn btn-primary" id="tombolExport"><i class="fa fa-file-excel-o"></i> Export Excel</button></center>
        <hr />
        <div class="table-responsive">
            <h4 style="width: 100%; text-align: center; font-weight: bold; line-height: 1px; padding: 10px;"><?= strtoupper('Rekap Pembayaran Registrasi Akun'); ?></h4>
            <h3 style="width: 100%; text-align: center; font-weight: bold; line-height: 1px; padding: 10px;"><?= strtoupper($settings[4]['value']); ?></h3>
            <h4 style="width: 100%; text-align: center; font-weight: bold; line-height: 1px; padding: 10px;">PERIODE <?= $_POST['tahunajaran']; ?></h4>


            <table id="tabelExport" class="table table-bordered table-hover">
                <thead style="width: 100%; ">

                    <tr>
                        <th class="text-center"><strong>NO</strong></th>
                        <th class="text-center"><strong>NO. PENDAFTARAN</strong></th>
                        <th class="text-center"><strong>NAMA CALON MAHASISWA</strong></th>
                        <th class="text-center"><strong>JALUR PENDAFTARAN</strong></th>
                        <th class="text-center"><strong>PRODI TUJUAN</strong></th>
                        <th class="text-center"><strong>GELOMBANG</strong></th>
                        <th class="text-center"><strong>TEMPAT LAHIR</strong></th>
                        <th class="text-center"><strong>TANGGAL LAHIR</strong></th>
                        <th class="text-center"><strong>JENIS KELAMIN</strong></th>
                        <th class="text-center"><strong>AGAMA</strong></th>
                        <th class="text-center"><strong>TELEPON/HP</strong></th>
                        <th class="text-center"><strong>EMAIL</strong></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;
                    if ($_POST['prodi'] == 'all') {
                        $dataPeserta = $laporan->podb->from('peserta')->where('block', 'N')->where('tahun_ajaran', $_POST['tahunajaran'])->orderBy('no_peserta ASC');
                    } else {
                        $dataPeserta = $laporan->podb->from('peserta')->where('block', 'N')->where('pilihan_pertama', $_POST['prodi'])->where('tahun_ajaran', $_POST['tahunajaran'])->orderBy('no_peserta ASC');
                    }
                    foreach ($dataPeserta as $dp) {
                        $jalur = $laporan->podb->from('jalur_pendaftaran')->where('jalur_pendaftaran_id', $dp['jalur_pendaftaran'])->fetch();
                        $prodi = $laporan->podb->from('program_studi')->where('prodiKode', $dp['pilihan_pertama'])->fetch();
                        $agama = $laporan->podb->from('agama')->where('id_agama', $dp['agama_peserta'])->fetch();
                    ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $dp['no_peserta']; ?></td>
                            <td><?= strtoupper($dp['nama_lengkap_peserta']); ?></td>
                            <td><?= strtoupper($jalur['jalur_pendaftaran_nama']); ?></td>
                            <td><?= strtoupper($prodi['prodiNamaSingkat']); ?></td>
                            <td><?= $dp['gelombang_daftar']; ?></td>
                            <td><?= strtoupper($dp['tempat_lahir_peserta_kota']); ?></td>
                            <td><?= $laporan->tanggal_indo($dp['tanggal_lahir_peserta']); ?></td>
                            <td><?= $dp['jenkel_peserta']; ?></td>
                            <td><?= $agama['nama_agama']; ?></td>
                            <td><?= $dp['telp_peserta']; ?></td>
                            <td><?= strtolower($dp['email_peserta']); ?></td>
                        </tr>

                    <?php $no++;
                    } ?>
                </tbody>
            </table>
        </div>
        <center><button class="btn btn-primary" id="tombolExport"><i class="fa fa-file-excel-o"></i> Export Excel</button></center>
    </div>
</div>

<script type="text/javascript" src="../<?= DIR_INC; ?>/js/excel/jquery.base64.js"></script>
<script type="text/javascript" src="../<?= DIR_INC; ?>/js/excel/jquery.btechco.excelexport.js"></script>
<script>
    $(document).ready(function() {
        $("#tombolExport").click(function() {
            $("#tabelExport").btechco_excelexport({
                containerid: "tabelExport",
                datatype: $datatype.Table
            });
        });
    });
</script>
</body>

</html>