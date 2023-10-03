<?=$this->layout('index');?>
<?php 
$current_akun = $this->pocore()->call->podb->from('mbkm_peserta')->where('nim', $_SESSION['namauser_member'])->where('periode', $this->e($tahun_akademik))->limit(1)->fetch(); 
$mhs = $this->pocore()->call->podb->from('mahasiswa')->where('nim', $_SESSION['namauser_member'])->limit(1)->fetch(); 
$prodi = $this->pocore()->call->podb->from('prodi')->where('kode_prodi', $mhs['kode_prodi'])->limit(1)->fetch(); 
$kelas = $this->pocore()->call->podb->from('mbkm_dpl_kelas_peserta')->select('dpl_kelas_nama')->leftJoin('mbkm_dpl_kelas ON mbkm_dpl_kelas.id=mbkm_dpl_kelas_peserta.id_kelas_dpl')->where('nim', $mhs['nim'])->where('mbkm_dpl_kelas_peserta.periode_krs', $this->e($tahun_akademik))->limit(1)->fetch(); 
$mbkm_bkp = $this->pocore()->call->podb->from('mbkm_jenis')->where('id', $current_akun['jenis_mbkm'])->limit(1)->fetch(); 
$mbkm_kat = $this->pocore()->call->podb->from('mbkm_kategori')->where('mbkm_kategori_id', $mbkm_bkp['mbkm_kategori'])->limit(1)->fetch(); 
$jnj = explode('-',$prodi['status']);

$awallogbook = $this->pocore()->call->podb->from('mbkm_logbook')
                                          ->select('WEEK(logbook_tanggal_kegiatan) AS awal')
                                          ->where('logbook_nim', $_SESSION['namauser_member'])
                                          ->where('logbook_periode_akademik', $this->e($tahun_akademik))
                                          ->groupBy('awal')
                                          ->orderBy('awal ASC')
                                          ->limit(1)
                                          ->fetch();                        
$pekanberjalan = $this->pocore()->call->podb->from('mbkm_logbook')->select('week(NOW()) AS skrng')->limit(1)->fetch();

$totallog = $pekanberjalan['skrng']-$awallogbook['awal'];

$jamsemua = $this->pocore()->call->podb->from('mbkm_view_logbook')->select("SEC_TO_TIME(SUM(detik)) AS durasi, SUM(detik) as jmldetik")->where('logbook_nim',$_SESSION['namauser_member'])->where('logbook_periode_akademik', $this->e($tahun_akademik))->limit(1)->fetch();
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
                    <h4>Penilaian Mingguan DPL</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL?>/mahasiswa">
                                <svg class="stroke-icon">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Assesment</li>
                        <li class="breadcrumb-item">Penilaian Mingguan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid p-b-30">

        <div class="edit-profile">
            <div class="row g-sm-3 widget-charts p-b-10">


                <div class="col-sm-3">
                    <div class="card small-widget mb-sm-0">
                        <div class="card-body secondary"><span class="f-light">Jumlah Semua Logbook</span>
                            <div class="d-flex align-items-end gap-1">
                                <h4><?= $this->pocore()->call->podb->from('mbkm_view_logbook')
                                        ->where('logbook_nim', $_SESSION['namauser_member'])
                                        ->where('logbook_periode_akademik', $this->e($tahun_akademik))->count(); ?>
                                </h4><span class="font-secondary f-12 f-w-500"><span>Data</span></span>
                            </div>
                            <div class="bg-gradient">
                                <svg class="stroke-icon svg-fill">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/svg/icon-sprite.svg#rate">
                                    </use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card small-widget mb-sm-0">
                        <div class="card-body secondary"><span class="f-light">Total Jam MBKM Anda</span>
                            <div class="d-flex align-items-end gap-1">
                                <h4><?php 
                                        $jamsemua = $this->pocore()->call->podb->from('mbkm_view_logbook')->select("SEC_TO_TIME(SUM(detik)) AS durasi, SUM(detik) as jmldetik")->where('logbook_nim',$_SESSION['namauser_member'])->where('logbook_periode_akademik', $this->e($tahun_akademik))->limit(1)->fetch();
                                        $pisahTime = explode(':',$jamsemua['durasi']);

                                        if(!empty($jamsemua['durasi'])){
                                            echo $pisahTime['0'].' Jam : '.$pisahTime['1'].' Menit';
                                        }else{
                                            echo '0 Jam : 0 Menit';
                                        }
                                        ?>
                                </h4>
                            </div>
                            <div class="bg-gradient">
                                <i class="font-secondary" data-feather="watch"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card small-widget mb-sm-0">
                        <div class="card-body primary"><span class="f-light">Jumlah Logbook Pekan ini</span>
                            <div class="d-flex align-items-end gap-1">
                                <h4><?=  $this->pocore()->call->podb->from('mbkm_view_logbook_minggu_ini')
                                        ->where('logbook_nim', $_SESSION['namauser_member'])
                                        ->where('logbook_periode_akademik', $this->e($tahun_akademik))->count(); ?>
                                </h4>
                                <span class="font-primary f-12 f-w-500"><span>Data</span></span>
                            </div>
                            <div class="bg-gradient">
                                <svg class="stroke-icon svg-fill">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/svg/icon-sprite.svg#customers">
                                    </use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-3">
                    <div class="card small-widget mb-sm-0">
                        <div class="card-body primary"> <span class="f-light">Total Jam MBKM Pekan Ini</span>
                            <div class="d-flex align-items-end gap-1">
                                <h4><?php 
                                        $jampekan = $this->pocore()->call->podb->from('mbkm_view_jam_mbkm_pekan_ini')->where('logbook_nim',$_SESSION['namauser_member'])->where('logbook_periode_akademik', $this->e($tahun_akademik))->limit(1)->fetch();
                                        
                                        if(!empty($jampekan['durasi'])){
                                            $pisahTimePekan = explode(':',$jampekan['durasi']);
                                            echo $pisahTimePekan['0'].' Jam : '.$pisahTimePekan['1'].' Menit';
                                        }else{
                                            echo '0 Jam : 0 Menit';
                                        }
                                        
                                        ?>
                                </h4></span>
                            </div>
                            <div class="bg-gradient">
                                <svg class="stroke-icon svg-fill">
                                    <use
                                        href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/svg/icon-sprite.svg#stroke-calendar">
                                    </use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext">
                                <table class="display" id="logbook-nilai">
                                    <thead>
                                        <tr>
                                            <th>Pekan</th>
                                            <th>Jumlah Logbook</th>
                                            <th>Jumlah Jam</th>
                                            <th>Status</th>
                                            <th>Penilaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        // $valuePekan = array();

                                        // for($nom=$awallogbook['awal']; $nom <= $pekanberjalan['skrng']; $nom++){
                                        //     $valuePekan[] = $nom;
                                        // }
                                        // $valuePekan = max($valuePekan);
                                        // //var_dump($valuePekan);
                                        // $res = 0;
                                        // for($count = 0; $count < count($valuePekan); $count++){
                                        //     if($res < $valuePekan[$count]){
                                        //         echo $res = $valuePekan[$count].'<br>';
                                        //     }
                                                
                                        // }

                                        if($awallogbook['awal'] > 0){
                                        $minggu = 1;
                                        for($nom=$awallogbook['awal']; $nom <= $pekanberjalan['skrng']; $nom++){
                                        $isian = $this->pocore()->call->podb->from('mbkm_view_logbook')->where('pekan', $nom)->where('logbook_nim', $_SESSION['namauser_member'])->where('logbook_periode_akademik', $this->e($tahun_akademik))->count();
                                        $cekstatus = $this->pocore()->call->podb->from('mbkm_logbook_penilaian')->where('logbook_penilaian_pekan', $nom)->where('logbook_penilaian_nim', $_SESSION['namauser_member'])->where('logbook_penilaian_periode_krs', $this->e($tahun_akademik))->count();
                                        
                                        $jamsemua = $this->pocore()->call->podb->from('mbkm_view_logbook')->select("SEC_TO_TIME(SUM(detik)) AS durasi, SUM(detik) as jmldetik")->where('pekan', $nom)->where('logbook_nim',$_SESSION['namauser_member'])->where('logbook_periode_akademik', $this->e($tahun_akademik))->limit(1)->fetch();
                                        $pisahTime = explode(':',$jamsemua['durasi']);

                                        if(!empty($jamsemua['durasi'])){
                                            $jam_mbkm = $pisahTime['0'].' Jam : '.$pisahTime['1'].' Menit';
                                        }else{
                                            $jam_mbkm = '<i class="text-danger" data-feather="x"></i>';
                                        }
                                    

                                        ?>
                                        <tr>
                                            <td>Pekan <?=$minggu;?></td>
                                            <td><?=$isian?> Isian</td>
                                            <td><?=$jam_mbkm?></td>
                                            <td>
                                                <?php
                                                if($isian > 0){
                                                    if($cekstatus > 0){
                                                        echo '<span class="badge badge-success">Telah dinilai</span>';
                                                    }else{
                                                        echo '<span class="badge badge-danger">Belum dinilai</span>';
                                                    }
                                                }else{
                                                    echo '<i class="text-danger" data-feather="x"></i>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if($isian > 0){ 
                                                    
                                                        if($cekstatus > 0){
                                                ?>
                                                <a class="btn btn-pill btn-outline-primary-2x btn-sm" type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target=".form-penilaian-logbook<?=$nom?>" title="Nilai">
                                                    Tinjau <i class="fa fa-arrow-right"></i>
                                                </a>
                                                <div class="modal fade form-penilaian-logbook<?=$nom?>" tabindex="-1"
                                                    role="dialog" aria-labelledby="myFormAssesment" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myFormAssesment">
                                                                    Respon DPL Pekan <?=$minggu?></h4>
                                                                <button class="btn-close py-0" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body dark-modal">
                                                                <div class="notification chats-user">
                                                                    <div class="card-body pt-10">

                                                                        <ul class="border-0">
                                                                            <?php 
                                                        $query_nilai = $this->pocore()->call->podb->from('mbkm_logbook_penilaian')
                                                                ->select('mbkm_rubrik_pertanyaan.rubrik_pertanyaan_judul,mbkm_rubrik_pertanyaan.rubrik_pertanyaan_type,mbkm_rubrik_pertanyaan.rubrik_pertanyaan_nomor,mbkm_logbook_penilaian.rubrik_jawaban_id, mbkm_rubrik_jawaban.rubrik_jawaban_judul, mbkm_rubrik_jawaban.rubrik_jawaban_bobot')
                                                                ->leftJoin('mbkm_rubrik_pertanyaan on mbkm_rubrik_pertanyaan.rubrik_pertanyaan_id=mbkm_logbook_penilaian.rubrik_pertanyaan_id')
                                                                ->leftJoin('mbkm_rubrik_jawaban on mbkm_rubrik_jawaban.rubrik_jawaban_id=mbkm_logbook_penilaian.rubrik_jawaban_id')
                                                                ->where('`logbook_penilaian_nim`', $_SESSION['namauser_member'])
                                                                ->where('`logbook_penilaian_pekan`', $nom)
                                                                ->where('`logbook_penilaian_periode_krs`', $this->e($tahun_akademik))
                                                                ->where('`rubrik_pertanyaan_type`', '1')
                                                                ->orderBy('rubrik_pertanyaan_id ASC')
                                                                ->fetchAll();
                                                        foreach($query_nilai as $qn){

                                                            if($qn['rubrik_jawaban_bobot'] == 1){
                                                                $bobot = '<span class="badge bg-danger">Mulai berkembang</span>';
                                                                $colordot= 'danger';
                                                            }elseif($qn['rubrik_jawaban_bobot'] == 2){
                                                                $bobot = '<span class="badge bg-warning">Berkembang</span>';
                                                                $colordot= 'warning';
                                                            }elseif($qn['rubrik_jawaban_bobot'] == 3){
                                                                $bobot = '<span class="badge bg-info">Cakap</span>';
                                                                $colordot= 'info';
                                                            }elseif($qn['rubrik_jawaban_bobot'] == 4){
                                                                $bobot = '<span class="badge bg-primary">Sangat cakap</span>';
                                                                $colordot= 'primary';
                                                            }elseif($qn['rubrik_jawaban_bobot'] == 5){
                                                                $bobot = '<span class="badge bg-success">Mahir</span>';
                                                                $colordot= 'success';
                                                            }
                                                        ?>
                                                                            <li class="d-flex border-bottom-0 p-0">
                                                                                <div
                                                                                    class="activity-dot-<?=$colordot?>">
                                                                                </div>
                                                                                <div class="w-100 ms-3">
                                                                                    <p
                                                                                        class="d-flex justify-content-between mb-2">
                                                                                        <span
                                                                                            class="date-content light-background">Rubrik
                                                                                            No.
                                                                                            <?=$qn['rubrik_pertanyaan_nomor']?>
                                                                                        </span><span><?=$bobot?></span>
                                                                                    </p>
                                                                                    <h6><?=$qn['rubrik_pertanyaan_judul']?>
                                                                                    </h6>
                                                                                    <p class="f-light">
                                                                                        <?=$qn['rubrik_jawaban_judul']?>
                                                                                    </p>
                                                                                </div>
                                                                            </li>
                                                                            <?php } ?>

                                                                            <?php 
                                                                $query_nilai_es = $this->pocore()->call->podb->from('mbkm_logbook_penilaian')
                                                                        ->select('mbkm_rubrik_pertanyaan.rubrik_pertanyaan_judul,mbkm_rubrik_pertanyaan.rubrik_pertanyaan_type,mbkm_rubrik_pertanyaan.rubrik_pertanyaan_nomor,mbkm_logbook_penilaian.rubrik_jawaban_id')
                                                                        ->leftJoin('mbkm_rubrik_pertanyaan on mbkm_rubrik_pertanyaan.rubrik_pertanyaan_id=mbkm_logbook_penilaian.rubrik_pertanyaan_id')
                                                                        ->where('`logbook_penilaian_nim`', $_SESSION['namauser_member'])
                                                                        ->where('`logbook_penilaian_pekan`', $nom)
                                                                        ->where('`logbook_penilaian_periode_krs`', $this->e($tahun_akademik))
                                                                        ->where('`rubrik_pertanyaan_type`', '2')
                                                                        ->orderBy('rubrik_pertanyaan_id ASC')
                                                                        ->fetchAll();
                                                                foreach($query_nilai_es as $qne){
                                                            ?>

                                                                            <li class="d-flex border-bottom-0 p-0">
                                                                                <div class="activity-dot-primary"></div>
                                                                                <div class="w-100 ms-3">
                                                                                    <p
                                                                                        class="d-flex justify-content-between mb-2">
                                                                                        <span
                                                                                            class="date-content light-background">Rubrik
                                                                                            No.
                                                                                            <?=$qne['rubrik_pertanyaan_nomor']?>
                                                                                        </span>
                                                                                    </p>
                                                                                    <h6><?=$qne['rubrik_pertanyaan_judul']?>
                                                                                    </h6>
                                                                                    <p class="f-light"
                                                                                        style="text-align:justify">
                                                                                        <?=$qne['rubrik_jawaban_id']?>
                                                                                    </p>
                                                                                </div>
                                                                            </li>
                                                                            <?php } ?>

                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">

                                                                <button class="btn btn-secondary" type="button"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="fa fa-sign-out"></i>
                                                                    Tutup</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }else{ ?>

                                                <i class="text-danger" data-feather="x"></i>
                                                <?php } ?>

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
</div>