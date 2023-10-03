<?= $this->layout('index'); ?>


<!-- Start Breadcrumb 
    ============================================= -->
<section class="s-top py-5 bg-light">
    <div class="container" data-aos="fade-up">
        <small><a href="<?= BASE_URL; ?>"><?= $this->e($front_home); ?></a> / <?= $this->e($page_title); ?> /
            Semua Data</small>
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
                <?php
                $categorys = $this->post()->getPostFromCategory('3', 'id_post_category DESC', 'post.id_post DESC', $category, $this->e($page), WEB_LANG_ID);
                foreach ($categorys as $post) {
                ?>
                <div class="row post align-items-center mb-4" data-aos="fade-up">
                    <div class="col-md-5">
                        <a class="post-img"
                            href="<?= BASE_URL; ?>/<?= SLUG_PERMALINK; ?>/<?= $post['seotitle']; ?>"><img
                                src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $post['picture']; ?>"></a>
                    </div>
                    <div class="col-md-7">
                        <div class="post-meta mt-lg-0">
                            <span class="post-date"><?= $this->pocore()->call->podatetime->tgl_indo($post['date']); ?>

                            </span>
                        </div>
                        <h3 class="post-title"><a
                                href="<?= BASE_URL; ?>/<?= SLUG_PERMALINK; ?>/<?= $post['seotitle']; ?>"
                                class="text-black"><?= $post['title']; ?></a>
                        </h3>
                        <div class="mt-3">
                            <?= $this->pocore()->call->postring->cuthighlight('post', $post['content'], '200'); ?>...
                        </div>
                    </div>
                </div>
                <?php } ?>

                <nav aria-label="Page navigation example" data-aos="fade-up">
                    <ul class="pagination justify-content-center">
                        <?= $this->post()->getCategoryPaging('6', $category, $this->e($page), '1', $this->e($front_paging_prev), $this->e($front_paging_next)); ?>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up">
                <h5 class="text-black"><?= strtoupper($this->e($page_title)); ?> POPULER</h5>
                <?php
                if ($category['seotitle'] == 'berita') {
                    $idkate = '1';
                } elseif ($category['seotitle'] == 'blog') {
                    $idkate = '2';
                }
                $populars_side = $this->post()->getPopularInCategory($idkate, '3', 'DESC', WEB_LANG_ID);
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