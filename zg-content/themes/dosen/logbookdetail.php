<?=$this->layout('index');?>
<?php 
$current_akun = $this->pocore()->call->podb->from('mbkm_peserta')->where('nim', $this->e($nim))->where('periode', $this->e($tahun_akademik))->limit(1)->fetch(); 
$mhs = $this->pocore()->call->podb->from('mahasiswa')->where('nim', $this->e($nim))->limit(1)->fetch(); 
$prodi = $this->pocore()->call->podb->from('prodi')->where('kode_prodi', $mhs['kode_prodi'])->limit(1)->fetch(); 
$kelas = $this->pocore()->call->podb->from('mbkm_dpl_kelas_peserta')->select('dpl_kelas_nama')->leftJoin('mbkm_dpl_kelas ON mbkm_dpl_kelas.id=mbkm_dpl_kelas_peserta.id_kelas_dpl')->where('nim', $mhs['nim'])->where('mbkm_dpl_kelas_peserta.periode_krs', $this->e($tahun_akademik))->limit(1)->fetch(); 
$mbkm_bkp = $this->pocore()->call->podb->from('mbkm_jenis')->where('id', $current_akun['jenis_mbkm'])->limit(1)->fetch(); 
$mbkm_kat = $this->pocore()->call->podb->from('mbkm_kategori')->where('mbkm_kategori_id', $mbkm_bkp['mbkm_kategori'])->limit(1)->fetch(); 
$jnj = explode('-',$prodi['status']);

$awallogbook = $this->pocore()->call->podb->from('mbkm_logbook')
                                          ->select('WEEK(logbook_tanggal_kegiatan) AS awal')
                                          ->where('logbook_nim', $this->e($nim))
                                          ->where('logbook_periode_akademik', $this->e($tahun_akademik))
                                          ->groupBy('awal')
                                          ->orderBy('awal ASC')
                                          ->limit(1)
                                          ->fetch();                        
$pekanberjalan = $this->pocore()->call->podb->from('mbkm_logbook')->select('week(NOW()) AS skrng')->limit(1)->fetch();

$totallog = $pekanberjalan['skrng']-$awallogbook['awal'];

$jamsemua = $this->pocore()->call->podb->from('mbkm_view_logbook')->select("SEC_TO_TIME(SUM(detik)) AS durasi, SUM(detik) as jmldetik")->where('logbook_nim',$this->e($nim))->where('logbook_periode_akademik', $this->e($tahun_akademik))->limit(1)->fetch();
$pisahTime = explode(':',$jamsemua['durasi']);

//KOnversi Jam ke Detik
// 840 Jam = 3,024,000 Detik
$jammbkm = $this->pocore()->call->posetting[18]['value'];
$totaldetik = $jammbkm*3600;
$persentasi=round($jamsemua['jmldetik']/$totaldetik * 100,0);
?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Detail Log Book</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL?>/dosen">
                                <svg class="stroke-icon">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Assesment</li>
                        <li class="breadcrumb-item">Log Book</li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid p-b-30">

        <div class="edit-profile">
            <div class="row">

                <div class="pb-2">
                    <a href="<?= BASE_URL?>/dosen/logbook"
                        class="btn btn-pill btn-outline-secondary-2x btn-air-secondary btn-sm"><i
                            class="fa fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>

                <div class="col-xl-4">
                    <div class="card ">

                        <div class="social-profile">
                            <div class="card-body">
                                <div class="social-img-wrap">
                                    <div class="social-img">
                                        <?php if(empty($mhs['file'])){?>
                                        <img class="img-70" alt="foto"
                                            src="<?=BASE_URL?>/<?=DIR_INC?>/images/noimage.jpg">
                                        <?php }else{ ?>
                                        <img class="img-70" alt="foto"
                                            src="<?=URL_SIAKA?>/mahasiswa/<?=$mhs['file']?>.jpg">
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="social-details">
                                    <span class="f-light d-block"><?=strtoupper($mhs['nim']);?>
                                    </span>
                                    <h5 class="mt-1"><?=strtoupper($mhs['nama']);?></h5>
                                    <!-- <ul class="social-follow">
                                                            <li>
                                                                <h5 class="mb-0">1,908</h5><span
                                                                    class="f-light">Posts</span>
                                                            </li>
                                                            <li>
                                                                <h5 class="mb-0">34.0k</h5><span
                                                                    class="f-light">Followers</span>
                                                            </li>
                                                            <li>
                                                                <h5 class="mb-0">897</h5><span
                                                                    class="f-light">Following</span>
                                                            </li>
                                                        </ul> -->
                                </div>
                            </div>
                        </div>


                        <div class="card-body pt-2">
                            <ul class="lessons-lists">
                                <li>
                                    <div>
                                        <h6 class="f-14 f-w-400 mb-0">
                                            <?=strtoupper($mbkm_kat['mbkm_kategori_nama']);?>
                                        </h6><strong
                                            class="f-light"><?=strtoupper($mbkm_bkp['mbkm_jenis_nama']);?></strong>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h6 class="f-14 f-w-400 mb-0">
                                            PROGRAM STUDI
                                        </h6><strong class="f-light"><?=strtoupper($prodi['nama_prodi']);?></strong>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h6 class="f-14 f-w-400 mb-0">
                                            KELAS
                                        </h6><strong class="f-light"><?=strtoupper($kelas['dpl_kelas_nama']);?></strong>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card height-equal radial-height">
                        <div class="card-body radial-progress-card">
                            <div>
                                <h6 class="mb-0">Total Jam Keseluruhan</h6>
                                <div class="sale-details">
                                    <h5 class="font-primary mb-0">
                                        <?=$pisahTime['0'] ?> Jam <?=$pisahTime['1'] ?> Menit
                                    </h5>
                                </div>
                                <p class="f-light"> Target MBKM <?=$jammbkm?> Jam</p>
                            </div>
                            <script>
                            var warnaRadial = '#FF3364';
                            var nilaiPersen = '<?=$persentasi?>';
                            </script>
                            <div class="radial-chart-wrap">
                                <div id="jam-semua"> </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="live-dark pb-2">
                                <div class="alert alert-light-dark light alert-dismissible fade show text-dark border-left-wrapper"
                                    role="alert"><i class="icon-info-alt"></i>
                                    <p>Harap mengingatkan Mahasiswa, jika tidak mengisi Log Book!</p>
                                </div>
                            </div>
                            <div class="dt-ext">
                                <table class="display" id="logbook-detail-dosen">
                                    <thead>
                                        <tr>
                                            <th>Pekan</th>
                                            <th>Jml. Logbook</th>
                                            <th>Status</th>
                                            <th>Penilaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($awallogbook['awal'] > 0){
                                        $minggu = 1;
                                        for($nom=$awallogbook['awal']; $nom <= $pekanberjalan['skrng']; $nom++){
                                        $isian = $this->pocore()->call->podb->from('mbkm_view_logbook')->where('pekan', $nom)->where('logbook_nim', $this->e($nim))->where('logbook_periode_akademik', $this->e($tahun_akademik))->count();
                                        $cekstatus = $this->pocore()->call->podb->from('mbkm_logbook_penilaian')->where('logbook_penilaian_pekan', $nom)->where('logbook_penilaian_nim', $this->e($nim))->where('logbook_penilaian_periode_krs', $this->e($tahun_akademik))->count();
                                        
                                        ?>
                                        <tr>
                                            <td>Pekan <?=$minggu;?></td>
                                            <td><?=$isian?> Isian</td>
                                            <td>
                                                <?php
                                                if($isian > 0){
                                                    if($cekstatus > 0){
                                                        $classbtn = 'success';
                                                        $textbtn  = 'Tinjau';
                                                        $iconbtn  = 'fa-search';
                                                        echo '<span class="badge badge-success">Telah dinilai</span>';
                                                    }else{
                                                        $classbtn = 'info';
                                                        $textbtn  = 'Tentukan';
                                                        $iconbtn  = 'fa-check-square-o';
                                                        echo '<span class="badge badge-info">Belum dinilai</span>';
                                                    }
                                                }else{
                                                    echo '<i class="text-danger" data-feather="x"></i>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if($isian > 0){ ?>
                                                <a href="<?=BASE_URL?>/dosen/logbook/nilai/<?=$this->pocore()->call->encrypt($this->e($nim));?>/<?=$nom?>/<?=$minggu?>"
                                                    class="btn btn-pill btn-outline-<?=$classbtn?>-2x btn-sm"
                                                    type="button" title="Nilai">
                                                    <?=$textbtn?> <i class="fa <?=$iconbtn?>"></i>
                                                </a>
                                                <?php }else{ ?>
                                                <i class="text-danger" data-feather="x"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php $minggu++;} }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>