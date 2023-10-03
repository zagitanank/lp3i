<?=$this->layout('index');?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div style="margin-top:25px;" class="col-md-12">
                <h1><?=$this->e($front_contact);?></h1>
                <ul class="breadcrumb">
                    <li><a href="<?=BASE_URL;?>"><i class="fas fa-home"></i> <?=$this->e($front_home);?></a></li>
                    <li><a href="#"><?=$this->e($front_contact);?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Contact Info
    ============================================= -->
<div class="contact-info-area default-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 maps">
                <h3>Peta Lokasi</h3>
                <div class="google-maps">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.716450012379!2d119.44789701395999!3d-5.149266853486082!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbee2cf779ae6f9%3A0xf3313594dcc8f9ba!2sUniversitas%20Fajar!5e0!3m2!1sid!2sid!4v1643977411278!5m2!1sid!2sid"
                        style="width:100%;" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <!-- End Maps & Contact Form -->
        </div>

        <div class="seperator col-md-12">
            <span class="border"></span>
        </div>


        <div class="row">
            <!-- Start Contact Info -->
            <div class="contact-info">
                <div class="col-md-4 col-sm-4">
                    <div class="item">
                        <div class="icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="info">
                            <h4>TELEPON</h4>
                            <span></strong></abbr> <?=$this->pocore()->call->posetting[6]['value'];?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="item">
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info">
                            <h4>ALAMAT</h4>
                            <span><?=htmlspecialchars_decode($this->pocore()->call->posetting[8]['value']);?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="item">
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info">
                            <h4>EMAIL</h4>
                            <span><?=$this->pocore()->call->posetting[5]['value'];?></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Contact Info -->





        </div>
    </div>
</div>
<!-- End Contact Info -->