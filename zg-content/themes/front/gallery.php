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
<!-- Start Portfolio
    ============================================= -->
<div id="portfolio" class="portfolio-area default-padding">
    <div class="container">
        <div class="portfolio-items-area text-center">
            <div class="row">
                <div class="col-md-12 portfolio-content">


                    <div class="row magnific-mix-gallery masonary text-light">
                        <div id="portfolio-grid" class="portfolio-items col-3">
                            <?php
                                $gallerys = $this->gallery()->getGallery('12', 'id_gallery DESC', $album, $this->e($page));
                                foreach($gallerys as $gal){
                                ?>
                            <div class="pf-item">
                                <div class="item-effect">
                                    <img src="<?=BASE_URL.'/'.DIR_CON.'/uploads/medium/medium_'.$gal['picture'];?>"
                                        alt="thumb" />
                                    <div class="overlay">
                                        <a href="<?=BASE_URL.'/'.DIR_CON.'/uploads/'.$gal['picture'];?>"
                                            class="item popup-link"><i class="fa fa-expand"></i></a>

                                    </div>
                                </div>
                                <h3 style="margin-top:10px;">
                                    <font color="#003679"><?=$gal['title'];?></font>
                                </h3>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Portfolio -->