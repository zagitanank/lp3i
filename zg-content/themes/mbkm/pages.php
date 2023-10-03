<?=$this->layout('index');?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?=$this->e($pages['title']);?></h1>
                <ul class="breadcrumb">
                    <li><a href="<?=BASE_URL;?>"><i class="fas fa-home"></i><?=$this->e($front_home);?></a></li>
                    <li><a href="#"><?=$this->e($pages['title']);?></a></li>
                    <li class="active">MBKM UNIFA</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<div class="contact-info-area default-padding">
    <div class="container">
        <div class="row">

            <div>

                <?php if ($this->e($pages['picture']) != '') { ?>
                <div class="col-md-12 text-center" style="margin-bottom:30px;">
                    <img src="<?=BASE_URL.'/'.DIR_CON.'/uploads/'.$this->e($pages['picture']);?>" alt="" />
                </div>
                <?php } ?>
                <div class="wprt-spacer" data-desktop="30" data-mobi="25" data-smobi="25"></div>

                <?=htmlspecialchars_decode(html_entity_decode($this->e($pages['content'])));?>

            </div>

        </div>

    </div>
</div>