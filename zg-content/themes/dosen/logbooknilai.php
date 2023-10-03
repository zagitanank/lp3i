<?=$this->layout('index');?>
<?php 
$current_akun = $this->pocore()->call->podb->from('mbkm_peserta')->where('nim', $this->e($nim))->where('periode', $this->e($tahun_akademik))->limit(1)->fetch(); 
$mhs = $this->pocore()->call->podb->from('mahasiswa')->where('nim', $this->e($nim))->limit(1)->fetch(); 
$prodi = $this->pocore()->call->podb->from('prodi')->where('kode_prodi', $mhs['kode_prodi'])->limit(1)->fetch(); 
$kelas = $this->pocore()->call->podb->from('mbkm_dpl_kelas_peserta')
                                    ->select('dpl_kelas_nama, mbkm_dpl_kelas.id')
                                    ->leftJoin('mbkm_dpl_kelas ON mbkm_dpl_kelas.id=mbkm_dpl_kelas_peserta.id_kelas_dpl')
                                    ->where('nim', $mhs['nim'])
                                    ->where('mbkm_dpl_kelas_peserta.periode_krs', $this->e($tahun_akademik))
                                    ->limit(1)
                                    ->fetch(); 
$mbkm_bkp = $this->pocore()->call->podb->from('mbkm_jenis')->where('id', $current_akun['jenis_mbkm'])->limit(1)->fetch(); 
$mbkm_kat = $this->pocore()->call->podb->from('mbkm_kategori')->where('mbkm_kategori_id', $mbkm_bkp['mbkm_kategori'])->limit(1)->fetch(); 
$jnj = explode('-',$prodi['status']);
$cekrespon = $this->pocore()->call->podb->from('mbkm_logbook_penilaian')->where('`logbook_penilaian_pekan`', $this->e($pekan))
                                                                        ->where('logbook_penilaian_nim', $this->e($nim))
                                                                        ->where('logbook_penilaian_periode_krs', $this->e($tahun_akademik))
                                                                        ->count();
if($cekrespon == 0){
    $jenisinput = 'add';
    $tombolform = 'Simpan';
    $styl = 'style="height:0"';
}else{
    $jenisinput = 'edit';
    $tombolform = 'Perbaharui';
    $styl = '';
}



$jamsemua = $this->pocore()->call->podb->from('mbkm_view_logbook')->select("SEC_TO_TIME(SUM(detik)) AS durasi, SUM(detik) as jmldetik")->where('logbook_nim',$this->e($nim))->where('logbook_periode_akademik', $this->e($tahun_akademik))->where('`pekan`', $this->e($pekan))->limit(1)->fetch();
$pisahTime = explode(':',$jamsemua['durasi']);

//KOnversi Jam ke Detik
// 840 Jam = 3,024,000 Detik
$totaldetik = 3024000;
$persentasi=round($jamsemua['jmldetik']/$totaldetik * 100,0);
?>
<div class="page-body pb-5">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Penilaian Log Book Pekan <?=$this->e($minggu)?></h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL?>/dosen">
                                <svg class="stroke-icon">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Assesment</li>
                        <li class="breadcrumb-item">Log Book</li>
                        <li class="breadcrumb-item active">Penilaian Log Book</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid m-b-20">

        <div class="edit-profile">
            <div class="row">


                <div class="col-md-12">


                    <div class="card bg-transparent shadow-none">

                        <div class="row shopping-wizard">
                            <div class="col-12">
                                <div class="pb-2">
                                    <a href="<?= BASE_URL?>/dosen/logbook/detail/<?=$this->pocore()->call->encrypt($this->e($nim))?>"
                                        class="btn btn-pill btn-outline-secondary-2x btn-air-secondary btn-sm"><i
                                            class="fa fa-arrow-left"></i>
                                        Kembali
                                    </a>
                                </div>
                                <div class="row shipping-form g-5">
                                    <div class="col-xl-4 shipping-border">

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
                                                            </h6><strong
                                                                class="f-light"><?=strtoupper($prodi['nama_prodi']);?></strong>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <h6 class="f-14 f-w-400 mb-0">
                                                                KELAS
                                                            </h6><strong
                                                                class="f-light"><?=strtoupper($kelas['dpl_kelas_nama']);?></strong>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="card">
                                            
                                            <div class="card-header">
                                                <div class="header-top">
                                                    <h5 class="m-0">Penilaian</h5>
                                                    <div class="card-header-right-icon">
                                                        <button class="btn btn-pill btn-dark btn-air-info btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target=".form-penilaian-logbook"><i
                                                                class="fa fa-list-ol"></i>
                                                            Respon Anda
                                                        </button>


                                                        <div class="modal fade form-penilaian-logbook" tabindex="-1"
                                                            role="dialog" aria-labelledby="myFormAssesment"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myFormAssesment">
                                                                            Form Assesment</h4>
                                                                        <button class="btn-close py-0" type="button"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body dark-modal">
                                                                        <div class="live-dark pb-2">
                                                                            <div class="alert alert-dark dark"
                                                                                role="alert">
                                                                                <i class="icon-info-alt"></i>
                                                                                <i>
                                                                                    <b>Catatan:</b>
                                                                                </i>
                                                                                <p>
                                                                                    <b>- Harap melakukan
                                                                                        penilaian
                                                                                        berdasarkan log book
                                                                                        Mahasiswa
                                                                                        pada Pekan ini.</b><br>
                                                                                    <b>- Berikut merupakan
                                                                                        parameter
                                                                                        penilaian
                                                                                        Capaian
                                                                                        Mahasiswa.</b><br>

                                                                                <div class="flex-grow-1 ms-2"> A
                                                                                    (mulai
                                                                                    berkembang): Mahasiswa
                                                                                    menunjukkan
                                                                                    pemahaman awal dan kemampuan
                                                                                    dasar
                                                                                    dalam indikator yang diberikan.
                                                                                    <br>
                                                                                    B
                                                                                    (berkembang):
                                                                                    Mahasiswa
                                                                                    menunjukkan perkembangan
                                                                                    yang
                                                                                    baik
                                                                                    dan kemampuan yang memadai
                                                                                    dalam
                                                                                    indikator yang diberikan.
                                                                                    <br>C (cakap):
                                                                                    Mahasiswa menunjukkan
                                                                                    kemahiran
                                                                                    yang
                                                                                    cukup baik dan konsisten
                                                                                    dalam
                                                                                    indikator yang diberikan.
                                                                                    <br>D (sangat
                                                                                    cakap): Mahasiswa
                                                                                    menunjukkan
                                                                                    kemahiran yang sangat baik
                                                                                    dan
                                                                                    konsisten dalam indikator
                                                                                    yang
                                                                                    diberikan.
                                                                                    <br>E (mahir): Mahasiswa
                                                                                    menunjukkan keunggulan dalam
                                                                                    kemampuan dan prestasi yang
                                                                                    sangat
                                                                                    baik dalam indikator yang
                                                                                    diberikan.
                                                                                </div>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <form method="post" id="ValidFormEdit"
                                                                            needs-validation custom-input"
                                                                            action="<?=BASE_URL?>/dosen/logbook/nilai/<?=$this->pocore()->call->encrypt($this->e($nim));?>/<?=$this->e($pekan)?>/<?=$this->e($minggu)?>"
                                                                            class="form-horizontal zagitanankEdit"
                                                                            role="form" novalidate="">
                                                                            <input type='hidden' name="minggu"
                                                                                value="<?=$this->e($pekan)?>">
                                                                            <input type='hidden' name="kelas"
                                                                                value="<?=$kelas['id']?>">
                                                                            <input type='hidden' name="jenis"
                                                                                value="<?=$jenisinput;?>">
                                                                            <?php 
                                                                                            $nomor=1;
                                                                                            $query_data = $this->pocore()->call->podb->from('mbkm_rubrik_pertanyaan')
                                                                                                    ->where('`rubrik_pertanyaan_aktif`', 'Y')
                                                                                                    ->orderBy('rubrik_pertanyaan_nomor ASC')
                                                                                                    ->fetchAll();
                                                                                            foreach($query_data as $ql){

                                                                                                if($ql['rubrik_pertanyaan_type'] == 2){
                                                                                                    $wajib= '<span class="text-danger">*</span>';
                                                                                                }else{
                                                                                                    $wajib='';
                                                                                                }
                                                                            ?>

                                                                            <div class="d-flex mt-3">
                                                                                <div class="flex-shrink-0">
                                                                                    <?= $nomor++; ?></div>
                                                                                <div class="flex-grow-1 ms-2">
                                                                                    <strong><?= $ql['rubrik_pertanyaan_judul']; ?>
                                                                                        <?=$wajib?>
                                                                                    </strong>
                                                                                    <input type="hidden"
                                                                                        name="<?= "pertanyaan_" . $ql['rubrik_pertanyaan_id']; ?>"
                                                                                        value="<?= $ql['rubrik_pertanyaan_id']; ?>" />

                                                                                    <?php if($ql['rubrik_pertanyaan_type'] == 1){ ?>
                                                                                    <?php
                                                                                    $query_jwb = $this->pocore()->call->podb->from('mbkm_rubrik_jawaban')
                                                                                                                            ->where('`rubrik_pertanyaan_id`', $ql['rubrik_pertanyaan_id'])
                                                                                                                            ->where('`rubrik_jawaban_aktif`', 'Y')
                                                                                                                            ->orderBy('rubrik_jawaban_bobot ASC')
                                                                                                                            ->fetchAll();
                                                                                    foreach($query_jwb as $qj){
                                                                                    
                                                                                        if($qj['rubrik_jawaban_bobot'] == 1){
                                                                                            $label_nilai = 'A';
                                                                                        }elseif($qj['rubrik_jawaban_bobot'] == 2){
                                                                                            $label_nilai = 'B';
                                                                                        }elseif($qj['rubrik_jawaban_bobot'] == 3){
                                                                                            $label_nilai = 'C';
                                                                                        }elseif($qj['rubrik_jawaban_bobot'] == 4){
                                                                                            $label_nilai = 'D';
                                                                                        }elseif($qj['rubrik_jawaban_bobot'] == 5){
                                                                                            $label_nilai = 'E';
                                                                                        }
                                                                                        
                                                                                    ?>
                                                                                    <div
                                                                                        class="form-check radio radio-secondary">
                                                                                        <?php 
                                                                                            $cekinputan = $this->pocore()->call->podb->from('mbkm_logbook_penilaian')
                                                                                                                                     ->select('rubrik_jawaban_id')
                                                                                                                                     ->where('logbook_penilaian_pekan', $this->e($pekan))
                                                                                                                                     ->where('logbook_penilaian_nim', $this->e($nim))
                                                                                                                                     ->where('logbook_penilaian_periode_krs', $this->e($tahun_akademik))
                                                                                                                                     ->where('rubrik_pertanyaan_id', $ql['rubrik_pertanyaan_id'])
                                                                                                                                     ->where('rubrik_jawaban_id', $qj['rubrik_jawaban_id'])
                                                                                                                                     ->limit(1)->fetch(); 
                                                                                            if($cekinputan['rubrik_jawaban_id'] == $qj['rubrik_jawaban_id']){
                                                                                                $checked_jwb = 'checked';
                                                                                            }else{
                                                                                                $checked_jwb = '';
                                                                                            }
                                                                                        ?>

                                                                                        <input class="form-check-input"
                                                                                            id="jawaban_<?=$ql['rubrik_pertanyaan_id'];?>_<?=$qj['rubrik_jawaban_id'];?>"
                                                                                            type="radio"
                                                                                            name="jawaban_<?=$ql['rubrik_pertanyaan_id'];?>"
                                                                                            <?=$checked_jwb?>
                                                                                            value="<?=$qj['rubrik_jawaban_id'];?>">
                                                                                        <label class="form-check-label"
                                                                                            for="jawaban_<?=$ql['rubrik_pertanyaan_id'];?>_<?=$qj['rubrik_jawaban_id'];?>">

                                                                                            <?=$label_nilai?>.
                                                                                            <?=$qj['rubrik_jawaban_judul']?>
                                                                                        </label>
                                                                                    </div>
                                                                                    <?php } ?>
                                                                                    <?php }else{ 
                                                                                        
                                                                                        $cekinputanes = $this->pocore()->call->podb->from('mbkm_logbook_penilaian')
                                                                                                                                     ->select('rubrik_jawaban_id')
                                                                                                                                     ->where('logbook_penilaian_pekan', $this->e($pekan))
                                                                                                                                     ->where('logbook_penilaian_nim', $this->e($nim))
                                                                                                                                     ->where('logbook_penilaian_periode_krs', $this->e($tahun_akademik))
                                                                                                                                     ->where('rubrik_pertanyaan_id', $ql['rubrik_pertanyaan_id'])
                                                                                                                                     ->limit(1)->fetch(); 
                                                                                        ?>
                                                                                    <textarea
                                                                                        class="form-control input-air-primary"
                                                                                        id="validationTextarea" rows="3"
                                                                                        style="height: 100px;"
                                                                                        name="jawaban_<?=$ql['rubrik_pertanyaan_id'];?>"
                                                                                        required=""><?=$cekinputanes['rubrik_jawaban_id'];?></textarea>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php } ?>
                                                                            <div class="modal-footer">

                                                                                <button class="btn btn-primary"
                                                                                    type="submit" id="btnSubmit"><i
                                                                                        class="fa fa-floppy-o"></i>
                                                                                    <?=$tombolform?></button>

                                                                                <button
                                                                                    class="btn btn-warning text-dark"
                                                                                    id="btnReset"><i
                                                                                        class="fa fa-refresh"></i>
                                                                                    Reset</button>
                                                                                <button class="btn btn-secondary"
                                                                                    type="button"
                                                                                    data-bs-dismiss="modal"><i
                                                                                        class="fa fa-sign-out"></i>
                                                                                    Batal</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="left-sidebar-wrapper p-0 b-r-0 border-0">
                                                <div class="advance-options">


                                                    <div class="notification chats-user" <?=$styl;?>>
                                                        <div class="card-body pt-10">
                                                            <?php if($cekrespon == 0){
                                                        echo"<span class='text-danger'>Data Respon Belum Ada</span>";
                                                    }
                                                    ?> <ul class="border-0">
                                                                <?php 
                                                        $query_nilai = $this->pocore()->call->podb->from('mbkm_logbook_penilaian')
                                                                ->select('mbkm_rubrik_pertanyaan.rubrik_pertanyaan_judul,mbkm_rubrik_pertanyaan.rubrik_pertanyaan_type,mbkm_rubrik_pertanyaan.rubrik_pertanyaan_nomor,mbkm_logbook_penilaian.rubrik_jawaban_id, mbkm_rubrik_jawaban.rubrik_jawaban_judul, mbkm_rubrik_jawaban.rubrik_jawaban_bobot')
                                                                ->leftJoin('mbkm_rubrik_pertanyaan on mbkm_rubrik_pertanyaan.rubrik_pertanyaan_id=mbkm_logbook_penilaian.rubrik_pertanyaan_id')
                                                                ->leftJoin('mbkm_rubrik_jawaban on mbkm_rubrik_jawaban.rubrik_jawaban_id=mbkm_logbook_penilaian.rubrik_jawaban_id')
                                                                ->where('`logbook_penilaian_nim`', $mhs['nim'])
                                                                ->where('`logbook_penilaian_pekan`', $this->e($pekan))
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
                                                                    <div class="activity-dot-<?=$colordot?>"></div>
                                                                    <div class="w-100 ms-3">
                                                                        <p class="d-flex justify-content-between mb-2">
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
                                                                        ->where('`logbook_penilaian_nim`', $mhs['nim'])
                                                                        ->where('`logbook_penilaian_pekan`', $this->e($pekan))
                                                                        ->where('`logbook_penilaian_periode_krs`', $this->e($tahun_akademik))
                                                                        ->where('`rubrik_pertanyaan_type`', '2')
                                                                        ->orderBy('rubrik_pertanyaan_id ASC')
                                                                        ->fetchAll();
                                                                foreach($query_nilai_es as $qne){
                                                            ?>

                                                                <li class="d-flex border-bottom-0 p-0">
                                                                    <div class="activity-dot-primary"></div>
                                                                    <div class="w-100 ms-3">
                                                                        <p class="d-flex justify-content-between mb-2">
                                                                            <span
                                                                                class="date-content light-background">Rubrik
                                                                                No.
                                                                                <?=$qne['rubrik_pertanyaan_nomor']?>
                                                                            </span>
                                                                        </p>
                                                                        <h6><?=$qne['rubrik_pertanyaan_judul']?>
                                                                        </h6>
                                                                        <p class="f-light" style="text-align:justify">
                                                                            <?=$qne['rubrik_jawaban_id']?>
                                                                        </p>
                                                                    </div>
                                                                </li>
                                                                <?php } ?>

                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card small-widget mb-sm-0">
                                            <div class="card-body success"> <span class="f-light">Jam MBKM Pekan
                                                    ini</span>
                                                <div class="d-flex align-items-end gap-1">
                                                    <h4><?=$pisahTime['0'] ?> Jam <?=$pisahTime['1'] ?> Menit</h4>
                                                </div>
                                                <div class="bg-gradient">
                                                    <svg class="stroke-icon svg-fill">
                                                        <use
                                                            href="<?=BASE_URL;?>/<?=DIR_INC?>/akun/svg/icon-sprite.svg#rate">
                                                        </use>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-xl-8">
                                        <div class="card">
                                            <div class="row product-page-main">
                                                <div class="live-dark pb-2">
                                                    <div class="alert alert-light-dark light alert-dismissible fade show text-dark border-left-wrapper"
                                                        role="alert"><i class="icon-info-alt"></i>
                                                        <p>Klik tanggal di bawah, untuk
                                                            melihat Log Book.
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <ul class="nav nav-tabs border-tab nav-primary mb-2" id="top-tab"
                                                        role="tablist">

                                                        <?php
                                                            $no =1;
                                                            $datalogbook = $this->pocore()->call->podb->from('mbkm_view_logbook')
                                                                        ->where('logbook_nim', $this->e($nim))
                                                                        ->where('logbook_periode_akademik', $this->e($tahun_akademik))
                                                                        ->where('pekan', $this->e($pekan))
                                                                        ->fetchAll();   
                                                            foreach($datalogbook as $row){
                                                        ?>

                                                        <li class="nav-item" role="presentation"><a
                                                                class="nav-link <?php if($no == 1){echo 'active';}?>"
                                                                id="tab-<?=$no?>" data-bs-toggle="tab"
                                                                href="#top-<?=$no?>" role="tab"
                                                                aria-controls="top-<?=$no?>"
                                                                aria-selected="true"><?= $this->pocore()->call->tanggal_indo($row['logbook_tanggal_kegiatan'])?></a>
                                                            <div class="material-border"></div>
                                                        </li>
                                                        <?php $no++;} ?>
                                                    </ul>
                                                    <div class="tab-content" id="top-tabContent">

                                                        <?php
                                                        $no2 =1;
                                                        $datalogbook2 = $this->pocore()->call->podb->from('mbkm_view_logbook')
                                                                        ->where('logbook_nim', $this->e($nim))
                                                                        ->where('logbook_periode_akademik', $this->e($tahun_akademik))
                                                                        ->where('pekan', $this->e($pekan))
                                                                        ->fetchAll();   
                                                            foreach($datalogbook2 as $row2){
                                                        ?>

                                                        <div class="tab-pane fade <?php if($no2 == 1){echo 'active show';}?>"
                                                            id="top-<?=$no2?>" role="tabpanel"
                                                            aria-labelledby="tab-<?=$no2?>">
                                                            <table class="table ">
                                                                <tbody>

                                                                    <tr>
                                                                        <td>Tanggal Kegiatan</td>
                                                                        <td><?= $this->pocore()->call->tanggal_indo($row2['logbook_tanggal_kegiatan'])?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Jam Kegiatan</td>
                                                                        <td><?= $row2['logbook_jam_kerja_awal']?>
                                                                            s/d
                                                                            <?= $row2['logbook_jam_kerja_akhir']?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Durasi Kegiatan</td>
                                                                        <?php
                                                                            $durasi = explode(':',$row2['total_jam']);
                                                                        ?>
                                                                        <td><?= $durasi['0']?> Jam
                                                                            <?= $durasi['1']?>
                                                                            Menit
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <p class="f-light"></p>
                                                            <div class="default-according style-1 faq-accordion"
                                                                id="accordionoc">
                                                                <div class="card">
                                                                    <!--Accordion header-->

                                                                    <div class="card-body">
                                                                        <label class="form-label"><strong>
                                                                                Kegiatan Mahasiswa
                                                                                merujuk pada capaian
                                                                                pembelajaran:</strong>
                                                                        </label>
                                                                        <p style="text-align: justify;">
                                                                            <?=$row2['logbook_deskripsi_kegiatan_1']?>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="card">
                                                                    <!--Accordion header-->

                                                                    <div class="card-body">
                                                                        <label class="form-label"><strong>
                                                                                Target pencapaian
                                                                                kegiatan
                                                                                Mahasiswa:</strong>
                                                                        </label>
                                                                        <p style="text-align: justify;">
                                                                            <?=$row2['logbook_deskripsi_kegiatan_2']?>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="card">
                                                                    <!--Accordion header-->

                                                                    <div class="card-body">
                                                                        <label class="form-label"><strong>
                                                                                Refleksi keseluruhan
                                                                                aktivitas
                                                                                Mahasiswa:</strong>
                                                                        </label>
                                                                        <p style="text-align: justify;">
                                                                            <?=$row2['logbook_deskripsi_kegiatan_3']?>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <label class="form-label">
                                                                <strong>Bukti Dokumentasi:</strong>
                                                            </label>

                                                            <div class="row g-3 my-gallery gallery p-b-20"
                                                                id="aniimated-thumbnials">

                                                                <div class="col-xl-4 col-md-12 custom-alert text-center">
                                                                    <?php
                                                                        //$urlfile1 = BASE_URL.'/'.DIR_CON.'/logbook/';
                                                                        if(empty($row2['logbook_deskripsi_kegiatan_foto_1'])){
                                                                            $dokfile1 ='no_image.jpg';
                                                                            
                                                                        }else{
                                                                            $dokfile1 = $row2['logbook_deskripsi_kegiatan_foto_1'];
                                                                        }
                                                                        ?>
                                                                    <div class="card-wrapper border rounded-3 bg-white">
                                                                        <div class="cuba-demo-img">
                                                                            <ul class="dot-group pb-3 pt-0">
                                                                                <li></li>
                                                                                <li></li>
                                                                                <li></li>
                                                                            </ul>
                                                                            <div
                                                                                class="title-wrapper pb-3 modal-heading">
                                                                                <h5 class="theme-name mb-0">
                                                                                    <span>Dokumentasi
                                                                                        1</span>
                                                                                </h5>
                                                                            </div>
                                                                            <div class="overflow-hidden">
                                                                                <figure class="img-hover hover-1"
                                                                                    itemprop="associatedMedia"
                                                                                    itemscope="">
                                                                                    <a href="<?=BASE_URL.'/'.DIR_CON?>/logbook/<?=$dokfile1?>"
                                                                                        itemprop="contentUrl"
                                                                                        data-size="1600x950">
                                                                                        <img src="<?=BASE_URL.'/'.DIR_CON?>/logbook/<?=$dokfile1?>"
                                                                                            itemprop="thumbnail"
                                                                                            alt="Image description"
                                                                                            class="img-fluid img-100 img-h-100">
                                                                                    </a>
                                                                                    <figcaption
                                                                                        itemprop="caption description">
                                                                                        Bukti
                                                                                        dokumentasi
                                                                                        1
                                                                                    </figcaption>
                                                                                </figure>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-xl-4 col-md-12 custom-alert text-center">
                                                                    <?php
                                                        //$urlfile1 = BASE_URL.'/'.DIR_CON.'/logbook/';
                                                        if(empty($row2['logbook_deskripsi_kegiatan_foto_2'])){
                                                            $dokfile2 ='no_image.jpg';
                                                            
                                                        }else{
                                                            $dokfile2 = $row2['logbook_deskripsi_kegiatan_foto_2'];
                                                        }
                                                        ?>
                                                                    <div
                                                                        class="card-wrapper border rounded-3   bg-white">
                                                                        <div class="cuba-demo-img">
                                                                            <ul class="dot-group pb-3 pt-0">
                                                                                <li></li>
                                                                                <li></li>
                                                                                <li></li>
                                                                            </ul>
                                                                            <div
                                                                                class="title-wrapper pb-3 modal-heading">
                                                                                <h5 class="theme-name mb-0">
                                                                                    <span>Dokumentasi
                                                                                        2</span>
                                                                                </h5>
                                                                            </div>
                                                                            <div class="overflow-hidden">
                                                                                <figure class="img-hover hover-1"
                                                                                    itemprop="associatedMedia"
                                                                                    itemscope="">
                                                                                    <a href="<?=BASE_URL.'/'.DIR_CON?>/logbook/<?=$dokfile2?>"
                                                                                        itemprop="contentUrl"
                                                                                        data-size="1600x950">
                                                                                        <img src="<?=BASE_URL.'/'.DIR_CON?>/logbook/<?=$dokfile2?>"
                                                                                            itemprop="thumbnail"
                                                                                            alt="Image description"
                                                                                            class="img-fluid img-100 img-h-100">
                                                                                    </a>
                                                                                </figure>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-xl-4 col-md-12 custom-alert text-center">
                                                                    <?php
                                                        //$urlfile1 = BASE_URL.'/'.DIR_CON.'/logbook/';
                                                        if(empty($row2['logbook_deskripsi_kegiatan_foto_3'])){
                                                            $dokfile3 ='no_image.jpg';
                                                            
                                                        }else{
                                                            $dokfile3 = $row2['logbook_deskripsi_kegiatan_foto_3'];
                                                        }
                                                        ?>
                                                                    <div
                                                                        class="card-wrapper border rounded-3  bg-white">
                                                                        <div class="cuba-demo-img">
                                                                            <ul class="dot-group pb-3 pt-0">
                                                                                <li></li>
                                                                                <li></li>
                                                                                <li></li>
                                                                            </ul>
                                                                            <div
                                                                                class="title-wrapper pb-3 modal-heading">
                                                                                <h5 class="theme-name mb-0">
                                                                                    <span>Dokumentasi
                                                                                        3</span>
                                                                                </h5>
                                                                            </div>
                                                                            <div class="overflow-hidden">
                                                                                <figure class="img-hover hover-1"
                                                                                    itemprop="associatedMedia"
                                                                                    itemscope="">
                                                                                    <a href="<?=BASE_URL.'/'.DIR_CON?>/logbook/<?=$dokfile3?>"
                                                                                        itemprop="contentUrl"
                                                                                        data-size="1600x950">
                                                                                        <img src="<?=BASE_URL.'/'.DIR_CON?>/logbook/<?=$dokfile3?>"
                                                                                            itemprop="thumbnail"
                                                                                            alt="Image description"
                                                                                            class="img-fluid img-100 img-h-100">
                                                                                    </a>
                                                                                </figure>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $no2++;} ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Root element of PhotoSwipe. Must have class pswp.-->
                            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                                <!--
              Background of PhotoSwipe.
              It's a separate element, as animating opacity is faster than rgba().
              -->
                                <div class="pswp__bg"></div>
                                <!-- Slides wrapper with overflow:hidden.-->
                                <div class="pswp__scroll-wrap">
                                    <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory.-->
                                    <!-- don't modify these 3 pswp__item elements, data is added later on.-->
                                    <div class="pswp__container">
                                        <div class="pswp__item"></div>
                                        <div class="pswp__item"></div>
                                        <div class="pswp__item"></div>
                                    </div>
                                    <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed.-->
                                    <div class="pswp__ui pswp__ui--hidden">
                                        <div class="pswp__top-bar">
                                            <!-- Controls are self-explanatory. Order can be changed.-->
                                            <div class="pswp__counter"></div>
                                            <button class="pswp__button pswp__button--close"
                                                title="Close (Esc)"></button>
                                            <button class="pswp__button pswp__button--share" title="Share"></button>
                                            <button class="pswp__button pswp__button--fs"
                                                title="Toggle fullscreen"></button>
                                            <button class="pswp__button pswp__button--zoom"
                                                title="Zoom in/out"></button>
                                            <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR-->
                                            <!-- element will get class pswp__preloader--active when preloader is running-->
                                            <div class="pswp__preloader">
                                                <div class="pswp__preloader__icn">
                                                    <div class="pswp__preloader__cut">
                                                        <div class="pswp__preloader__donut">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                            <div class="pswp__share-tooltip"></div>
                                        </div>
                                        <button class="pswp__button pswp__button--arrow--left"
                                            title="Previous (arrow left)"></button>
                                        <button class="pswp__button pswp__button--arrow--right"
                                            title="Next (arrow right)"></button>
                                        <div class="pswp__caption">
                                            <div class="pswp__caption__center"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
        </div>
    </div>

</div>

<script>
var warnaRadial = '';
var nilaiPersen = ';'
</script>