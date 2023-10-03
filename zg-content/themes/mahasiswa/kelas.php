<?=$this->layout('index');?>
<?php
$dosen = $this->pocore()->call->podb->from('dosen')->where('kode_nama',$kelas['kode_dosen'])->limit(1)->fetch(); 
$glrdpn = "";
$nmm = $dosen['nama'];
$glrblk = "";
if ($dosen['gelar_depan'] != "") $glrdpn .= $dosen['gelar_depan'] . ' ';
if ($dosen['gelar_belakang'] != "") $glrblk .= ', ' . $dosen['gelar_belakang'];
$namalengkap = $glrdpn . $nmm . $glrblk;

$mbkm_bkp = $this->pocore()->call->podb->from('mbkm_jenis')->where('id', $kelas['jenis_mbkm'])->limit(1)->fetch(); 
$mbkm_kat = $this->pocore()->call->podb->from('mbkm_kategori')->where('mbkm_kategori_id', $mbkm_bkp['mbkm_kategori'])->limit(1)->fetch();
?>
<div class="page-body p-b-50">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Kelas Anda</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL?>/dosen">
                                <svg class="stroke-icon">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Kelas</li>
                        <li class="breadcrumb-item active">Kelas Anda </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-5 col-ed-6 col-xl-8 box-col-7">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card o-hidden welcome-card">
                            <div class="card-body">
                                <h4 class="mb-3 mt-1 f-w-500 mb-0 f-22">
                                    Nama Kelas : <span
                                        class="badge badge-primary btn-hover-effect"><?=$kelas['dpl_kelas_nama']?></span>
                                </h4>
                                <p>
                                    <span class="btn btn-warning text-dark">Periode Akademik
                                        <?=$this->pocore()->call->Convert_periode_totext($this->e($tahun_akademik));?>
                                    </span>
                                </p>
                            </div>
                            <img class="welcome-img" src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/svg/widget.svg"
                                alt="search image">
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xxl-6 col-ed-6 col-xl-8 box-col-7">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card course-box">
                            <div class="card-body">
                                <div class="course-widget">
                                    <div class="course-icon">
                                        <svg class="fill-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/svg/icon-sprite.svg#course-1">
                                            </use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">Kategori MBKM</h4>
                                        <p class="f-light">Diprogramkan saat ini :</p>
                                        <span><?=strtoupper($mbkm_kat['mbkm_kategori_nama']);?></span>
                                    </div>
                                </div>
                            </div>
                            <ul class="square-group">
                                <li class="square-1 warning"></li>
                                <li class="square-1 primary"></li>
                                <li class="square-2 warning1"></li>
                                <li class="square-3 danger"></li>
                                <li class="square-4 light"></li>
                                <li class="square-5 warning"></li>
                                <li class="square-6 success"></li>
                                <li class="square-7 success"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card course-box">
                            <div class="card-body">
                                <div class="course-widget">
                                    <div class="course-icon warning">
                                        <svg class="fill-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/svg/icon-sprite.svg#course-2">
                                            </use>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">BKP</h4>
                                        <p class="f-light">Diprogramkan saat ini :</p>
                                        <span><?=strtoupper($mbkm_bkp['mbkm_jenis_nama']);?></span>
                                    </div>
                                </div>
                            </div>
                            <ul class="square-group">
                                <li class="square-1 warning"></li>
                                <li class="square-1 primary"></li>
                                <li class="square-2 warning1"></li>
                                <li class="square-3 danger"></li>
                                <li class="square-4 light"></li>
                                <li class="square-5 warning"></li>
                                <li class="square-6 success"></li>
                                <li class="square-7 success"></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-xxl-4  col-xl-4 col-md-12 col-sm-12 box-col-5">
                <div class="card get-card">
                    <div class="social-profile">

                        <div class="card-body">
                            <h5 class="text-start mb-3"><span class="badge badge-primary btn-hover-effect">Data
                                    DPL
                                    Anda</span></h5>
                            <div class="social-img-wrap" id="aniimated-thumbnials">
                                <div class="social-img" itemprop="associatedMedia" itemscope="">
                                    <?php if(empty($dosen['file'])){?>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#myModal">
                                        <img class="img-70" alt="foto"
                                            src="<?=BASE_URL?>/<?=DIR_INC?>/images/noimage.jpg">
                                    </a>
                                    <?php }else{ ?>
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#myModal">
                                        <img class="img-70" alt="foto"
                                            src="<?=URL_SIAKA?>/dosen/<?=$dosen['file']?>.jpg">
                                    </a>

                                    <?php } ?>
                                </div>
                            </div>
                            <div class="social-details">
                                <span class="f-light d-block"><?=strtoupper($namalengkap);?>
                                </span>
                            </div>


                        </div>
                    </div>

                    <div class="card-body pt-2">
                        <ul class="lessons-lists">
                            <li>
                                <div>
                                    <h6 class="f-14 f-w-400 mb-0">
                                        EMAIL
                                    </h6><a href="mailto:<?=strtolower($dosen['email']);?>"
                                        class="f-primary"><?=strtolower($dosen['email']);?></a>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h6 class="f-14 f-w-400 mb-0">
                                        NOMOR PONSEL
                                    </h6><a href="tel:<?=$dosen['hp'];?>" class="f-primary"><?=$dosen['hp'];?></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <ul class="square-group">
                        <li class="square-1 warning"></li>
                        <li class="square-1 primary"></li>
                        <li class="square-2 warning1"></li>
                        <li class="square-3 danger"></li>
                        <li class="square-4 light"></li>
                        <li class="square-5 warning"></li>
                        <li class="square-6 success"></li>
                        <li class="square-7 success"></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Peserta Kelas
                            Lainnya</h5>
                    </div>
                    <div class=" card-body pt-0 main-our-product">
                        <div class="row g-3">
                            <?php
                                $query_data = $this->pocore()->call->podb->from('mbkm_dpl_kelas_peserta')
                                        ->select('mahasiswa.file,mahasiswa.nama,mahasiswa.nim')
                                        ->leftJoin('mahasiswa ON mahasiswa.nim=mbkm_dpl_kelas_peserta.nim')
                                        ->where('mbkm_dpl_kelas_peserta.`nim` != ?', $kelas['nim'])
                                        ->where('`id_kelas_dpl`', $kelas['id'])
                                        ->fetchAll();
                                foreach($query_data as $ql){
                                ?>
                            <div class="col-xxl-3 col-sm-4">
                                <div class="our-product-wrapper h-100 widget-hover">
                                    <div class="our-product-img">
                                        <?php 
                                            if(empty($ql['file'])){
                                            ?>
                                        <img src="<?=BASE_URL?>/<?=DIR_INC?>/images/noimage.jpg"
                                            style="max-height:250px" alt="foto">
                                        <?php }else{ 
                                            $urlfile = URL_SIAKA.'/mahasiswa/'.$ql['file'].'.jpg';
                                            
                                        ?>
                                        <img src="<?=$urlfile?>" style="max-height:250px" alt="foto">
                                        <?php } ?>

                                    </div>
                                    <div class=" our-product-content">
                                        <h6 class="f-14 f-w-500 pt-2 pb-1 txt-primary">
                                            <?= strtoupper($ql['nama'])?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal fade modal-popup" style="top:5%" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div>
            <button class="btn-close theme-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="card p-t-10">
                    <div class="animate-widget text-center">
                        <div>
                            <?php if(empty($dosen['file'])){?>
                            <img class="img-fluid" style="max-height:400px;"
                                src="<?=BASE_URL?>/<?=DIR_INC?>/images/noimage.jpg" alt="foto">
                            <?php }else{ ?>
                            <img class="img-fluid" style="max-height:400px;"
                                src="<?=URL_SIAKA?>/dosen/<?=$dosen['file']?>.jpg" alt="foto">
                            <?php } ?>
                        </div>
                        <div class="text-center p-25">
                            <p class="text-muted mb-0"><strong class="txt-danger">Nama Lengkap : </strong>
                                <?=strtoupper($namalengkap);?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>