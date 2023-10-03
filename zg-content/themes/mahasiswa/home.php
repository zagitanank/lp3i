<?= $this->layout('index'); ?>
<div class="page-body p-b-50">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Beranda </h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL?>/mahasiswa">
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
    <div class="container-fluid">
        <div class="row widget-grid">

            <div class="col-xxl-6 col-sm-12 box-col-12">

                <div class="card profile-box">
                    <div class="card-body">
                        <div class="media media-wrapper justify-content-between">
                            <div class="media-body">
                                <div class="greeting-user">
                                    <h4 class="f-w-600">Welcome to SIM MBKM
                                        <span> <img src="<?=BASE_URL?>/<?=DIR_INC?>/akun/svg/hand.svg" alt="hand
                                vector"></span>
                                    </h4>
                                    <p>Buatlah deskripsi serasional mungkin berdasarkan waktu dan aktivitas yang telah
                                        dilakukan. Pastikan mencapai <strong
                                            class="badge badge-secondary f-w-900 f-16"><?=$this->pocore()->call->posetting[18]['value'];?>
                                            jam</strong> untuk setara 20 SKS !</p>
                                    <div class="whatsnew-btn">
                                        <span class="btn btn-warning text-dark">Periode Akademik
                                            <?=$this->pocore()->call->Convert_periode_totext($this->e($tahun_akademik));?></span>
                                    </div>
                                </div>
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

                    <div class="col-sm-6">
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

                    <div class="col-sm-6">
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


                    <div class="col-sm-6">
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
                            <ul>
                                <?php $logbook_terbaru = $this->pocore()->call->podb->from('mbkm_logbook')
                                        ->select('mbkm_logbook.logbook_tanggal_created,mahasiswa.nama')
                                        ->leftJoin('mahasiswa ON mahasiswa.nim=mbkm_logbook.logbook_nim')
                                        ->where('logbook_nim', $_SESSION['namauser_member'])
                                        ->where('logbook_periode_akademik', $this->e($tahun_akademik))
                                        ->orderBy('mbkm_logbook.logbook_id DESC')
                                        ->limit(7)
                                        ->fetchAll();
                                    foreach($logbook_terbaru as $ltb){
                                        $pisahtgl = explode(' ',$ltb['logbook_tanggal_created']);
                                ?>
                                <li class="d-flex">
                                    <div class="activity-dot-info"></div>
                                    <div class="w-100 ms-3">
                                        <p class="d-flex justify-content-between mb-2"><span
                                                class="date-content light-background"><?= $this->pocore()->call->tanggal_indo($ltb['logbook_tanggal_created'])?>
                                            </span><span><?=$pisahtgl[1]?></span></p>

                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>