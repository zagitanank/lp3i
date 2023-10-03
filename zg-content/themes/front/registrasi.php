<?=$this->layout('index');?>

<!-- Start Breadcrumb 
    ============================================= -->
<div class="breadcrumb-area shadow dark text-center bg-fixed text-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?=$this->e($front_registrasi);?></h1>
                <ul class="breadcrumb">
                    <li><a href="<?=BASE_URL;?>"><i class="fas fa-home"></i> <?=$this->e($front_home);?></a></li>
                    <li><a href="#"><?=$this->e($front_registrasi);?></a></li>
                    <li class="active">MBKM UNIFA</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Registration & Faq 
    ============================================= -->
<div class="reg-area inc-faq default-padding">
    <div class="container">
        <div class="row">
            <div class="reg-items">
                <div class="col-md-6 reg-form">
                    <div class="reg-box text-light">
                        <h3>PENDAFTRAN AKUN MBKM</h3>
                        <form action="#">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Name" type="text">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Email*" type="email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select>

                                            <option value="2">Dosen</option>
                                            <option value="3">Mahasiswa</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Phone" type="text">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit">
                                        Rigister Now
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 faq-items">
                    <div class="site-heading text-left">
                        <h2>PETUNJUK BUAT AKUN !</h2>
                    </div>
                    <!-- Start Accordion -->
                    <div class="acd-items acd-arrow">
                        <div class="panel-group symb" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#ac1">
                                            Do I need a business plan?
                                        </a>
                                    </h4>
                                </div>
                                <div id="ac1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <p>- Tanda * harus diisi.</p>
                                        <p>- Silahkan mengisi seluruh form buat akun yang disebelah kanan, sesuai dengan
                                            data pendaftar.</p>
                                        <p>- Setelah berhasil melakukan pengisian form buat akun, maka akan ada
                                            pemberitahun untuk mengecek pesan pada email yang telah didaftarkan. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#ac2">
                                            How long should a business plan be?
                                        </a>
                                    </h4>
                                </div>
                                <div id="ac2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>
                                            He in just mr door body held john down he. So journey greatly or garrets.
                                            Draw door kept do so come on open mean. Estimating stimulated how reasonably
                                            precaution diminution she simplicity sir but. Questions am sincerity
                                            zealously concluded consisted or no gentleman it.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#ac3">
                                            What goes into a business plan?
                                        </a>
                                    </h4>
                                </div>
                                <div id="ac3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>
                                            She wholly fat who window extent either formal. Removing welcomed civility
                                            or hastened is. Justice elderly but perhaps expense six her are another
                                            passage. Full her ten open fond walk not down.For request general express
                                            unknown are.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#ac4">
                                            Where do I start?
                                        </a>
                                    </h4>
                                </div>
                                <div id="ac4" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>
                                            He in just mr door body held john down he. So journey greatly or garrets.
                                            Draw door kept do so come on open mean. Estimating stimulated how reasonably
                                            precaution diminution she simplicity sir but. Questions am sincerity
                                            zealously concluded consisted or no gentleman it.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Accordion -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Registration & Faq  -->