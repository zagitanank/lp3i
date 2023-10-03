<?= $this->layout('index'); ?>

<!-- Start Breadcrumb 
    ============================================= -->
<section class="s-top py-5 bg-light">
    <div class="container" data-aos="fade-up">
        <small><a href="<?= BASE_URL; ?>"><?= $this->e($front_home); ?></a> / <?= $this->e($front_post_title); ?> /
            <?= $this->e($page_title); ?></small>
        <div class="post-meta mt-4">
            <span class="post-date"></span>
        </div>
        <h2 class="text-black mb-0 mt-2"><?= $this->e($page_title); ?></h2>
    </div>
</section>
<!-- End Breadcrumb -->

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row post align-items-center mb-4" data-aos="fade-up">
                    <img src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $post['picture']; ?>" class="img-fluid mb-4"
                        data-aos="fade-up">
                    <div data-aos="fade-up">
                        <div class="post-meta mt-lg-0">
                            <span class="post-date"><?= $this->pocore()->call->podatetime->tgl_indo($post['date']); ?>

                            </span>
                        </div>
                        <h3 class="post-title"><a
                                href="<?= BASE_URL; ?>/<?= SLUG_PERMALINK; ?>/<?= $post['seotitle']; ?>"
                                class="text-black"><?= $post['title']; ?></a>
                        </h3>
                        <div class="mt-3">
                            <?= htmlspecialchars_decode(html_entity_decode($post['content'])); ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up">
                <h5 class="text-black">POPULER
                </h5>
                <?php
                $populars_side = $this->post()->getPopular('6', 'DESC', WEB_LANG_ID);
                foreach ($populars_side as $popular_side) {

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
    </div>
</section>