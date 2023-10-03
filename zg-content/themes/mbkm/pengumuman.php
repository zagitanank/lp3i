<?=$this->layout('index');?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div style="margin-top:25px;" class="col-md-12">
                <h1><?=$this->e($page_title);?></h1>
                <ul class="breadcrumb">
                    <li><a href="<?=BASE_URL;?>"><i class="fas fa-home"></i> <?=$this->e($front_home);?></a></li>
                    <li><a href="#"><?=$this->e($page_title);?></a></li>
                    <li class="active">MBKM UNIFA</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Popular Courses 
    ============================================= -->
<div class="popular-courses default-padding bottom-less without-carousel">
    <div class="container">
        <div class="row">
            <div class="popular-courses-items bottom-price">
                <!-- Single Item -->
                <?php
                        $pengumuman = $this->pengumuman()->getRecentPengumuman('6','DESC', WEB_LANG_ID);
                        foreach($pengumuman as $pengu){
                    ?>
                <div class="col-md-4 col-sm-6 equal-height">
                    <div class="item">
                        <div class="thumb">
                            <a href="<?=BASE_URL;?>/<?=DIR_CON;?>/uploads/<?=$pengu['picture'];?>">
                                <img src="<?=BASE_URL;?>/<?=DIR_CON;?>/uploads/<?=$pengu['picture'];?>" alt="Thumb">
                            </a>

                        </div>
                        <div class="info">

                            <h4><a
                                    href="<?=BASE_URL;?>/<?=DIR_CON;?>/uploads/<?=$pengu['picture'];?>"><?=$pengu['title'];?></a>
                            </h4>

                            <p><?=$this->pocore()->call->postring->cuthighlight('post', $pengu['content'], '100');?>...
                            </p>
                            <div class="bottom-info">
                                <ul>
                                    <li>
                                        <i class="fas fa-clock"></i>
                                        <?=$this->pocore()->call->podatetime->tgl_indo($pengu['publishdate']);?>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
                <?php } ?>


            </div>

        </div>
    </div>
</div>
<!-- End Popular Courses -->