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
            <h4 style="width: 100%; text-align: center; font-weight: bold; line-height: 1px; padding: 10px;">DAFTAR PERKEMBANGAN CALON MAHASISWA BARU</h4>
            <h3 style="width: 100%; text-align: center; font-weight: bold; line-height: 1px; padding: 10px;"><?= strtoupper($settings[4]['value']); ?></h3>
            <h4 style="width: 100%; text-align: center; font-weight: bold; line-height: 1px; padding: 10px;">PERIODE <?= $_POST['tahunajaran']; ?></h4>


            <table id="tabelExport" class="table table-bordered table-hover">
                <thead style="width: 100%; ">

                    <tr>
                        <th class="text-center"><strong>NO</strong></th>
                        <th class="text-center"><strong>PROGRAM STUDI</strong></th>
                        <th class="text-center"><strong>JUMLAH PENDAFTAR</strong></th>
                        <th class="text-center"><strong>JUMLAH TES TPA</strong></th>
                        <th class="text-center"><strong>JUMLAH TES WAWANCARA</strong></th>
                        <th class="text-center"><strong>JUMLAH LULUS</strong></th>
                        <th class="text-center"><strong>JUMLAH BAYAR DAFTAR ULANG</strong></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;
                    $dataPeserta = $laporan->podb->from('program_studi')->orderBy('jenjang_studi_id ASC');
                    foreach ($dataPeserta as $dp) {
                        $jmlpeserta = $laporan->podb->from('peserta')->where('tahun_ajaran', $_POST['tahunajaran'])->where('block', 'N')->where('pilihan_pertama', $dp['prodiKode'])->count();
                    ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $dp['prodiNamaSingkat']; ?></td>
                            <td class="text-center"><?= $jmlpeserta; ?></td>
                            <?php
                            $utbk = $laporan->podb->from('peserta')->where('tahun_ajaran', $_POST['tahunajaran'])->where('block', 'N')->where('pilihan_pertama', $dp['prodiKode'])->where('jalur_pendaftaran', '4')->count();
                            $osc  = $laporan->podb->from('peserta')->where('tahun_ajaran', $_POST['tahunajaran'])->where('block', 'N')->where('pilihan_pertama', $dp['prodiKode'])->where('jalur_pendaftaran', '3')->count();
                            $tes  = $laporan->podb->from('tpa_mengerjakan')->leftJoin('peserta ON peserta.id_peserta = tpa_mengerjakan.id_peserta')
                                ->where('peserta.tahun_ajaran', $_POST['tahunajaran'])
                                ->where('peserta.pilihan_pertama', $dp['prodiKode'])
                                ->where('peserta.block', 'N')
                                ->where('peserta.jalur_pendaftaran', '1')
                                ->count();
                            $totaltpa = $utbk + $osc + $tes;
                            ?>
                            <td class="text-center"><?= $totaltpa; ?></td>
                            <?php
                            $teswawancara  = $laporan->podb->from('wawancara')->leftJoin('peserta ON peserta.id_peserta = wawancara.id_peserta')
                                ->where('peserta.tahun_ajaran', $_POST['tahunajaran'])
                                ->where('peserta.pilihan_pertama', $dp['prodiKode'])
                                ->where('peserta.block', 'N')
                                ->where('wawancara.jadwal_sudah', 'Y')
                                ->count();

                            ?>

                            <td class="text-center"><?= $teswawancara; ?></td>
                            <?php
                            $lulus = $laporan->podb->from('peserta')->where('tahun_ajaran', $_POST['tahunajaran'])->where('block', 'N')->where('pilihan_pertama', $dp['prodiKode'])->where('status_seleksi', 'Lulus')->count();
                            ?>
                            <td class="text-center"><?= $lulus ?></td>
                            <?php
                            $bayarDU = $laporan->podb->from('peserta')->where('pilihan_pertama', $dp['prodiKode'])->where('tahun_ajaran', $_POST['tahunajaran'])->where('bayar_daftarulang', 'Y')->count();
                            ?>
                            <td class="text-center"><?=  $bayarDU ?></td>
                        </tr>
                        
                    <?php 
                    $totalPendaftar +=$jmlpeserta;
                    $totalTesTpa +=$totaltpa;
                    $totalWawancara +=$teswawancara;
                    $totalLulus +=$lulus;
                    $totalBayarDU +=$bayarDU;
                    $no++;
                    } ?>
                    <tr>
                        <td class="text-right" colspan="2"><strong>TOTAL</strong></td>
                        <td class="text-center"><strong><?=$totalPendaftar;?></strong></td>
                        <td class="text-center"><strong><?=$totalTesTpa;?></strong></td>
                        <td class="text-center"><strong><?=$totalWawancara;?></strong></td>
                        <td class="text-center"><strong><?=$totalLulus;?></strong></td>
                        <td class="text-center"><strong><?=$totalBayarDU;?></strong></td>
                    </tr>
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