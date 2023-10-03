<?= $this->layout('index'); ?>

<!-- Start Breadcrumb 
    ============================================= -->
<section class="s-top py-5 bg-light">
    <div class="container" data-aos="fade-up">
        <small><a href="<?= BASE_URL; ?>"><?= $this->e($front_home); ?></a> / <?= $this->e($pages['title']); ?> /
            Detail</small>
        <div class="post-meta mt-4">
            <span class="post-date"></span>
        </div>
        <h2 class="text-black mb-0 mt-2"><?= $this->e($pages['title']); ?></h2>
    </div>
</section>
<!-- End Breadcrumb -->

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php if ($this->e($pages['picture']) != '') { ?>
                    <img src="<?= BASE_URL . '/' . DIR_CON . '/uploads/' . $this->e($pages['picture']); ?>" class="w-100 mb-4" alt="<?= $this->e($pages['title']); ?>" data-aos="fade-up">

                <?php } ?>
                <div align="justify" data-aos="fade-up">
                    <?= htmlspecialchars_decode(html_entity_decode($this->e($pages['content']))); ?>
                </div>
                <hr>
                <div class="d-flex align-items-center" data-aos="fade-up">
                    Share :
                    <a class="btn btn-light text-white ms-2" style="background-color: #3b5998 !important; border-color: #3b5998 !important;" href="https://www.facebook.com/sharer/sharer.php?u=<?= BASE_URL; ?>/pages/<?= $pages['seotitle']; ?>" target="_blank" style="background: #103e8a"><i class="fab fa-facebook"></i></a>&nbsp;
                    <a class="btn btn-light text-white ms-2" style="background-color: #4dc247 !important; border-color: #4dc247 !important;" href="https://wa.me/?text=<?= $this->e($pages['title']); ?>.%20<?= BASE_URL; ?>/pages/<?= $pages['seotitle']; ?>" target="_blank"><i class="fab fa-whatsapp"></i></a>&nbsp;
                    <a class="btn btn-light text-white ms-2" style="background-color: #1da1f2 !important; border-color: #1da1f2 !important;" href="https://twitter.com/share?url=<?= BASE_URL; ?>/pages/<?= $pages['seotitle']; ?>&amp;text=<?= $this->e($pages['title']); ?>." target="_blank"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up">
                <h5 class="text-black">POPULER</h5>
                <?php
                $populars_side = $this->post()->getPopular('3', 'DESC', WEB_LANG_ID);
                foreach ($populars_side as $popular_side) {
                    $populars_category = $this->category()->getCategory($popular_side['id_post'], WEB_LANG_ID);
                ?>
                    <hr>
                    <a href="<?= BASE_URL; ?>/<?= SLUG_PERMALINK; ?>/<?= $popular_side['seotitle']; ?>">
                        <div class="row">
                            <div><?= $popular_side['title']; ?></div>
                            <div><small><i class="fa fa-calendar"></i>
                                    <?= $this->pocore()->call->podatetime->tgl_indo($popular_side['date']); ?> </small>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
</section>