<?= $this->layout('index'); ?>

<div class="banner-area transparent-nav content-top-heading text-normal">
    <div id="bootcarousel" class="carousel slide animate_text carousel-fade" data-ride="carousel">

        <!-- Wrapper for slides -->
        <div class="carousel-inner text-light carousel-zoom">
            <?php
            $post_by_categorys = $this->slideshow()->getSlide('DESC');
            $i = 0;
            foreach ($post_by_categorys as $list_post) {

            ?>
            <div class="item <?php echo $i == 0 ? 'active' : ""; ?>">
                <div class="slider-thumb bg-fixed"
                    style="background-image: url(<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $list_post['picture']; ?>);">
                </div>
                <div class="box-table shadow dark">
                    <div class="box-cell">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="content">
                                        <h2 data-animation="animated slideInDown">SIM MBKM</h2>
                                        <h2 data-animation="animated slideInDown"><span>Politeknik LP3I Makassar</span>
                                        </h2>


                                        <a data-animation="animated slideInUp" class="btn btn-theme effect btn-md"
                                            href="<?= BASE_URL; ?>/akun">LOGIN</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $i++;
            } ?>


        </div>
        <!-- End Wrapper for slides -->

        <!-- Left and right controls -->
        <a class="left carousel-control shadow" href="#bootcarousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control shadow" href="#bootcarousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
            <span class="sr-only">Next</span>
        </a>

    </div>
</div>
<!-- End Banner -->

<!-- Start Top Category & Trending Courses 
    ============================================= -->
<div id="top-categories" class="top-cat-area bg-gray default-padding bottom-less">
    <div class="container">
        <div class="row">
            <div class="site-heading text-center">
                <div class="col-md-8 col-md-offset-2">
                    <h2>Bentuk Kegiatan Pembelajaran</h2>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 top-cat-items text-light inc-bg-color text-center">
                <div class="row">
                    <?php
                    $program = $this->program()->getRecentProgram('9', 'ASC', WEB_LANG_ID);
                    foreach ($program as $prog) {
                    ?>
                    <div class="col-md-3 col-sm-6 equal-height">
                        <div class="item <?= $prog['item']; ?>"
                            style="background-image: url(<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $prog['picture']; ?>);">
                            <a href="<?= BASE_URL; ?>/detailprogram/<?= $prog['seotitle']; ?>">
                                <i class="flaticon-<?= $prog['icon']; ?>"></i>
                                <div class="info">
                                    <h8><?= $prog['title']; ?></h8>

                                </div>
                            </a>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
            <!-- End Top Category -->
        </div>
    </div>
</div>
<!-- End Top Categories & Trending Courses -->



<!-- Start Event
    ============================================= -->
<section id="event" class="event-area carousel-shadow bg-gray single-view default-padding">
    <div class="container">
        <div class="row">
            <div class="site-heading text-center">
                <div class="col-md-8 col-md-offset-2">
                    <h2>AGENDA MBKM</h2>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="event-items event-carousel owl-carousel owl-theme">
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
                    <div class="item vertical">
                        <div class="thumb">
                            <a href="<?= BASE_URL; ?>/detailagenda/<?= $event_side['seotitle']; ?>"><img
                                    src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $event_side['picture']; ?>"
                                    alt=""></a>
                            <div class="date">
                                <h4><?= $this->pocore()->call->podatetime->tgl_indo($event_side['publishdate']); ?></h4>
                            </div>
                        </div>
                        <div class="info">
                            <h4>
                                <a
                                    href="<?= BASE_URL; ?>/detailagenda/<?= $event_side['seotitle']; ?>"><?= $event_side['title']; ?></a>
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
                            <a href="<?= BASE_URL; ?>/detailagenda/<?= $event_side['seotitle']; ?>"
                                class="btn btn-dark effect btn-xsm">
                                <i class="far fa-calendar-alt"></i> LIHAT
                            </a>

                        </div>
                    </div>
                    <!-- Single Item -->

                    <?php } ?>

                </div>
                <div style="margin-top: 30px;" class="more-btn col-md-12 text-center">
                    <a href="<?= BASE_URL; ?>/agenda/all" class="btn btn-dark border btn-md">SEMUA AGENDA</a>
                </div>
            </div>

        </div>

    </div>

</section>
<!-- End Event -->



<!-- Start Testimonials 
    ============================================= -->
<div class="testimonials-area carousel-shadow default-padding bg-dark text-light">
    <div class="container">
        <div class="row">
            <div class="site-heading text-center">
                <div class="col-md-8 col-md-offset-2">
                    <h2>Testimoni Mahasiswa</h2>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="clients-review-carousel owl-carousel owl-theme">
                    <?php
                    $post_by_categorys = $this->testimoni()->getTestimoni('DESC');
                    foreach ($post_by_categorys as $list_post) {
                    ?>
                    <!-- Single Item -->
                    <div class="item">
                        <div class="col-md-5 thumb">
                            <img src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $list_post['picture']; ?>" alt="">
                        </div>
                        <div class="col-md-7 info">
                            <p><?= $list_post['content']; ?></p>
                            <h4><?= $list_post['title']; ?></h4>
                            <span><?= $list_post['jurusan']; ?></span>
                        </div>
                    </div>
                    <!-- Single Item -->
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Testimonials -->

<!-- Start Blog 
    ============================================= -->
<div id="blog" class="blog-area default-padding bottom-less">
    <div class="container">
        <div class="row">
            <div class="site-heading text-center">
                <div class="col-md-8 col-md-offset-2">
                    <h2>Berita Terbaru</h2>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="blog-items">

                <!-- Single Item -->
                <?php
                $recents_side = $this->post()->getRecent('3', 'DESC', WEB_LANG_ID);
                foreach ($recents_side as $recent_side) {

                ?>
                <div class="col-md-4 single-item">
                    <div class="item">
                        <div class="thumb">
                            <a href="<?= BASE_URL; ?>/detailpost/<?= $recent_side['seotitle']; ?>"><img
                                    src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/medium/medium_<?= $recent_side['picture']; ?>"
                                    alt=""></a>
                            <div class="date">
                                <h4><?= $this->pocore()->call->podatetime->tgl_indo($recent_side['date']); ?></h4>
                            </div>
                        </div>
                        <div class="info">
                            <h4>
                                <a
                                    href="<?= BASE_URL; ?>/detailpost/<?= $recent_side['seotitle']; ?>"><?= $this->pocore()->call->postring->cuthighlight('title', $recent_side['title'], '100'); ?>...</a>
                            </h4>
                            <p> <?= $this->pocore()->call->postring->cuthighlight('post', $recent_side['content'], '100'); ?>...
                            </p>

                            <a href="<?= BASE_URL; ?>/detailpost/<?= $recent_side['seotitle']; ?>">Baca Sekarang <i
                                    class="fas fa-angle-double-right"></i></a>
                            <div class="meta">

                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>


            </div>

        </div>

    </div>
</div>
<!-- End Blog -->

<!-- Start Clients Area 
    ============================================= -->
<div class="clients-area default-padding bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-4 info">
                <h4>MITRA MBKM POLITEKNIK LP3I MAKASSAR</h4>
                <p>Dalam Program Merdeka Belajar Kampus Merdeka Politeknik LP3I Makassar memiliki beberapa mitra untuk
                    terlaksanakan
                    progran ini, adapun mitra sebagai berikut :</p>
            </div>
            <div class="col-md-8 clients">
                <div class="clients-items owl-carousel owl-theme text-center">
                    <?php
                    $post_by_categorys = $this->mitra()->getmitra('DESC');

                    foreach ($post_by_categorys as $list_post) {

                    ?>
                    <div class="single-item">
                        <img src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $list_post['picture']; ?>" alt="Clients">
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Clients Area -->