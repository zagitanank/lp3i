<?= $this->layout('index'); ?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div style="margin-top:25px;" class="col-md-12">
                <h1><?= $this->e($agenda['title']); ?></h1>
                <ul class="breadcrumb">
                    <li><a href="<?= BASE_URL; ?>"><i class="fas fa-home"></i><?= $this->e($front_home); ?></a></li>
                    <li><a href="#"><?= $this->e($agenda['title']); ?></a></li>
                    <li class="active">MBKM UNIFA</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Event
    ============================================= -->
<section id="event" class="event-area bg-gray single-view default-padding">
    <div class="container">
        <div class="row">
            <div class="event-items">
                <?php
                $agenda_side = $this->agenda()->getRecentAgenda('4', 'DESC', WEB_LANG_ID);
                foreach ($agenda_side as $event_side) {

                    $bahasa = WEB_LANG_ID;
                    if ($bahasa == '1') {
                        $tanggal_awal_id = $this->pocore()->call->podatetime->tgl_indo($event_side['date_start']);
                        $tanggal_akhir_id = $this->pocore()->call->podatetime->tgl_indo($event_side['date_end']);
                        $tanggalkegiatan = "$tanggal_awal_id - $tanggal_akhir_id";
                    } else {
                        $tanggal_awal_en = $this->pocore()->call->podatetime->tgl_global($event_side['date_start']);
                        $tanggal_akhir_en = $this->pocore()->call->podatetime->tgl_global($event_side['date_end']);
                        $tanggalkegiatan = "$tanggal_awal_en - $tanggal_akhir_en";
                    }
                ?>
                    <!-- Single Item -->
                    <div class="item vertical col-md-6">
                        <div class="thumb">
                            <a href="<?= BASE_URL; ?>/detailagenda/<?= $event_side['seotitle']; ?>"><img src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $event_side['picture']; ?>" alt=""></a>
                            <div class="date">
                                <h4><?= $this->pocore()->call->podatetime->tgl_indo($event_side['publishdate']); ?></h4>
                            </div>
                        </div>

                        <div class="info">
                            <h4>
                                <a href="<?= BASE_URL; ?>/detailagenda/<?= $event_side['seotitle']; ?>"><?= $event_side['title']; ?></a>
                            </h4>
                            <div class="meta">
                                <ul>
                                    <li><i class="fas fa-clock"></i> <?= $event_side['time']; ?> </li>
                                    <li><i class="far fa-calendar-alt"></i> <?= $tanggalkegiatan; ?> </li>
                                    <li><i class="fas fa-map"></i> <?= $event_side['locations']; ?> </li>
                                </ul>
                            </div>
                            <p><?= $this->pocore()->call->postring->cuthighlight('post', $event_side['content'], '200'); ?>...
                            </p>
                            <a href="<?= BASE_URL; ?>/detailagenda/<?= $event_side['seotitle']; ?>" class="btn btn-dark effect btn-xsm">
                                <i class="far fa-calendar-alt"></i> LIHAT
                            </a>

                        </div>
                    </div>
                    <!-- Single Item -->
                <?php } ?>

                <div style="margin-top: 30px;">
                    <div class="row">
                        <div class="col-md-12 pagi-area text-center">
                            <nav aria-label="navigation">
                                <ul class="pagination">
                                    <li>
                                        <?php
                                        $totaldata = $this->pocore()->call->podb->from('agenda')->count();
                                        $totalpage = $this->pocore()->call->popaging->totalPage($totaldata, '8');
                                        echo $this->pocore()->call->popaging->navPage($this->e($page), $totalpage, BASE_URL, 'agenda', 'page', '1', $this->e($front_paging_prev), $this->e($front_paging_next));
                                        ?>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- End Event -->