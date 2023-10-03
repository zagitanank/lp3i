<?= $this->layout('index'); ?>
<section class="pt-5 mnb">
    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 0"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 1"></button>
            </div>
            <div class="carousel-inner">
                <?php
                $post_by_categorys = $this->slideshow()->getSlide('DESC');
                $i = 0;
                foreach ($post_by_categorys as $list_post) {

                ?>
                <div class="carousel-item <?php echo $i == 0 ? 'active' : ""; ?>">
                    <div class="carousel-img">
                        <a href=""> <img src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $list_post['picture']; ?>"
                                class="w-100 radius-10" alt="#"> </a>
                    </div>
                </div>
                <?php $i++;
                } ?>


            </div>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    </div>
    <img src="<?= $this->asset('/assets/img/bottom.png'); ?>" class="img-fluid w-100" data-aos="fade-up" alt="#">
</section>
<section class="py-5 border-bottom">
    <div class="container">
        <div class="row short">
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="mobile-app.html">
                    <div class="card shadow-lg h-100">
                        <div class="card-body">
                            <div class="display">
                                <img src="<?= $this->asset('/assets/img/survey.png'); ?>" class="mb-4" alt="#">
                                <div>
                                    <h4 class="text-dark">
                                        Survey
                                    </h4>
                                    Sebagai wadah untuk mengetahui aspirasi masyarakat dengan tujuan kesejahteraan.
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="profile.html">
                    <div class="card shadow-lg h-100">
                        <div class="card-body">
                            <div class="display">
                                <img src="<?= $this->asset('/assets/img/profile.png'); ?>" class="mb-4" alt="#">
                                <div>
                                    <h4 class="text-dark">
                                        Profile
                                    </h4>
                                    Temukan Lebih Dalam Profil dan Latar Belakang Uchu Cappoe
                                    <!-- untuk Memahami Lebih Banyak -->
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="program.html">
                    <div class="card shadow-lg h-100">
                        <div class="card-body">
                            <div class="display">
                                <img src="<?= $this->asset('/assets/img/checklist.png'); ?>" class="mb-4" alt="#">
                                <div>
                                    <h4 class="text-dark">
                                        Program
                                    </h4>
                                    Satukan Langkah, Wujudkan Perubahan Nyata Bersama Uchu Cappoe
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="dukungan.html">
                    <div class="card shadow-lg h-100">
                        <div class="card-body">
                            <div class="display">
                                <img src="<?= $this->asset('/assets/img/man.png'); ?>" class="mb-4" alt="#">
                                <div>
                                    <h4 class="text-dark">
                                        Dukungan
                                    </h4>
                                    Suarakan Pesan Dukungan dan Aspirasi Anda kepada Uchu Cappoe
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-up">
                <h5 class="text-danger">PROFIL</h5>
                <div class="pe-lg-5">
                    <h3 class="text-dark mb-0">Muh. Yusuf Ali, ST., MT</h3>
                </div>
                <div class="my-4">
                    <p>Salam sejahtera, saya <strong>Uchu Cappoe</strong> . Kandidat calon anggota legislatif Sulawesi
                        Selatan. Saya memiliki latar belakang sebagai dosen dan juga aktif dalam berbagai kegiatan
                        sosial di
                        masyarakat. Melalui pengalaman
                        hidup dan kerja saya, saya ingin berkontribusi lebih dalam untuk memajukan dan juga
                        meningkatkan kesejahteraan masyarakat di wilayah Sulawesi Selatan.</p>
                </div>
                <a href="profile.html" class="btn btn-danger mt-4">Selengkapnya<i
                        class="far fa-paper-plane ms-2"></i></a>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-up">
                <div>
                    <img src="<?= $this->asset('/assets/img/profil.png'); ?>" alt="Uchu Cappoe"
                        class="img-fluid rounded-4 w-100">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5 bg-light testi">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center" data-aos="fade-up">
                <h5 class="text-danger">PROGRAM</h5>
                <h3 class="text-dark mb-0">Untuk Sulawesi Selatan Yang Lebih Sejahtera</h3>
            </div>
        </div>
        <div class="row">
            <?php
            $program = $this->program()->getRecentProgram('3', 'DESC', WEB_LANG_ID);
            foreach ($program as $prog) {
            ?>
            <div class="col-lg-4 col-md-6 mt-4" data-aos="fade-up">
                <div class="card p-3">
                    <a href="<?= BASE_URL; ?>/detailprogram/<?= $prog['seotitle']; ?>">
                        <div class="d-md-none">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <figure>
                                        <img src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $prog['picture']; ?>"
                                            class="card-img-top" alt="Program Images">
                                    </figure>
                                </div>
                                <div class="col-8">
                                    <h6 class="text-black"><?= $prog['title']; ?></h6>
                                    <?= $this->pocore()->call->postring->cuthighlight('post', $prog['content'], '100'); ?>...
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="<?= BASE_URL; ?>/detailprogram/<?= $prog['seotitle']; ?>">
                        <div class="d-md-block d-none">
                            <figure>
                                <img src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $prog['picture']; ?>"
                                    class="card-img-top" alt="Program Images">
                            </figure>
                            <h5 class="mt-4 text-black"><?= $prog['title']; ?></h5>
                            <?= $this->pocore()->call->postring->cuthighlight('post', $prog['content'], '100'); ?>...
                        </div>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- <section class="s-top hero pt-5 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4">
                <h5 class="text-black mb-4" data-aos="fade-up">VIDEO TERBARU</h5>
                <div class="ratio ratio-16x9 radius-10" data-aos="fade-up">
                    <?php
                    $video_headlines = $this->video()->getHeadlineVideo('1', 'id_video DESC');
                    foreach ($video_headlines as $video_headline) {
                    ?>
                    <iframe src="<?= $video_headline['url']; ?>" class="radius-10" allowfullscreen></iframe>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <h5 class="text-black mb-4" data-aos="fade-up">FOTO TERBARU</h5>
                <div class="post post-thumb mb-4" data-aos="fade-up">
                    <a class="post-img" href="foto/read/307/bertani-semangka/index.html"><img
                            src="dirmember/00000001/democaleg35/galeri-120-3.jpg"></a>
                    <div class="post-body">
                        <div class="post-meta">
                            <span class="post-date">Selasa, 18 April 2023 12:09 WIB </span>
                        </div>
                        <h3 class="post-title text-white"><a href="foto/read/307/bertani-semangka/index.html">Bertani
                                Semangka</a>
                        </h3>
                    </div>
                </div>
                <div class="post post-thumb mb-4" data-aos="fade-up">
                    <a class="post-img"
                        href="foto/read/306/aksi-peduli-lingkungan-di-pantai-bersama-kaum-muda/index.html"><img
                            src="dirmember/00000001/democaleg35/galeri-120-2.jpg"></a>
                    <div class="post-body">
                        <div class="post-meta">
                            <span class="post-date">Selasa, 18 April 2023 12:09 WIB </span>
                        </div>
                        <h3 class="post-title text-white"><a
                                href="foto/read/306/aksi-peduli-lingkungan-di-pantai-bersama-kaum-muda/index.html">Aksi
                                Peduli
                                Lingkungan di Pantai bersama Kaum Muda</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<section class="py-5 bg-light testi">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center" data-aos="fade-up">
                <h5 class="text-danger">TESTIMONIAL</h5>
                <h3 class="text-dark mb-0">Apa yang mereka katakan</h3>
            </div>
        </div>
        <div class="swiper-container kategori1 mt-5">
            <div class="swiper-wrapper">
                <?php
                $recent_testimoni = $this->testimoni()->getTestimoni('DESC');
                foreach ($recent_testimoni as $list_testi) {
                ?>
                <div class="swiper-slide" data-aos="fade-up">
                    <div class="bg-white p-3 radius-10">
                        <div class="quo mb-3"><?= $list_testi['content']; ?></div>
                    </div>
                    <div class="d-flex align-items-center mt-4">
                        <img src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $list_testi['picture']; ?>"
                            alt="<?= $list_testi['title']; ?>" class="img-fluid rounded-circlee" width="70">
                        <div class="ms-3">
                            <h6 class="text-dark mb-1 text-uppercase"><?= $list_testi['title']; ?></h6>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="row align-items-center mt-5">
                <div class="col-6 d-flex justify-content-start">
                    <div class="swiper-pagination asd"></div>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <div class="swiper-button-prev font-weight-bold"></div>
                    <div class="swiper-button-next font-weight-bold"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4">
                <h5 class="text-black mb-4" data-aos="fade-up">BERITA UTAMA</h5>
                <div class="post post-thumb" data-aos="fade-up">
                    <?php
                    $post_by_categorys = $this->post()->getPostByCategory('1', '1', 'DESC', WEB_LANG_ID);
                    foreach ($post_by_categorys as $list_post) { ?>
                    <a class="post-img" href="<?= BASE_URL; ?>/detailpost/<?= $list_post['seotitle']; ?>"><img
                            src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/medium/medium_<?= $list_post['picture']; ?>"></a>
                    <div class="post-body">
                        <div class="post-meta">
                            <span
                                class="post-date"><?= $this->pocore()->call->podatetime->tgl_indo($list_post['date']); ?>

                            </span>
                        </div>
                        <h3 class="post-title text-white"><a
                                href="<?= BASE_URL; ?>/detailpost/<?= $list_post['seotitle']; ?>"><?= $list_post['title']; ?></a>
                        </h3>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <h5 class="text-black mb-4" data-aos="fade-up">BLOG TERBARU</h5>
                <?php
                $blogs = $this->post()->getPostByCategory('2', '2', 'DESC', WEB_LANG_ID);
                foreach ($blogs as $blog) { ?>
                <div class="post post-thumb mb-4" data-aos="fade-up">

                    <a class="post-img" href="<?= BASE_URL; ?>/detailpost/<?= $blog['seotitle']; ?>"><img
                            src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/medium/medium_<?= $blog['picture']; ?>"></a>
                    <div class="post-body">
                        <div class="post-meta">
                            <span class="post-date"><?= $this->pocore()->call->podatetime->tgl_indo($blog['date']); ?>
                            </span>
                        </div>
                        <h3 class="post-title text-white"><a
                                href="<?= BASE_URL; ?>/detailpost/<?= $blog['seotitle']; ?>"><?= $blog['title']; ?>
                            </a></h3>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>
</section>