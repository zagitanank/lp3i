<?=$this->layout('index');?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div style="margin-top:25px;" class="col-md-12">
                <h1 style="margin-top:25px;"><?=$this->e($page_title);?></h1>
                <ul class="breadcrumb">
                    <li><a href="<?=BASE_URL;?>"><i class="fas fa-home"></i> <?=$this->e($front_home);?></a></li>

                    <li class="active"><?=$this->e($page_title);?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- End Breadcrumb -->
<!-- Start Portfolio
    ============================================= -->
<div id="portfolio" class="portfolio-area default-padding">
    <div class="container">
        <div class="portfolio-items-area text-center">
            <div class="row">
                <div class="col-md-12 portfolio-content">

                    <!-- End Mixitup Nav-->

                    <div class="row magnific-mix-gallery masonary text-light">
                        <div id="portfolio-grid" class="portfolio-items col-3">
                            <?php
                                $albums = $this->gallery()->getAlbum('8', 'id_album ASC', $this->e($page));
                                foreach($albums as $alb){
                                ?>
                            <div class="pf-item students">
                                <div class="item-effect">
                                    <img src="<?=$this->asset('/assets/img/unifa.jpg');?>" alt="thumb" />

                                    <div class="overlay">

                                        <a href="<?=BASE_URL.'/gallery/'.$this->e($alb['seotitle']);?>"><i
                                                class="fas fa-link"></i></a>
                                    </div>
                                </div>
                                <h3 style="margin-top:10px;"><a
                                        href="<?=BASE_URL.'/gallery/'.$this->e($alb['seotitle']);?>">
                                        <font color="#003679"><?=$alb['title'];?></font>
                                    </a></h3>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center" style="margin-top:10px;">
                    <ul class="pagination nobottommargin">
                        <?=$this->gallery()->getAlbumPaging('8', $this->e($page), '1', $this->e($front_paging_prev), $this->e($front_paging_next));?>
                    </ul>
                </div>
                <script type="text/javascript">
                jQuery(window).load(function() {
                    var $container = $('#portfolio');
                    $container.isotope({
                        transitionDuration: '0.65s'
                    });
                    $(window).resize(function() {
                        $container.isotope('layout');
                    });
                });
                </script>
            </div>
        </div>
    </div>
</div>
<!-- End Portfolio -->