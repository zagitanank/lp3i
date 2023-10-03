<?= $this->layout('index'); ?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div style="margin-top:25px;" class="col-md-12">
                <h1><?= $this->e($page_title); ?></h1>
                <ul class="breadcrumb">
                    <li><a href="<?= BASE_URL; ?>"><i class="fas fa-home"></i> <?= $this->e($front_home); ?></a></li>
                    <li class="active">MBKM UNIFA</li>
                    <li><a href="#"><?= $this->e($page_title); ?></a></li>

                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Start Advisor Area
    ============================================= -->
<section id="advisor" class="advisor-area default-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="advisor-items text-center text-light">

                    <?php
                    $post_by_categorys = $this->team()->getTeam('DESC');
                    foreach ($post_by_categorys as $list_post) {
                    ?>
                        <!-- Single Item -->

                        <div class="col-md-3 col-sm-6 single-item">
                            <div class="advisor-item">
                                <div class="info-box">
                                    <img src="<?= BASE_URL; ?>/<?= DIR_CON; ?>/uploads/<?= $list_post['picture']; ?>" alt="Thumb">
                                    <div class="info-title">
                                        <h4><?= $list_post['title']; ?></h4>
                                        <span><?= $list_post['jabatan']; ?></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Single Item -->
                    <?php } ?>



                </div>
            </div>
        </div>
    </div>
</section>
<!--End Advisor Area -->