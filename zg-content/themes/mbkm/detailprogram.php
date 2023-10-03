<?= $this->layout('index'); ?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div style="margin-top:25px;" class="col-md-12">
                <h1>PROGRAM MBKM</h1>
                <ul class="breadcrumb">
                    <li><a href="<?= BASE_URL; ?>"><i class="fas fa-home"></i><?= $this->e($front_home); ?></a></li>
                    <li><a href="#"><?= $this->e($program['title']); ?></a></li>

                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<div class="blog-area full-blog right-sidebar single-blog full-blog default-padding">
    <div class="container">
        <div class="row">
            <div class="blog-items">
                <div class="blog-content col-md-8">
                    <?php if ($this->e($program['picture']) != '') { ?>
                    <div class="col-md-12" style="margin-bottom:30px;">
                        <img src="<?= BASE_URL . '/' . DIR_CON . '/uploads/' . $this->e($program['picture']); ?>"
                            alt="" />
                    </div>
                    <?php } ?>
                    <div class="wprt-spacer" data-desktop="30" data-mobi="25" data-smobi="25"></div>
                    <div class="col-md-12">
                        <?= htmlspecialchars_decode(html_entity_decode($this->e($program['content']))); ?>
                    </div>
                </div>
                <?= $this->insert('sidebar'); ?>
            </div>

        </div>

    </div>
</div>