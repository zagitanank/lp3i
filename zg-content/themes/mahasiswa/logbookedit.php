<?=$this->layout('index');?>
<?php 
 
$current_akun = $this->pocore()->call->podb->from('mbkm_peserta')->where('nim', $_SESSION['namauser_member'])->where('periode', $this->e($tahun_akademik))->limit(1)->fetch(); 
$mbkm_bkp = $this->pocore()->call->podb->from('mbkm_jenis')->where('id', $current_akun['jenis_mbkm'])->limit(1)->fetch(); 
$mbkm_kat = $this->pocore()->call->podb->from('mbkm_kategori')->where('mbkm_kategori_id', $mbkm_bkp['mbkm_kategori'])->limit(1)->fetch(); 
?>
<style>
.center-image {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
}

.form-input-image {
    /* width:100px; */
    padding: 3px;
    padding-bottom: 0px;
    background: #fff;
    border: 2px dashed dodgerblue;
}

.form-input-image input {
    display: none;
}

.form-input-image label {
    display: block;
    /* width:100px; */
    height: auto;
    max-height: 100px;
    background: #333;
    border-radius: 10px;
    cursor: pointer;
    margin-bottom: 2px !important;
}

.form-input-image img {
    width: 100%;
    height: 100px;
    margin: 2px;
    opacity: .4;
}

.imgRemove {
    position: relative;
    bottom: 114px;
    left: 70%;
    background-color: transparent;
    border: none;
    font-size: 30px;
    outline: none;
}

.imgRemove::after {
    content: ' \21BA';
    color: #fff;
    font-weight: 900;
    border-radius: 8px;
    cursor: pointer;
}

textarea~span {
    display: block;
    font-size: small;
    color: #666;
}
</style>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Detail Log Book</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Assesment</li>
                        <li class="breadcrumb-item">Log Book</li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body add-post">

                            <div class="row starter-main mb-3">
                                <div class="col">
                                    <div class="alert alert-primary inverse" role="alert"><i class="icon-info-alt"></i>
                                        <h5>Catatan!</h5>
                                        <p>Isilah instrumen berikut berdasarkan informasi sebenarnya. Tanda <span
                                                class="text-danger">*</span> wajib diisi!</p>
                                    </div>
                                </div>
                            </div>

                            <?=htmlspecialchars_decode($this->e($alertmsg));?>
                            <form method="post" action="<?=BASE_URL;?>/mahasiswa/logbook/edit/<?=$this->e($id);?>"
                                enctype="multipart/form-data" class="row g-3 needs-validation custom-input"
                                id="formInput" novalidate="">
                                <div class="form theme-form">
                                    <div class="alert alert-light-dark light alert-dismissible fade show text-dark border-left-wrapper"
                                        role="alert">
                                        <strong>Informasi Dasar</strong>
                                        <?=$this->pocore()->call->pohtml->inputHidden(array('name' => 'id', 'value' => $this->e($id), 'options' => ''));?>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Tanggal Kegiatan <span class="text-danger">*</span></label>
                                                <input class="form-control digits" type="date" name="tanggal_kegiatan"
                                                    id="tanggal" value="<?=$user['logbook_tanggal_kegiatan']?>"
                                                    placeholder="Hari-Bulan-Tahun (DD-MM-YYYY)" required>
                                                <div class="invalid-tooltip">Harus diisi.</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label>Jam Kerja Mulai <span class="text-danger">*</span></label>
                                                <input class="form-control" type="time" name="jam_awal"
                                                    id="twenty-four-hour" placeholder="Jam:Menit (hh:mm)"
                                                    value="<?=$user['logbook_jam_kerja_awal']?>" required>
                                                <div class="invalid-tooltip">Harus diisi.</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label>Jam Kerja Selesai <span class="text-danger">*</span></label>
                                                <input class="form-control digits" type="time" name="jam_akhir"
                                                    id="twenty-four-hour" placeholder="hh:mm"
                                                    value="<?=$user['logbook_jam_kerja_akhir']?>" required>
                                                <div class="invalid-tooltip">Harus diisi.</div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="alert alert-light-dark light alert-dismissible fade show text-dark border-left-wrapper"
                                        role="alert">
                                        <strong>Deskripsi Kegiatan</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label>
                                                    1. Deskripsikan Kegiatan harian Anda dengan merujuk (memiliki salah
                                                    satu/Lebih) pada capaian bentuk Kegiatan pembelajaran di bawah ini:
                                                    <span class="text-danger">*</span><br>
                                                    <ol type="a">
                                                        <li>Menghasilkan lulusan berkepribadian pembelajar yang
                                                            bermoral,dan berakhlak mulia.</li>
                                                        <li>Menghasilkan lulusan berkepribadian pembelajar yang
                                                            berintegritas, mandiri, dan berkebinekaan global.</li>
                                                        <li>Menghasilkan lulusan berkepribadian pembelajar yang kreatif
                                                            dan kritis.</li>
                                                        <li>Menghasilkan lulusan berkepribadian pembelajar yang
                                                            inovatif, kolaboratif, dan komunikatif.</li>
                                                        <li>Menghasilkan lulusan berkepribadian pembelajar yang adaptif
                                                            berlandaskan pada penguasan ilmu pengetahuan dan teknologi.
                                                        </li>
                                                    </ol>
                                                    <!--Centered modal-->
                                                    <button class="btn btn-info" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter1">Lihat Contoh Isian
                                                    </button>
                                                    <div class="modal fade" id="exampleModalCenter1" tabindex="-1"
                                                        aria-labelledby="exampleModalCenter1" style="display: none;"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myExtraLargeModal">
                                                                        Contoh Isian Pertama</h4>
                                                                    <button class="btn-close py-0" type="button"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="modal-toggle-wrapper">
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Hari ini,
                                                                            tanggal 1 Agustus 2023, saya turut
                                                                            menghadiri acara sosialisasi pembuatan
                                                                            website desa, bersama kepala desa dan tokoh
                                                                            masyarakat setempat. Sebagai mahasiswa saya
                                                                            merasa bangga untuk berkontribusi positif di
                                                                            tengah-tengah masyarakat. Saya yakin bahwa
                                                                            peran kami sangat penting dalam membawa
                                                                            perubahan yang positif. Kami memiliki
                                                                            kemampuan untuk menghadirkan ide-ide segar
                                                                            dan inovatif, serta memobilisasi masyarakat
                                                                            untuk bekerja bersama menuju kemajuan desa.
                                                                        </p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Dalam acara
                                                                            tersebut, saya berbicara tentang pentingnya
                                                                            memanfaatkan teknologi dan internet untuk
                                                                            membantu masyarakat di desa. Melalui website
                                                                            desa, kami dapat menghadirkan informasi yang
                                                                            lebih mudah diakses oleh seluruh warga,
                                                                            mulai dari kegiatan desa, agenda acara,
                                                                            hingga program pemerintahan dan kebijakan
                                                                            yang sedang berlangsung.</p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Kolaborasi
                                                                            antara kami, mahasiswa, dan masyarakat
                                                                            setempat menjadi kunci keberhasilan proyek
                                                                            ini. Saya bersama teman-teman mahasiswa
                                                                            lainnya bekerja sama dengan kepala desa dan
                                                                            tokoh masyarakat dalam mengumpulkan data dan
                                                                            informasi penting untuk mengisi konten
                                                                            website desa.</p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Dengan
                                                                            kecakapan teknologi yang kami miliki, kami
                                                                            berhasil membuat website desa yang menarik
                                                                            dan informatif. Kami memberikan pelatihan
                                                                            kepada masyarakat tentang cara menggunakan
                                                                            website ini sehingga mereka dapat dengan
                                                                            mudah mengakses informasi yang diperlukan.
                                                                        </p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Melalui acara
                                                                            ini, saya berharap bahwa kehadiran website
                                                                            desa akan membawa dampak positif bagi
                                                                            masyarakat, seperti meningkatkan kesadaran
                                                                            akan program-program pembangunan, mendukung
                                                                            partisipasi aktif dalam kegiatan desa, dan
                                                                            membantu perekonomian lokal dengan
                                                                            mengenalkan produk-produk unggulan desa
                                                                            secara daring.</p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Saya berbangga
                                                                            menjadi bagian dari perubahan ini dan
                                                                            berkomitmen untuk terus mendukung dan
                                                                            berkontribusi dalam upaya memajukan desa
                                                                            yang menjadi lokasi KKN-T kami. Sebagai
                                                                            mahasiswa, kami percaya bahwa perubahan
                                                                            nyata dimulai dari langkah kecil yang
                                                                            dilakukan bersama-sama dengan integritas,
                                                                            kolaborasi, dan kecakapan teknologi.</p>
                                                                        <button class="btn btn-secondary d-flex m-auto"
                                                                            type="button"
                                                                            data-bs-dismiss="modal">Tutup</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                                <textarea class="form-control" name="deskripsi_1" rows="10"
                                                    word-limit="true" max-words="300" min-words="100"
                                                    required><?=$user['logbook_deskripsi_kegiatan_1']?></textarea>
                                                <span class="words"></span>
                                                <div class="writing_error text-danger"></div>
                                                <div class="invalid-tooltip">Harus diisi.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label>2. Deskripsikan target pencapaian kegiatan hari ini: <span
                                                        class="text-danger">*</span><br>
                                                    <button class="btn btn-info" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter2">Lihat Contoh Isian
                                                    </button>
                                                    <div class="modal fade" id="exampleModalCenter2" tabindex="-1"
                                                        aria-labelledby="exampleModalCenter2" style="display: none;"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myExtraLargeModal">
                                                                        Contoh Isian Kedua</h4>
                                                                    <button class="btn-close py-0" type="button"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="modal-toggle-wrapper">
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Hari ini,
                                                                            melalui sosialisasi pembuatan website desa,
                                                                            kami berhasil mencapai sejumlah target
                                                                            penting. Kehadiran kepala desa dan tokoh
                                                                            masyarakat memberikan dukungan yang kuat
                                                                            terhadap inisiatif kami. Para peserta
                                                                            sosialisasi sangat antusias dan tertarik
                                                                            dengan konsep website desa sebagai alat
                                                                            komunikasi dan informasi.</p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Selama sesi
                                                                            sosialisasi, kami berhasil menjelaskan
                                                                            dengan jelas manfaat dan tujuan dari website
                                                                            desa ini. Para peserta mulai memahami
                                                                            potensi besar yang dapat dimanfaatkan untuk
                                                                            meningkatkan partisipasi masyarakat dan
                                                                            transparansi pemerintahan desa. Beberapa
                                                                            pertanyaan teknis dijawab dengan baik,
                                                                            menunjukkan bahwa peserta tertarik untuk
                                                                            memahami seluk-beluk teknologi ini.</p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Selain itu,
                                                                            kami berhasil membentuk tim kerja yang
                                                                            terdiri dari beberapa tokoh masyarakat dan
                                                                            mahasiswa yang berkomitmen untuk
                                                                            mengembangkan website desa ini. Kolaborasi
                                                                            antara mahasiswa dan tokoh masyarakat
                                                                            menjadi kunci keberhasilan, dengan berbagai
                                                                            pandangan yang beragam namun saling
                                                                            melengkapi.</p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Kami juga
                                                                            berhasil mengidentifikasi sumber daya yang
                                                                            diperlukan untuk memulai pengembangan
                                                                            website desa ini, termasuk pengetahuan
                                                                            teknis dan konten yang akan dimasukkan.
                                                                            Sejumlah langkah konkrit telah diambil untuk
                                                                            memulai proses pembuatan, dan kami merasa
                                                                            optimis bahwa target utama kami untuk
                                                                            meningkatkan akses informasi dan partisipasi
                                                                            masyarakat melalui website desa ini akan
                                                                            tercapai dalam waktu yang relatif singkat.
                                                                        </p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Secara
                                                                            keseluruhan, sosialisasi ini telah membawa
                                                                            kami langkah lebih dekat menuju mewujudkan
                                                                            visi kami untuk desa yang lebih terhubung,
                                                                            transparan, dan maju secara teknologi.</p>
                                                                        <button class="btn btn-secondary d-flex m-auto"
                                                                            type="button"
                                                                            data-bs-dismiss="modal">Tutup</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                                <textarea class="form-control" name="deskripsi_2" rows="10"
                                                    word-limit="true" max-words="300" min-words="100"
                                                    required><?=$user['logbook_deskripsi_kegiatan_2']?></textarea>
                                                <span class="words"></span>
                                                <div class="writing_error text-danger"></div>
                                                <div class="invalid-tooltip">Harus diisi.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label>3. Refleksi keseluruhan aktivitas hari ini: <span
                                                        class="text-danger">*</span>
                                                    <br>
                                                    <button class="btn btn-info" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter3">Lihat Contoh Isian
                                                    </button>
                                                    <div class="modal fade" id="exampleModalCenter3" tabindex="-1"
                                                        aria-labelledby="exampleModalCenter3" style="display: none;"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myExtraLargeModal">
                                                                        Contoh Isian Ketiga</h4>
                                                                    <button class="btn-close py-0" type="button"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="modal-toggle-wrapper">
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Setelah
                                                                            melaksanakan kegiatan sosialisasi pembuatan
                                                                            website desa hari ini, saya merasa sangat
                                                                            bersemangat dan juga menyadari adanya
                                                                            beberapa aspek yang perlu diperbaiki di masa
                                                                            mendatang.</p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Salah satu
                                                                            kelebihan yang paling mencolok adalah
                                                                            dukungan dan antusiasme yang ditunjukkan
                                                                            oleh kepala desa dan tokoh masyarakat.
                                                                            Kehadiran mereka memberikan legitimasi dan
                                                                            dorongan positif terhadap inisiatif kami.
                                                                            Selain itu, berhasilnya kami menjelaskan
                                                                            konsep dan manfaat website desa kepada
                                                                            peserta sosialisasi adalah pencapaian besar
                                                                            lainnya. Kemampuan kami dalam
                                                                            mengkomunikasikan ide kompleks tentang
                                                                            teknologi kepada audiens yang beragam
                                                                            merupakan hal yang patut disyukuri.</p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Namun, ada
                                                                            beberapa kekurangan yang perlu diperbaiki ke
                                                                            depan. Pertama, kami mungkin perlu lebih
                                                                            mempertimbangkan cara penyampaian informasi
                                                                            yang lebih interaktif dan terlibat. Meskipun
                                                                            peserta sosialisasi tertarik, beberapa di
                                                                            antara mereka mungkin merasa lebih nyaman
                                                                            jika diberi kesempatan untuk berpartisipasi
                                                                            aktif, misalnya melalui sesi tanya jawab
                                                                            atau diskusi kelompok. Kedua, kami perlu
                                                                            lebih merinci rencana pengembangan website
                                                                            desa agar lebih terstruktur dan dapat
                                                                            diikuti dengan lebih baik oleh semua pihak
                                                                            yang terlibat.</p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Untuk
                                                                            memperbaiki aspek-aspek ini, rencana ke
                                                                            depan kami adalah mengadakan sesi interaktif
                                                                            lebih banyak dalam sosialisasi berikutnya.
                                                                            Kami juga akan mencari cara untuk lebih
                                                                            melibatkan peserta, sehingga mereka merasa
                                                                            memiliki kontribusi dalam proses pembuatan
                                                                            website desa. Selain itu, kami akan
                                                                            merancang rencana pengembangan yang lebih
                                                                            terinci dan merinci langkah-langkah yang
                                                                            harus diambil, sehingga semua pihak memiliki
                                                                            gambaran yang lebih jelas tentang apa yang
                                                                            perlu dilakukan.</p>
                                                                        <p class="modal-padding-space mb-0"
                                                                            style="text-align: justify;">Secara
                                                                            keseluruhan, hari ini adalah langkah awal
                                                                            yang positif menuju perubahan di desa kami
                                                                            melalui teknologi. Dengan refleksi ini dan
                                                                            upaya perbaikan yang direncanakan, saya
                                                                            yakin bahwa kami dapat mengatasi
                                                                            kekurangan-kekurangan tersebut dan mencapai
                                                                            tujuan kami dalam memajukan desa melalui
                                                                            website yang informatif dan partisipatif.
                                                                        </p>
                                                                        <button class="btn btn-secondary d-flex m-auto"
                                                                            type="button"
                                                                            data-bs-dismiss="modal">Tutup</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                                <textarea class="form-control" name="deskripsi_3" rows="10"
                                                    word-limit="true" max-words="300" min-words="100"
                                                    required><?=$user['logbook_deskripsi_kegiatan_3']?></textarea>

                                                <span class="words"></span>
                                                <div class="writing_error text-danger"></div>
                                                <div class="invalid-tooltip">Harus diisi.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-light-dark light alert-dismissible fade show text-dark border-left-wrapper"
                                        role="alert">
                                        <p>

                                            <strong>Lampiran Dokumentasi</strong>
                                            <br>
                                            1. Sematkan 3 foto dokumentasi kegiatan<br>
                                            2. Klik icon &#8634; untuk mengganti foto kegiatan
                                        </p>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="center-image">
                                                <div class="form-input-image">
                                                    <label for="file-ip-1">
                                                        <img id="file-ip-1-preview"
                                                            src="<?= BASE_URL.'/'.DIR_CON; ?>/logbook/<?= $user['logbook_deskripsi_kegiatan_foto_1']; ?>">
                                                        <button type="button" class="imgRemove"
                                                            onclick="myImgRemove(1)"></button>
                                                    </label>
                                                    <input type="file" name="img_one" id="file-ip-1" accept="image/*"
                                                        onchange="showPreview(event, 1);">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- ************************************************************************************************************ -->
                                        <div class="col-md-4">
                                            <div class="center-image">
                                                <div class="form-input-image">
                                                    <label for="file-ip-2">
                                                        <img id="file-ip-2-preview"
                                                            src="<?= BASE_URL.'/'.DIR_CON; ?>/logbook/<?= $user['logbook_deskripsi_kegiatan_foto_2']; ?>">
                                                        <button type="button" class="imgRemove"
                                                            onclick="myImgRemove(2)"></button>
                                                    </label>
                                                    <input type="file" name="img_two" id="file-ip-2" accept="image/*"
                                                        onchange="showPreview(event, 2);">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ************************************************************************************************************ -->
                                        <div class="col-md-4">

                                            <div class="center-image">
                                                <div class="form-input-image">
                                                    <label for="file-ip-3">
                                                        <img id="file-ip-3-preview"
                                                            src="<?= BASE_URL.'/'.DIR_CON; ?>/logbook/<?= $user['logbook_deskripsi_kegiatan_foto_3']; ?>">
                                                        <button type="button" class="imgRemove"
                                                            onclick="myImgRemove(3)"></button>
                                                    </label>
                                                    <input type="file" name="img_three" id="file-ip-3" accept="image/*"
                                                        onchange="showPreview(event, 3);">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- *********************************************************************************************************** -->


                                    </div>

                                </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col">
                                    <div class="text-center"><button type="submit" class="btn btn-success me-3 simpan"
                                            id="btnSimpan">Simpan Pembaruan</button><a class="btn btn-danger"
                                            href="<?=BASE_URL?>/mahasiswa/logbook">Kembali</a></div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
</div>

<script>
window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}, false);

var number = 1;
do {
    function showPreview(event, number) {
        if (event.target.files.length > 0) {
            let src = URL.createObjectURL(event.target.files[0]);
            let preview = document.getElementById("file-ip-" + number + "-preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }

    function myImgRemove(number) {
        document.getElementById("file-ip-" + number + "-preview").src =
            "<?=BASE_URL.'/'.DIR_INC?>/images/image_pilih.png";
        document.getElementById("file-ip-" + number).value = null;
    }
    number++;
}
while (number <= 3);


window.addEventListener("DOMContentLoaded", function(e) {
    $('#formInput').submit(function(e) {
        $('#btnSimpan').attr('disabled', true);
        $('#btnSimpan').html('<i class="fa fa-spin fa-spinner mr-2"></i> Proses Simpan');
    });

    // Cycle through each textarea and add placeholder with individual word limits
    $("textarea[word-limit=true]").each(function() {
        $(this).attr("placeholder", "Isi deskripsi: Minimal" + $(this).attr("min-words") +
            " kata dan Maksimal " + $(this).attr("max-words") + " kata");
    });


    // Add event trigger for change to textareas with limit
    $(document).on("input", "textarea[word-limit=true]", function() {



        // Get individual limits
        thisMin = parseInt($(this).attr("min-words"));
        thisMax = parseInt($(this).attr("max-words"));

        // Create array of words, skipping the blanks
        var removedBlanks = [];
        removedBlanks = $(this).val().split(/\s+/).filter(Boolean);

        // Get word count
        var wordCount = removedBlanks.length;

        // Remove extra words from string if over word limit
        if (wordCount > thisMax) {

            // Trim string, use slice to get the first 'n' values
            var trimmed = removedBlanks.slice(0, thisMax).join(" ");

            // Add space to ensure further typing attempts to add a new word (rather than adding to penultimate word)
            $(this).val(trimmed + " ");

        }


        // Compare word count to limits and print message as appropriate
        if (wordCount < thisMin) {
            $(this).parent().children(".words").text(wordCount + " kata terinput");
            $(this).parent().children(".writing_error").text("Silahkan input kegiatan minimal " +
                thisMin + ".");
            // $(this).parent().children("textarea.form-control").addClass('is-invalid');
            $(this).parent().children("textarea.form-control").addClass('is-invalid');
            $(this).parent().children("textarea.form-control").removeClass('is-valid');
            $('.simpan').prop('disabled', true);

        } else if (wordCount > thisMax) {
            $(this).parent().children(".words").text(wordCount + " kata terinput");
            $(this).parent().children(".writing_error").text("Silahkan input kegiatan maksimal " +
                thisMax + ".");
            $(this).parent().prop('disabled', true);
            $(this).parent().children("textarea.form-control").addClass('is-invalid');
            $(this).parent().children("textarea.form-control").removeClass('is-valid');
        } else {
            $(this).parent().children(".words").text("");
            // No issues, remove warning message
            $(this).parent().children(".writing_error").text("");
            $('.simpan').prop('disabled', false);
            $(this).parent().children("textarea.form-control").addClass('is-valid');
            $(this).parent().children("textarea.form-control").removeClass('is-invalid');


        }

    });

});
</script>