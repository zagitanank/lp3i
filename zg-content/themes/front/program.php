<?=$this->layout('index');?>

    <div class="hc-header">
        
    </div>
    
    <!-- Featured Title -->
    <div id="featured-title" class="clearfix featured-title-left">
        <div id="featured-title-inner" class="container clearfix">
            <div class="featured-title-inner-wrap">
                <div class="featured-title-heading-wrap">
                    <h1 class="featured-title-heading"><?=$this->e($layanan['title']);?></h1>
                </div>
                <div id="breadcrumbs">
                    <div class="breadcrumbs-inner">
                        <div class="breadcrumb-trail">
                            <a href="<?=BASE_URL;?>" title="<?=$this->e($front_home);?>" rel="home" class="trail-begin"><?=$this->e($front_home);?></a>
                            <span class="sep">/</span>
                            <span class="trail-end"><?=$this->e($layanan['title']);?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- OFFER -->
    <section id="features" class="wprt-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                        <div class="wprt-spacer" data-desktop="70" data-mobi="60" data-smobi="60"></div>
                            <h2 class="text-center margin-bottom-10">LAYANAN KAMI</h2>
                        <div class="wprt-lines style-2 custom-1">
                        <div class="line-1"></div>
                        </div>

                    <div class="wprt-spacer" data-desktop="50" data-mobi="40" data-smobi="40"></div>
                </div><!-- /.col-md-12 -->
                    <?php
                    $layanan = $this->layanan()->getRecentLayanan('6','DESC', WEB_LANG_ID);
                    foreach($layanan as $layan){
                    ?>
                    <div class="col-md-4">
                            <div class="wprt-icon-box outline icon-effect-3 icon-left">
                                <div class="icon-wrap font-size-35 tes">
                                     <span class="dd-icon fa fa-balance-scale"></span>
                                </div>
                                <div class="content-wrap">
                                            <h3 class="dd-title font-size-18"><a href="<?=BASE_URL;?>/detaillayanan/<?=$layan['seotitle'];?>"></a><?=$layan['title'];?></h3>
                                            <p> <?=$this->pocore()->call->postring->cuthighlight('post', $layan['content'], '60');?>...</p>
                                        <div class="dd-link dark"><a href="<?=BASE_URL;?>/detaillayanan/<?=$layan['seotitle'];?>">READ MORE</a></div>
                                </div>
                            </div>

                            <div class="wprt-spacer" data-desktop="45" data-mobi="30" data-smobi="30"></div>
                    </div><!-- /.col-md-4 -->
                    <?php } ?>
                    <div class="col-md-12">
                        <div class="wprt-spacer" data-desktop="80" data-mobi="60" data-smobi="50"></div>
                    </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>