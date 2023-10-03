<?=$this->layout('index');?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div style="margin-top:25px;" class="col-md-12">
                <h1>AGENDA</h1>
                <ul class="breadcrumb">
                    <li><a href="<?=BASE_URL;?>"><i class="fas fa-home"></i><?=$this->e($front_home);?></a></li>
                    <li><a href="#">AGENDA</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Course Details 
    ============================================= -->
<div class="course-details-area default-padding">
    <div class="container">
        <div class="row">
            <div class="blog-content col-md-8">
                <div class="course-details-info">
                    <!-- Star Top Info -->
                    <div class="top-info">
                        <!-- Title-->
                        <div class="title">
                            <h2><?=$agenda['title'];?></h2>
                        </div>
                        <!-- End Title-->

                        <!-- Thumbnail -->
                        <div class="thumb">
                            <img src="<?=BASE_URL;?>/<?=DIR_CON;?>/uploads/<?=$agenda['picture'];?>" alt="">
                        </div>
                        <!-- End Thumbnail -->

                        <!-- Course Meta -->
                        <div class="course-meta">

                            <div class="item category">
                                <h4><?=$this->post()->getAuthorName($agenda['editor']);?></h4>
                                <a href="#">Di Post</a>
                            </div>
                            <div class="item rating">
                                <h4><?=$this->pocore()->call->podatetime->tgl_indo($agenda['publishdate']);?></h4>
                                <span>Waktu Post</span>
                            </div>
                            <div class="item price">
                                <h4><?=$agenda['hits'];?></h4>
                                <span>Dilihat</span>
                            </div>

                        </div>
                        <!-- End Course Meta -->
                    </div>
                    <!-- End Top Info -->

                    <!-- Star Tab Info -->
                    <div class="tab-info">

                        <!-- Start Tab Content -->
                        <div class="tab-content tab-content-info">
                            <!-- Single Tab -->
                            <div id="tab1" class="tab-pane fade active in">
                                <div class="info title">
                                    <?php
                                            $bahasa = WEB_LANG_ID;
                                            if($bahasa == '1'){
                                                $tanggal_awal_id = $this->pocore()->call->podatetime->tgl_indo_day($agenda['date_start']);
                                                $tanggal_akhir_id = $this->pocore()->call->podatetime->tgl_indo_day($agenda['date_end']);
                                                $tanggalkegiatan = "$tanggal_awal_id - $tanggal_akhir_id";
                                            }else{
                                                $tanggal_awal_en = $this->pocore()->call->podatetime->tgl_global_day($agenda['date_start']);
                                                $tanggal_akhir_en = $this->pocore()->call->podatetime->tgl_global_day($agenda['date_end']);
                                                $tanggalkegiatan = "$tanggal_awal_en - $tanggal_akhir_en";
                                            }
                                        ?>
                                    <ul>
                                        <li><i class="fas fa-clock"></i> <?=$agenda['time'];?> </li>
                                        <li><i class="far fa-calendar-alt"></i> <?=$tanggalkegiatan;?> </li>
                                        <li><i class="fas fa-map"></i> <?=$agenda['locations'];?> </li>
                                    </ul>
                                    <br />
                                    <p><?=htmlspecialchars_decode(html_entity_decode($agenda['content']));?> </p>

                                </div>
                            </div>
                            <!-- End Single Tab -->

                        </div>
                        <!-- End Tab Content -->
                    </div>
                    <!-- End Tab Info -->
                </div>
            </div>
            <!-- Sidebar -->
            <?=$this->insert('sidebar');?>
            <!-- End Sidebar -->
        </div>

    </div>
</div>
<!-- End Course Details -->