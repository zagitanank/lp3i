<?= $this->layout('index'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Beranda </h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL?>/dosen">
                                <svg class="stroke-icon">
                                    <use href="<?= BASE_URL; ?>/<?= DIR_INC ?>/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Home </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid m-b-50">
        <div class="row widget-grid">

            <div class="col-xxl-6 col-sm-12 box-col-12">

                <div class="card profile-box">
                    <div class="card-body">
                        <div class="media media-wrapper justify-content-between">
                            <div class="media-body">
                                <div class="greeting-user">
                                    <h4 class="f-w-600">Welcome to SIM MBKM</h4>
                                    <p>Assement semua aktivitas MBKM Mahasiswa Bimbingan Anda</p>
                                    <div class="whatsnew-btn">
                                        <span class="btn btn-warning text-dark">Periode Akademik
                                            <?=$this->pocore()->call->Convert_periode_totext($this->e($tahun_akademik));?></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="clockbox">
                                    <svg id="clock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 600">
                                        <g id="face">
                                            <circle class="circle" cx="300" cy="300" r="253.9"></circle>
                                            <path class="hour-marks"
                                                d="M300.5 94V61M506 300.5h32M300.5 506v33M94 300.5H60M411.3 107.8l7.9-13.8M493 190.2l13-7.4M492.1 411.4l16.5 9.5M411 492.3l8.9 15.3M189 492.3l-9.2 15.9M107.7 411L93 419.5M107.5 189.3l-17.1-9.9M188.1 108.2l-9-15.6">
                                            </path>
                                            <circle class="mid-circle" cx="300" cy="300" r="16.2"></circle>
                                        </g>
                                        <g id="hour">
                                            <path class="hour-hand" d="M300.5 298V142"></path>
                                            <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
                                        </g>
                                        <g id="minute">
                                            <path class="minute-hand" d="M300.5 298V67"> </path>
                                            <circle class="sizing-box" cx="300" cy="300" r="253.9"></circle>
                                        </g>
                                        <g id="second">
                                            <path class="second-hand" d="M300.5 350V55"></path>
                                            <circle class="sizing-box" cx="300" cy="300" r="253.9">
                                            </circle>
                                        </g>
                                    </svg>
                                </div>
                                <div class="badge f-10 p-0" id="txt"></div>
                            </div>
                        </div>
                        <div class="cartoon"><img class="img-fluid"
                                src="<?= BASE_URL . '/' . DIR_INC; ?>/images/cartoon.svg"
                                alt="vector women with leptop">
                        </div>
                    </div>
                </div>


                <div class="row g-sm-3 widget-charts">
                    <div class="col-sm-6">
                        <div class="card small-widget mb-sm-0">
                            <div class="card-body primary"> <span class="f-light">Target MBKM</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4><?=$this->pocore()->call->posetting[18]['value'];?></h4><span
                                        class="font-primary f-12 f-w-500"><span>Jam</span></span>
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
                    <div class="col-sm-6">
                        <div class="card small-widget mb-sm-0">
                            <div class="card-body secondary"><span class="f-light">Jumlah Kelas</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4><?=$this->pocore()->call->podb->from('mbkm_dpl_kelas')
                                        ->where('`kode_dosen`', $_SESSION['namauser_member'])
                                        ->where('`periode_krs`', $this->e($tahun_akademik))->count(); ?>
                                    </h4><span class="font-secondary f-12 f-w-500"><span>Kelas</span></span>
                                </div>
                                <div class="bg-gradient">
                                    <svg class="stroke-icon svg-fill">
                                        <use
                                            href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/svg/icon-sprite.svg#stroke-learning">
                                        </use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card small-widget mb-sm-0">
                            <div class="card-body warning"><span class="f-light">Jumlah Mahasiswa</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4><?= $this->pocore()->call->podb->from('mbkm_dpl_kelas')
                                        ->select('mbkm_dpl_kelas.periode_krs,mbkm_dpl_kelas_peserta.id_kelas_dpl,mbkm_dpl_kelas_peserta.nim,mbkm_dpl_kelas_peserta.jenis_mbkm,mahasiswa.nama')
                                        ->leftJoin('mbkm_dpl_kelas_peserta ON mbkm_dpl_kelas.id=mbkm_dpl_kelas_peserta.id_kelas_dpl')
                                        ->where('kode_dosen', $_SESSION['namauser_member'])
                                        ->where('mbkm_dpl_kelas.periode_krs', $this->e($tahun_akademik))->count(); ?>
                                    </h4>
                                    <span class="font-warning f-12 f-w-500"><span>Bimbingan</span></span>
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
                    <div class="col-sm-6">
                        <div class="card small-widget mb-sm-0">
                            <div class="card-body success"><span class="f-light">Logbook Mahasiswa</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4><?= $this->pocore()->call->podb->from('mbkm_view_logbook')
                                        ->where('kode_dosen', $_SESSION['namauser_member'])
                                        ->where('logbook_periode_akademik', $this->e($tahun_akademik))->count(); ?>
                                    </h4><span class="font-success f-12 f-w-500"><span>Data</span></span>
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
                </div>
            </div>

            <div class="col-xxl-6 col-sm-12 box-col-12">

                <div class="notification">
                    <div class="card height-equal">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0">Log Book Terbaru</h5>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <?php
                            $jml_logbook_terbaru = $this->pocore()->call->podb->from('mbkm_logbook')
                                        ->select('mbkm_logbook.logbook_tanggal_created,mbkm_dpl_kelas.periode_krs,mbkm_dpl_kelas.jenis_mbkm,mahasiswa.nama')
                                        ->leftJoin('mbkm_dpl_kelas ON mbkm_dpl_kelas.id=mbkm_logbook.logbook_dpl_kelas_id')
                                        ->leftJoin('mahasiswa ON mahasiswa.nim=mbkm_logbook.logbook_nim')
                                        ->where('mbkm_dpl_kelas.kode_dosen', $_SESSION['namauser_member'])
                                        ->where('mbkm_dpl_kelas.periode_krs', $this->e($tahun_akademik))
                                        ->count();
                            if($jml_logbook_terbaru > 0){
                            ?>
                            <ul>
                                <?php $logbook_terbaru = $this->pocore()->call->podb->from('mbkm_logbook')
                                        ->select('mbkm_logbook.logbook_tanggal_created,mbkm_dpl_kelas.periode_krs,mbkm_dpl_kelas.jenis_mbkm,mahasiswa.nama')
                                        ->leftJoin('mbkm_dpl_kelas ON mbkm_dpl_kelas.id=mbkm_logbook.logbook_dpl_kelas_id')
                                        ->leftJoin('mahasiswa ON mahasiswa.nim=mbkm_logbook.logbook_nim')
                                        ->where('mbkm_dpl_kelas.kode_dosen', $_SESSION['namauser_member'])
                                        ->where('mbkm_dpl_kelas.periode_krs', $this->e($tahun_akademik))
                                        ->orderBy('mbkm_logbook.logbook_id DESC')
                                        ->limit(3)
                                        ->fetchAll();
                                    foreach($logbook_terbaru as $ltb){
                                        $pisahtgl = explode(' ',$ltb['logbook_tanggal_created']);
                                        $mbkm_bkp = $this->pocore()->call->podb->from('mbkm_jenis')->where('id', $ltb['jenis_mbkm'])->limit(1)->fetch(); 
                                        $mbkm_kat = $this->pocore()->call->podb->from('mbkm_kategori')->where('mbkm_kategori_id', $mbkm_bkp['mbkm_kategori'])->limit(1)->fetch(); 
                                ?>
                                <li class="d-flex">
                                    <div class="activity-dot-primary"></div>
                                    <div class="w-100 ms-3">
                                        <p class="d-flex justify-content-between mb-2"><span
                                                class="date-content light-background"><?= $this->pocore()->call->tanggal_indo($ltb['logbook_tanggal_created'])?>
                                            </span><span><?=$pisahtgl[1]?></span></p>
                                        <h6><?=$ltb['nama']?><span class="dot-notification"></span></h6>
                                        <p class="f-light"><?=$mbkm_bkp['mbkm_jenis_nama'];?><br> <small
                                                class="f-light"><?=strtoupper($mbkm_kat['mbkm_kategori_nama']);?></small>
                                        </p>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php }else{ ?>


                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>