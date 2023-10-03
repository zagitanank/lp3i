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

                    <li class="active"><?=$this->e($page_title);?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<div id="portfolio" class="portfolio-area default-padding">
    <div class="container">
        <div class="portfolio-items-area text-center">
            <div class="row">
                <div class="col-md-12 portfolio-content">
                    <div class="row magnific-mix-gallery masonary text-light">

                        <div id="portfolio-grid" class="portfolio-items col-3">
                            <?php
									$videos = $this->pocore()->call->podb->from('video')
										->orderBy('id_video')
										->limit('8')
										->fetchAll();
									foreach($videos as $video){
								?>
                            <div class="pf-item">
                                <div class="item-effect">
                                    <iframe src="<?=$video['url'];?>" width="360" height="240" frameborder="0"
                                        webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

                                </div>
                                <?=$video['title'];?>
                            </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>

                <div class="col-md-12 pagi-area text-center" style="margin-top:30px;">
                    <nav aria-label="navigation">
                        <ul class="pagination">
                            <?php
                                    $totaldata = $this->pocore()->call->podb->from('video')->count();
                                    $totalpage = $this->pocore()->call->popaging->totalPage($totaldata, '8');
                                    echo $this->pocore()->call->popaging->navPage($this->e($page), $totalpage, BASE_URL, 'video', 'page', '1', $this->e($front_paging_prev), $this->e($front_paging_next));
                                ?>
                        </ul>
                    </nav>
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