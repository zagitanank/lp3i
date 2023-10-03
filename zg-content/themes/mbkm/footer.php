<!-- Start Footer 
    ============================================= -->
<footer class="bg-dark default-padding-top text-light">
    <div class="container">
        <div class="row">
            <div class="f-items">
                <div class="col-md-4 item">
                    <div class="f-item">
                        <img src="<?=$this->asset('/assets/img/logo/kampus-merdeka-putih.png');?>" alt="Logo"
                            style="height: 50%;">
                        <p>Kampus Merdeka merupakan bagian dari kebijakan Merdeka Belajar oleh Kementerian Pendidikan,
                            Kebudayaan, Riset, dan Teknologi Republik Indonesia yang memberikan kesempaatan bagi
                            mahasiswa/i untuk mengasah kemampuan sesuai bakat dan minat dengan terjun langsung ke dunia
                            kerja sebagai persiapan karier masa depan. </p>
                        <div class="social">
                            <ul>
                                <li>
                                    <a href="https://www.facebook.com/UniversitasFajar"><i
                                            class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/UnivFajar?s=20"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="https://youtube.com/channel/UCjA6LT_z8K9VafY4hCL7LRA"><i
                                            class="fab fa-youtube"></i></a>
                                </li>
                                <li>
                                    <a href="https://instagram.com/univfajar?utm_medium=copy_link"><i
                                            class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="https://unifa.ac.id/"><i class="fab fa-dribbble"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 item">
                    <div class="f-item link">
                        <h4>Links</h4>
                        <ul>
                            <li>
                                <a href="#">Tentang Kami</a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL ?>/category/all">Berita</a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL ?>/pengumuman/all">Pengumuman</a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL ?>/agenda/all">Agenda</a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL ?>/album">Galeri</a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL ?>/contact">Kontak</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 item">
                    <div class="f-item link">
                        <h4>Support</h4>
                        <ul>
                            <li>
                                <a href="#">LMS</a>
                            </li>
                            <li>
                                <a href="#">SIAKA</a>
                            </li>
                            <li>
                                <a href="#">Web Profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 item">
                    <div class="f-item address">
                        <h4>ALAMAT</h4>
                        <ul>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <p>Email <span><?=$this->pocore()->call->posetting[5]['value'];?></span></p>
                            </li>
                            <li>
                                <i class="fas fa-map"></i>
                                <p>Kantor
                                    <span><?=htmlspecialchars_decode($this->pocore()->call->posetting[8]['value']);?></span>
                                </p>
                            </li>
                        </ul>
                        <div class="opening-info">
                            <h5>Hari Kerja</h5>
                            <ul>
                                <li> <span> Senin - Kamis : </span>
                                    <div class="pull-right"> 6.00 am - 10.00 pm </div>
                                </li>
                                <li> <span> Jumat - Sabtu :</span>
                                    <div class="pull-right"> 8.00 am - 6.00 pm </div>
                                </li>
                                <li> <span> Minggu : </span>
                                    <div class="pull-right closed"> Tutup </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Start Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <p>&copy; <?=date('Y');?>. Desain By <a href="https:/unifa.ac.id/">Politeknik LP3I MAKASSAR</a>
                        </p>
                    </div>
                    <div class="col-md-6 text-right link">
                        <ul>
                            <li>
                                <a href="#">IT SUPPORT</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom -->
</footer>
<!-- End Footer -->