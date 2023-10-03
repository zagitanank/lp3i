<?php
/*
 *
 * - Zagitanank Admin File
 *
 * - File : admin_peserta.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses admin pada halaman peserta.
 * This is a php file for handling admin process for peserta page.
 *
*/

/**
 * Fungsi ini digunakan untuk mencegah file ini diakses langsung tanpa melalui router.
 *
 * This function use for prevent this file accessed directly without going through a router.
 *
 */
if (!defined('CONF_STRUCTURE')) {
    header('location:index.html');
    exit;
}

/**
 * Fungsi ini digunakan untuk mencegah file ini diakses langsung tanpa login akses terlebih dahulu.
 *
 * This function use for prevent this file accessed directly without access login first.
 *
 */
if (empty($_SESSION['namauser']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
    header('location:index.php');
    exit;
}

class Peserta extends PoCore
{

    /**
     * Fungsi ini digunakan untuk menginisialisasi class utama.
     *
     * This function use to initialize the main class.
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Fungsi ini digunakan untuk menampilkan halaman index peserta.
     *
     * This function use for index peserta page.
     *
     */
    public function index()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'read')) {
            echo $this->pohtml->error();
            exit;
        }
        //$jmlbelum  = $this->podb->from('tpa_mengerjakan')->leftJoin('peserta ON peserta.id_peserta = tpa_mengerjakan.id_peserta')->where('peserta.tahun_ajaran', $this->posetting['30']['value'])->where('tpa_mengerjakan.status', 'Y')->count();
?>
        <div class="block-content">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->pohtml->headTitle($GLOBALS['_']['component_name'], ''); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=peserta&act=multidelete', 'autocomplete' => 'off')); ?>
                    <?= $this->pohtml->inputHidden(array('name' => 'totaldata', 'value' => '0', 'options' => 'id="totaldata"')); ?>
                    <?php
                    $columns = array(
                        array('title' => 'NIM', 'options' => 'style="width:30px;"'),
                        array('title' => 'Nama Lengkap', 'options' => ''),
                        array('title' => 'Prodi', 'options' => ''),
                        array('title' => 'TA', 'options' => 'style="width:20px;"'),
                        array('title' => 'BKP', 'options' => ''),
                        array('title' => 'Tes', 'options' => ''),
                        array('title' => 'Wawancara', 'options' => ''),
                        array('title' => 'Hasil Seleksi', 'options' => ''),
                        array('title' => 'Tindakan', 'options' => 'class="no-sort" style="width:100px;"')
                    );
                    ?>
                    <?= $this->pohtml->createTable(array('id' => 'table-peserta', 'class' => 'table table-striped table-bordered'), $columns, $tfoot = true); ?>
                    <?= $this->pohtml->formEnd(); ?>
                </div>
            </div>
        </div>
        <?= $this->pohtml->dialogDelete('peserta'); ?>
        <?= $this->pohtml->dialogPenilainWawancara('peserta'); ?>
        <?= $this->pohtml->dialogResetTPA('peserta'); ?>

    <?php
    }

    /**
     * Fungsi ini digunakan untuk menampilkan data json pada tabel.
     *
     * This function use for display json data in table.
     *
     */
    public function datatable()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'read')) {
            echo $this->pohtml->error();
            exit;
        }
        $table = 'peserta';
        $primarykey = 'id_peserta';

        $settings = $this->podb->from('setting')->fetchAll();
        $columns = array(
            array('db' => 'id_session', 'dt' => null, 'field' => 'id_session'),
            array('db' => 'wawancara_via', 'dt' => null, 'field' => 'wawancara_via'),
            array('db' => 'status_seleksi', 'dt' => null, 'field' => 'status_seleksi'),
            array('db' => 'prodi_lulus', 'dt' => null, 'field' => 'prodi_lulus'),
            array('db' => 'jalur_pendaftaran', 'dt' => null, 'field' => 'jalur_pendaftaran'),
            array('db' => 'isi_formulir', 'dt' => null, 'field' => 'isi_formulir'),
            array(
                'db' => 'peserta.id_peserta', 'dt' => '0', 'field' => 'id_peserta',
                'formatter' => function ($d, $row, $i) {
                    return "<div class='text-center'>
                        <input type='checkbox' id='titleCheckdel' />
                        <input type='hidden' class='deldata' name='item[" . $i . "][deldata]' value='" . $d . "' disabled />
                    </div>";
                }
            ),
            array('db' => 'no_peserta', 'dt' => '1', 'field' => 'no_peserta'),
            array('db' => 'va', 'dt' => '2', 'field' => 'va'),
            array(
                'db' => 'nama_lengkap_peserta', 'dt' => '3', 'field' => 'nama_lengkap_peserta',
                'formatter' => function ($d, $row, $i) {
                    $namacapital = ucwords(strtolower($row['nama_lengkap_peserta']));
                    return $namacapital;
                }
            ),
            array('db' => 'jalur_pendaftaran_nama', 'dt' => '4', 'field' => 'jalur_pendaftaran_nama'),
            array('db' => 'prodiNamaSingkat', 'dt' => '5', 'field' => 'prodiNamaSingkat'),
            array('db' => 'gelombang_daftar', 'dt' => '6', 'field' => 'gelombang_daftar'),
            array('db' => 'tahun_ajaran', 'dt' => '7', 'field' => 'tahun_ajaran'),
            array(
                'db' => 'peserta.' . $primarykey, 'dt' => '8', 'field' => $primarykey,
                'formatter' => function ($d, $row, $i) {
                    if ($row['isi_formulir'] == 'Y') {

                        return "<a href='admin.php?mod=peserta&act=form&id=" . $row['id_session'] . "' class='btn btn-xs btn-success' id='" . $d . "' data-toggle='tooltip' title='Formulir'><i class='fa fa-file'></i></a>";
                    } else {
                        return "<span class='label label-danger'>Belum Mengisi</span>";
                    }
                }
            ),
            array(
                'db' => 'peserta.' . $primarykey, 'dt' => '9', 'field' => $primarykey,
                'formatter' => function ($d, $row, $i) {
                    if ($row['jalur_pendaftaran'] == '1') {
                        $cek_sdh_ujian = $this->podb->from('tpa_mengerjakan')
                            ->select("IF((status='Y' AND NOW() BETWEEN tgl_mulai AND tgl_selesai),'Sedang Tes',
                                                   IF(status='Y' AND NOW() NOT BETWEEN tgl_mulai AND tgl_selesai,'Waktu Habis',
                                                   IF(status='N','Selesai','Belum Ikut'))) STATUS ")
                            ->where('id_peserta', $row['id_peserta'])
                            ->where('tahun_ajaran', $row['tahun_ajaran'])
                            ->fetch();
                        if ($cek_sdh_ujian['STATUS'] == 'Sedang Tes') {
                            $status = "<span class='label label-warning'>Sedang Tes</span>";
                        } else if ($cek_sdh_ujian['STATUS'] == 'Waktu Habis') {
                            $status = "<a href='admin.php?mod=peserta&act=hasiltpa&id=" . $row['id_session'] . "' class='label label-warning' data-toggle='tooltip' title='Lihat Hasil Tes'>Waktu Habis</a> <a class='label label-primary resethasiltpa' id='" . $row['id_peserta'] . "'>Reset</a>";
                        } else if ($cek_sdh_ujian['STATUS'] == 'Selesai') {
                            $status = "<a href='admin.php?mod=peserta&act=hasiltpa&id=" . $row['id_session'] . "' class='label label-success' data-toggle='tooltip' title='Lihat Hasil Tes'>Sudah Tes</a> <a class='label label-primary resethasiltpa' id='" . $row['id_peserta'] . "'>Reset</a>";
                        } else {
                            $status = "<span class='label label-danger'>Belum Tes</span>";
                        }
                        return "$status";
                    } else {
                        return "<span class='label label-info'>Bebas Tes</span>";
                    }
                }
            ),
            array(
                'db' => 'peserta.' . $primarykey, 'dt' => '10', 'field' => $primarykey,
                'formatter' => function ($d, $row, $i) {
                    $cek_wawancara = $this->podb->from('wawancara')
                        ->where('id_peserta', $row['id_peserta'])->fetch();
                    if (!empty($cek_wawancara)) {
                        if ($cek_wawancara['jadwal_sudah'] == 'N') {
                            if ($row['wawancara_via'] == NULL) {
                                $viawwc = 'ONLINE';
                            } else {
                                $viawwc = $row['wawancara_via'];
                            }
                            $status = $this->tanggal_indo($cek_wawancara['jadwal_tanggal']) . ' ' . "<br>Via" . $viawwc . " <a class='label label-primary penilaianwawancara'  data-toggle='tooltip' title='Penilaian Wawancara' id='" . $row['id_peserta'] . "'><i class='fa fa-check'></i></a>";
                        } else {
                            $status = "<a href='admin.php?mod=peserta&act=hasilwawancara&id=" . $row['id_session'] . "' class='label label-info' data-toggle='tooltip' title='Lihat Hasil Wawancara'>Sudah Wawancara</a>";
                        }
                    } else {
                        if ($row['jalur_pendaftaran'] == '3') {
                            $status = "<span class='label label-info'>Bebas Tes</span>";
                        } else {
                            $status = "-";
                        }
                    }
                    return "$status";
                }
            ),
            array(
                'db' => 'peserta.' . $primarykey, 'dt' => '11', 'field' => $primarykey,
                'formatter' => function ($d, $row, $i) {
                    $sdh_wawancara = $this->podb->from('wawancara')
                        ->where('id_peserta', $row['id_peserta'])
                        ->where('jadwal_sudah', 'Y')
                        ->fetch();
                    if ($sdh_wawancara > 0 || $row['jalur_pendaftaran'] == '3') {
                        $tombolPengumuman = "<a href='admin.php?mod=peserta&act=hasilseleksi&id=" . $row['id_session'] . "' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Penentuan Seleksi'><i class='fa fa-bullhorn'></i></a>";
                    } else {
                        $tombolPengumuman = "";
                    }
                    return "<div class='text-center'>
                                <div class='btn-group btn-group-xs'>
                                    $tombolPengumuman
                                    <a href='admin.php?mod=peserta&act=edit&id=" . $row['id_session'] . "' class='btn btn-xs btn-default' data-toggle='tooltip' title='Detail'><i class='fa fa-pencil'></i></a>
                                    <a href='admin.php?mod=peserta&act=gantipassword&id=" . $row['id_session'] . "' class='btn btn-xs btn-default' style='background:#2D1780; border-color:#2D1780;' data-toggle='tooltip' title='Ganti Password'><i class='fa fa-key'></i></a>
                                </div>
                            </div>";
                }
            ),
        );
        $joinquery = "FROM peserta JOIN jalur_pendaftaran ON jalur_pendaftaran.jalur_pendaftaran_id=peserta.jalur_pendaftaran LEFT JOIN wawancara ON wawancara.id_peserta=peserta.id_peserta LEFT JOIN program_studi ON program_studi.prodiKode=peserta.pilihan_pertama";
        $extraWhere = "peserta.tahun_ajaran='" . $settings[30]['value'] . "' AND peserta.block = 'N' AND peserta.status_seleksi is null";
        echo json_encode(SSP::simple($_POST, $this->poconnect, $table, $primarykey, $columns, $joinquery, $extraWhere));
    }


    /**
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman add kategori.
     *
     * This function is used to display and process add category page.
     *
     */
    public function form()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'update')) {
            echo $this->pohtml->error();
            exit;
        }
        $settings = $this->podb->from('setting')->fetchAll();
        if (!empty($_POST)) {
            if ($_POST['ukuran'] == "Lainnya") {
                $ukuran = $_POST['ukuranlain'];
            } else {
                $ukuran = $_POST['ukuran'];
            }
            $tanggallahir = $_POST['tahun'] . '-' . $_POST['bulan'] . '-' . $_POST['hari'];
            $tanggalwafat = $_POST['tahunwafat'] . '-' . $_POST['bulanwafat'] . '-' . $_POST['hariwafat'];
            $peserta = array(
                'jalur_pendaftaran' => $this->postring->valid($_POST['jalur'], 'xss'),
                'nama_lengkap_peserta' => $this->postring->valid($_POST['namalengkap'], 'xss'),
                'tempat_lahir_peserta_kota' => $this->postring->valid($_POST['tempat_lahir'], 'xss'),
                'tanggal_lahir_peserta' => $tanggallahir,
                'jenkel_peserta' => $this->postring->valid($_POST['jenkel'], 'xss'),
                'status_nikah_id' => $this->postring->valid($_POST['statusnikah'], 'xss'),
                'agama_peserta' => $this->postring->valid($_POST['agama'], 'xss'),
                'darah_peserta' => $this->postring->valid($_POST['darah'], 'xss'),
                'alamat_peserta_asal' => $this->postring->valid($_POST['alamat'], 'xss'),
                'alamat_peserta_asal_kota' => $this->postring->valid($_POST['kotaalamat'], 'xss'),
                'alamat_peserta_asal_kodepos' => $this->postring->valid($_POST['kodepos'], 'xss'),
                'telp_peserta' => $this->postring->valid($_POST['ponsel'], 'xss'),
                'email_peserta' => $this->postring->valid($_POST['email'], 'xss'),
                'pendidikan_peserta' => $this->postring->valid($_POST['pendidikan'], 'xss'),
                'jurusan_peserta' => $this->postring->valid($_POST['jurusan'], 'xss'),
                'nisn' => $this->postring->valid($_POST['nisn'], 'xss'),
                'tahun_lulus_peserta' => $this->postring->valid($_POST['tahunlulus'], 'xss'),
                'asal_sekolah_peserta' => $this->postring->valid($_POST['sekolahasal'], 'xss'),
                'kota_sekolah_peserta' => $this->postring->valid($_POST['kotasekolah'], 'xss'),
                'alamat_sekolah_peserta' => $this->postring->valid($_POST['alamatsekolah'], 'xss'),
                'telp_sekolah_peserta' => $this->postring->valid($_POST['telpsekolah'], 'xss'),
                'email_sekolah_peserta' => $this->postring->valid($_POST['emailsekolah'], 'xss'),
                'nama_orangtua_peserta' => $this->postring->valid($_POST['nama_ortu'], 'xss'),
                'pekerjaan_orangtua_peserta' => $this->postring->valid($_POST['pekerjaan'], 'xss'),
                'alamat_orangtua_peserta' => $this->postring->valid($_POST['alamat_ortu'], 'xss'),
                'telp_orangtua_peserta' => $this->postring->valid($_POST['telp_ortu'], 'xss'),
                'kota_orangtua_peserta' => $this->postring->valid($_POST['kotaalamatayah'], 'xss'),
                'kodepos_orangtua_peserta' => $this->postring->valid($_POST['kodeposayah'], 'xss'),
                'email_orangtua_peserta' => $this->postring->valid($_POST['emailayah'], 'xss'),
                'status_orangtua_peserta' => $this->postring->valid($_POST['statusayah'], 'xss'),
                'tanggal_wafat_orangtua_peserta' => $tanggalwafat,
                'pendidikan_orangtua_peserta' => $this->postring->valid($_POST['pendidikanortu'], 'xss'),
                'pekerjaan_orangtua_peserta' => $this->postring->valid($_POST['pekerjaan'], 'xss'),
                'penghasilan_orangtua_peserta' => $this->postring->valid($_POST['penghasilanayah'], 'xss'),
                'tanggungan_orangtua_peserta' => $this->postring->valid($_POST['tanggungan'], 'xss'),
                'agama_orangtua_peserta' => $this->postring->valid($_POST['agamaayah'], 'xss'),
                'pilihan_pertama' => $this->postring->valid($_POST['pil_pertama'], 'xss'),
                'pilihan_kedua' => $this->postring->valid($_POST['pil_kedua'], 'xss'),
                'keinginan' => $this->postring->valid($_POST['keinginan'], 'xss'),
                'ukuran_jas' => $this->postring->valid($ukuran, 'xss'),
                'informasi_mengetahui_atk' => $this->postring->valid($_POST['peroleh'], 'xss')
            );
            $query_peserta = $this->podb->update('peserta')
                ->set($peserta)
                ->where('id_peserta', $this->postring->valid($_POST['id'], 'sql'));
            $query_peserta->execute();
            $this->poflash->success('Formulir has been successfully added', 'admin.php?mod=seleksi&act=form&id=' . $_POST['idsession']);
        }
        $id = $this->postring->valid($_GET['id'], 'xss');
        $current_peserta = $this->podb->from('peserta')
            ->where('id_session', $id)
            ->limit(1)
            ->fetch();
        if (empty($current_peserta)) {
            echo $this->pohtml->error();
            exit;
        }


    ?>
        <div class="block-content">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->pohtml->headTitle($GLOBALS['_']['peserta_form']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert-info" style="padding: 20px; margin-bottom: 20px;">Tanda <span class="text-danger">*</span>
                        berarti harus diisi!</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form role="form" method="post" action="route.php?mod=peserta&act=form" enctype="multipart/form-data" autocomplete="off" id="defaultForm">
                        <?= $this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_peserta['id_peserta'])); ?>
                        <?= $this->pohtml->inputHidden(array('name' => 'kode', 'value' => $current_peserta['kode_registrasi'])); ?>
                        <?= $this->pohtml->inputHidden(array('name' => 'tahun_ajaran', 'value' => $settings[30]['value'])); ?>
                        <?= $this->pohtml->inputHidden(array('name' => 'idsession', 'value' => $current_peserta['id_session'])); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="jalur" class="col-md-3 label-inline">Jalur Pendaftaran <span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <select class="form-control " name="jalur" id="jalur" required="">
                                                <?php
                                                $current_jalur = $this->podb->from('jalur_pendaftaran')
                                                    ->where('jalur_pendaftaran_id', $current_peserta['jalur_pendaftaran'])
                                                    ->orderBy('jalur_pendaftaran_nama ASC')
                                                    ->limit('1')
                                                    ->fetch();
                                                echo "<option value='$current_jalur[jalur_pendaftaran_id]' hidden=''>$current_jalur[jalur_pendaftaran_nama]</option>";
                                                $jalur = $this->podb->from('jalur_pendaftaran')
                                                    ->orderBy('jalur_pendaftaran_nama ASC')
                                                    ->fetchAll();
                                                foreach ($jalur as $jlr) {
                                                    echo '<option value="' . $jlr['jalur_pendaftaran_id'] . '">' . strtoupper($jlr['jalur_pendaftaran_nama']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#pribadi" data-toggle="tab"><i class="fa fa-user"></i>&nbsp;&nbsp;Data Pribadi</a></li>
                                    <li><a href="#pendidikan" data-toggle="tab"><i class="fa fa-graduation-cap"></i>&nbsp;&nbsp;Pendidikan</a></li>
                                    <li><a href="#ortu" data-toggle="tab"><i class="fa fa-group"></i>&nbsp;&nbsp;Orang Tua</a>
                                    </li>
                                    <li><a href="#prodipilihan" data-toggle="tab"><i class="fa fa-share"></i>&nbsp;&nbsp;Prodi
                                            Pilihan</a></li>
                                    <li><a href="#lainnya" data-toggle="tab"><i class="fa fa-bars"></i>&nbsp;&nbsp;Lainnya</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="pribadi">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="namalengkap" class="col-md-3 label-inline">Nama Lengkap
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="namalengkap" id="namalengkap" class="form-control " value="<?= $current_peserta['nama_lengkap_peserta']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="tanggal_lahir" class="col-md-3 label-inline">Tempat
                                                                Lahir <span class="text-danger">*</span></label>
                                                            <div class="col-md-5">
                                                                <select class="form-control select2" id="tempat_lahir" name="tempat_lahir" required>

                                                                    <?php
                                                                    $current_tempatlahir = $this->podb->from('kota')
                                                                        ->where('kotaKode', $current_peserta['tempat_lahir_peserta_kota'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_tempatlahir)) {
                                                                        echo '<option value="' . $current_tempatlahir['kotaKode'] . '" hidden>' . $current_tempatlahir['kotaNama'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $kablahir = $this->podb->from('kota')
                                                                        ->orderBy('kotaKode ASC')
                                                                        ->fetchAll();
                                                                    foreach ($kablahir as $tlhr) {
                                                                        echo '<option value="' . $tlhr['kotaKode'] . '">' . $tlhr['kotaNama'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="tanggal_lahir" class="col-md-3 label-inline">Tanggal
                                                                Lahir <span class="text-danger">*</span></label>

                                                            <div class="col-md-2">
                                                                <select name="hari" class="form-control" required>
                                                                    <?php
                                                                    if (empty($current_peserta['tanggal_lahir_peserta'])) {
                                                                        $optionhari  = "<option value='' hidden=''>Pilih</option>";
                                                                        $optionbulan = "<option value='' hidden=''>Pilih</option>";
                                                                        $optiontahun = "<option value='' hidden=''>Pilih</option>";
                                                                    } else {
                                                                        $pisahtanggal = explode('-', $current_peserta['tanggal_lahir_peserta']);
                                                                        $optionhari  = "<option value='$pisahtanggal[2]' hidden=''>$pisahtanggal[2]</option>";
                                                                        $optionbulan = "<option value='$pisahtanggal[1]' hidden=''>$pisahtanggal[1]</option>";
                                                                        $optiontahun = "<option value='$pisahtanggal[0]' hidden=''>$pisahtanggal[0]</option>";
                                                                    }
                                                                    echo $optionhari;
                                                                    for ($hari = 1; $hari <= 31; $hari++) {
                                                                        if ($hari < 10) {
                                                                            $hari = "0" . $hari;
                                                                        }
                                                                        echo "<option value='$hari'>$hari</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="bulan" class="form-control" required>
                                                                    <?php
                                                                    echo $optionbulan;
                                                                    for ($bulan = 1; $bulan <= 12; $bulan++) {
                                                                        if ($bulan < 10) {
                                                                            $bulan = "0" . $bulan;
                                                                        }
                                                                        echo "<option value='$bulan'>$bulan</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select name="tahun" class="form-control" required>
                                                                    <?php
                                                                    echo $optiontahun;
                                                                    $tahun = date('Y') - 16;
                                                                    $tahun2 = date('Y') - 30;
                                                                    for ($tahun; $tahun2 < $tahun; $tahun--) {
                                                                        echo "<option value='$tahun'>$tahun</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php
                                                    if ($current_peserta['jenkel_peserta'] == 'L') {
                                                        $radiojenkel = array(
                                                            array('name' => 'jenkel', 'id' => 'jenkel', 'value' => 'L', 'options' => 'checked', 'title' => 'Laki-laki'),
                                                            array('name' => 'jenkel', 'id' => 'jenkel', 'value' => 'P', 'options' => '', 'title' => 'Perempuan')
                                                        );
                                                    } elseif ($current_peserta['jenkel_peserta'] == 'P') {
                                                        $radiojenkel = array(
                                                            array('name' => 'jenkel', 'id' => 'jenkel', 'value' => 'L', 'options' => '', 'title' => 'Laki-laki'),
                                                            array('name' => 'jenkel', 'id' => 'jenkel', 'value' => 'P', 'options' => 'checked', 'title' => 'Perempuan')
                                                        );
                                                    } else {
                                                        $radiojenkel = array(
                                                            array('name' => 'jenkel', 'id' => 'jenkel', 'value' => 'L', 'options' => 'required', 'title' => 'Laki-laki'),
                                                            array('name' => 'jenkel', 'id' => 'jenkel', 'value' => 'P', 'options' => '', 'title' => 'Perempuan')
                                                        );
                                                    }
                                                    echo $this->pohtml->inputRadio(array('label' => 'Jenis Kelamin', 'mandatory' => true, 'options' => 'required'), $radiojenkel, $inline = true);
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="agama" class="col-md-3 label-inline">Agama <span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <select class="form-control " id="agama" name="agama" required>

                                                                    <?php
                                                                    $current_agama = $this->podb->from('agama')
                                                                        ->where('id_agama', $current_peserta['agama_peserta'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_agama)) {
                                                                        echo '<option value="' . $current_agama['id_agama'] . '" hidden>' . $current_agama['nama_agama'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $agama = $this->podb->from('agama')
                                                                        ->orderBy('id_agama ASC')
                                                                        ->fetchAll();
                                                                    foreach ($agama as $agm) {
                                                                        echo '<option value="' . $agm['id_agama'] . '">' . $agm['nama_agama'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="statusnikah" class="col-md-3 label-inline">Status Nikah
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <select class="form-control " id="statusnikah" name="statusnikah" required>

                                                                    <?php
                                                                    $current_statusnikah = $this->podb->from('status_nikah')
                                                                        ->where('status_nikah_id', $current_peserta['status_nikah_id'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_statusnikah)) {
                                                                        echo '<option value="' . $current_statusnikah['status_nikah_id'] . '" hidden>' . strtoupper($current_statusnikah['status_nikah_nama']) . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $statusnikah = $this->podb->from('status_nikah')
                                                                        ->orderBy('status_nikah_id ASC')
                                                                        ->fetchAll();
                                                                    foreach ($statusnikah as $snkh) {
                                                                        echo '<option value="' . $snkh['status_nikah_id'] . '">' . strtoupper($snkh['status_nikah_nama']) . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php
                                                    if ($current_peserta['kewarganegaraan_peserta'] == '0') {
                                                        $radiowarganegara = array(
                                                            array('name' => 'warganegara', 'id' => 'warganegara', 'value' => '0', 'options' => 'checked', 'title' => 'WNI'),
                                                            array('name' => 'warganegara', 'id' => 'warganegara', 'value' => '1', 'options' => '', 'title' => 'WNA')
                                                        );
                                                    } elseif ($current_peserta['kewarganegaraan_peserta'] == '1') {
                                                        $radiowarganegara = array(
                                                            array('name' => 'warganegara', 'id' => 'warganegara', 'value' => '0', 'options' => '', 'title' => 'WNI'),
                                                            array('name' => 'warganegara', 'id' => 'warganegara', 'value' => '1', 'options' => 'checked', 'title' => 'WNA')
                                                        );
                                                    } else {
                                                        $radiowarganegara = array(
                                                            array('name' => 'warganegara', 'id' => 'warganegara', 'value' => '0', 'options' => 'required', 'title' => 'WNI'),
                                                            array('name' => 'warganegara', 'id' => 'warganegara', 'value' => '1', 'options' => '', 'title' => 'WNA')
                                                        );
                                                    }
                                                    echo $this->pohtml->inputRadio(array('label' => 'Kewarganegaraan', 'mandatory' => true, 'options' => 'required'), $radiowarganegara, $inline = true);
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="darah" class="col-md-3 label-inline">Golongan Darah
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <select class="form-control " id="darah" name="darah" required>
                                                                    <?php
                                                                    $current_darah = $this->podb->from('darah')
                                                                        ->where('id_darah', $current_peserta['darah_peserta'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_darah)) {
                                                                        echo '<option value="' . $current_darah['id_darah'] . '" hidden>' . $current_darah['golongan_darah'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $darah = $this->podb->from('darah')
                                                                        ->orderBy('id_darah DESC')
                                                                        ->fetchAll();
                                                                    foreach ($darah as $drh) {
                                                                        echo '<option value="' . $drh['id_darah'] . '">' . $drh['golongan_darah'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="alamat" class="col-md-3 label-inline">Alamat Asal <span class="text-danger">*</span></label>
                                                            <div class="col-md-8">
                                                                <textarea name="alamat" class="form-control" style="width:100%; height:50px;" required><?= $current_peserta['alamat_peserta_asal']; ?></textarea>
                                                                <span class="help-block"><small>Alamat asal (tulis lengkap) Nama
                                                                        jalan dan nomor rumah, beserta nama desa atau kelurahan,
                                                                        kecamatan</small></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="kotaalamat" class="col-md-3 label-inline">Kota/Kab dan
                                                                Kode Pos Alamat <span class="text-danger">*</span></label>
                                                            <div class="col-md-5">
                                                                <select class="form-control select2" id="kotaalamat" name="kotaalamat" required>
                                                                    <?php
                                                                    $current_kotaalamat = $this->podbfrom('wilayah_data')
                                                                        ->where('id_wil', $current_peserta['alamat_peserta_asal_kota'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_kotaalamat)) {
                                                                        echo '<option value="' . $current_kotaalamat['id_wil'] . '" hidden>' . $current_kotaalamat['nm_wil'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $kabalamat = $this->podb->from('wilayah_data')
                                                                        ->where('id_level_wil', '2')
                                                                        ->orderBy('nm_wil ASC')
                                                                        ->fetchAll();
                                                                    foreach ($kabalamat as $kabal) {
                                                                        echo '<option value="' . $kabal['id_wil'] . '">' . $kabal['nm_wil'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" name="kodepos" class="form-control" value="<?= $current_peserta['alamat_peserta_asal_kodepos']; ?>" placeholder="Kode Pos" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="ponsel" class="col-md-3 label-inline">No. Ponsel <span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="ponsel" id="ponsel" class="form-control" value="<?= $current_peserta['telp_peserta']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="email" class="col-md-3 label-inline">Email <span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="email" id="email" value="<?= $current_peserta['email_peserta']; ?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="pendidikan">
                                        <div class="col-md-12">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="nisn" class="col-md-3 label-inline">NISN <span class="text-danger">*</span></label>
                                                            <div class="col-md-3">
                                                                <input type="text" name="nisn" id="nisn" class="form-control" value="<?= $current_peserta['nisn']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="pendidikan" class="col-md-3 label-inline">Jenis sttb
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <select class="form-control " id="pendidikan" name="pendidikan" required>
                                                                    <?php
                                                                    $current_sttb = $this->podb->from('smta_sttb')
                                                                        ->where('jsttbId', $current_peserta['pendidikan_peserta'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_sttb)) {
                                                                        echo '<option value="' . $current_sttb['jsttbId'] . '" hidden>' . $current_sttb['jsttbNama'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $sttb = $this->podb->from('smta_sttb')
                                                                        ->orderBy('jsttbId DESC')
                                                                        ->fetchAll();
                                                                    foreach ($sttb as $stt) {
                                                                        echo '<option value="' . $stt['jsttbId'] . '">' . $stt['jsttbNama'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="kotasekolah" class="col-md-3 label-inline">Kota/Kab
                                                                SMTA<span class="text-danger">*</span></label>
                                                            <div class="col-md-5">
                                                                <select class="form-control select2" id="kotasekolah" name="kotasekolah" required>
                                                                    <?php
                                                                    $current_kotasekolah = $this->podb->from('kota')
                                                                        ->where('kotaKode', $current_peserta['alamat_peserta_asal_kota'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_kotasekolah)) {
                                                                        echo '<option value="' . $current_kotasekolah['kotaKode'] . '" hidden>' . $current_kotasekolah['kotaNama'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $kotasekolah = $this->podb->from('kota')
                                                                        ->orderBy('kotaKode ASC')
                                                                        ->fetchAll();
                                                                    foreach ($kotasekolah as $kabse) {
                                                                        echo '<option value="' . $kabse['kotaKode'] . '">' . $kabse['kotaNama'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="sekolahasal" class="col-md-3 label-inline">Nama
                                                                SMTA<span class="text-danger">*</span></label>
                                                            <div class="col-md-5">
                                                                <select class="form-control select2" id="sekolahasal" name="sekolahasal" required>
                                                                    <?php
                                                                    $current_smta = $this->podb->from('smta')
                                                                        ->where('smtaKode', $current_peserta['asal_sekolah_peserta'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_smta)) {
                                                                        echo '<option value="' . $current_smta['smtaKode'] . '" hidden>' . $current_smta['smtaNama'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <span class="help-block"><small>Untuk melihat sekolah asal,
                                                                        harus memilih Kota/Kab SMTA dahulu.</small></span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="jurusan" class="col-md-3 label-inline">Jurusan SMTA
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <select class="form-control " id="jurusan" name="jurusan" required>
                                                                    <?php
                                                                    $current_jurusan = $this->podb->from('smta_jurusan')
                                                                        ->where('jursmtarKode', $current_peserta['jurusan_peserta'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_jurusan)) {
                                                                        echo '<option value="' . $current_jurusan['jursmtarKode'] . '" hidden>' . $current_jurusan['jursmtarNama'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $jurusan = $this->podb->from('smta_jurusan')
                                                                        ->orderBy('jursmtarKode ASC')
                                                                        ->fetchAll();
                                                                    foreach ($jurusan as $jur) {
                                                                        echo '<option value="' . $jur['jursmtarKode'] . '">' . $jur['jursmtarNama'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="tahunlulus" class="col-md-3 label-inline">Tahun Lulus
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-3">
                                                                <input type="text" name="tahunlulus" id="tahunlulus" maxlength="4" min="4" class="form-control" value="<?= $current_peserta['tahun_lulus_peserta']; ?>" required>
                                                                <span class="help-block"><small>Jika kelas XII, Isi Tahun Lulus
                                                                        <strong><?= $settings[30]['value']; ?></strong></small></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="tab-pane " id="ortu">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="nama_ortu" class="col-md-3 label-inline">Nama Ayah <span class="text-danger">*</span></label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control " id="nama_ortu" name="nama_ortu" value="<?= $current_peserta['nama_orangtua_peserta']; ?>" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-md-3">Status Ayah <span class="text-danger">*</span></label>
                                                            <div class="col-md-3">
                                                                <select class="form-control " id="statusayah" name="statusayah" required>
                                                                    <?php
                                                                    if ($current_peserta['status_orangtua_peserta'] == "1") {
                                                                        $valuestatusayah = '1';
                                                                        $tampilstatusayah = 'SUDAH MENINGGAL';
                                                                    } else {
                                                                        $valuestatusayah = '0';
                                                                        $tampilstatusayah = "MASIH HIDUP";
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $valuestatusayah; ?>" hidden="">
                                                                        <?= $tampilstatusayah; ?></option>
                                                                    <option value="0">MASIH HIDUP</option>
                                                                    <option value="1">SUDAH MENINGGAL</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="tglwafat">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="tgl_meninggal" class="col-md-3 label-inline">Tanggal
                                                                Meninggal<span class="text-danger">*</span></label>
                                                            <div class="col-md-2">
                                                                <select name="hariwafat" class="form-control">
                                                                    <?php
                                                                    if (empty($current_peserta['tanggal_wafat_orangtua_peserta']) || $current_peserta['tanggal_wafat_orangtua_peserta'] == '--') {
                                                                        $optionhariwafat  = "<option value='' hidden=''>Pilih</option>";
                                                                        $optionbulanwafat = "<option value='' hidden=''>Pilih</option>";
                                                                        $optiontahunwafat = "<option value='' hidden=''>Pilih</option>";
                                                                    } else {
                                                                        $pisahtanggalwafat = explode('-', $current_peserta['tanggal_wafat_orangtua_peserta']);
                                                                        $optionhariwafat  = "<option value='$pisahtanggalwafat[2]' hidden=''>$pisahtanggalwafat[2]</option>";
                                                                        $optionbulanwafat = "<option value='$pisahtanggalwafat[1]' hidden=''>$pisahtanggalwafat[1]</option>";
                                                                        $optiontahunwafat = "<option value='$pisahtanggalwafat[0]' hidden=''>$pisahtanggalwafat[0]</option>";
                                                                    }
                                                                    echo $optionhariwafat;
                                                                    for ($hariwafat = 1; $hariwafat <= 31; $hariwafat++) {
                                                                        if ($hariwafat < 10) {
                                                                            $hariwafat = "0" . $hariwafat;
                                                                        }
                                                                        echo "<option value='$hariwafat'>$hariwafat</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="bulanwafat" class="form-control">
                                                                    <?php
                                                                    echo $optionbulanwafat;
                                                                    for ($bulanwafat = 1; $bulanwafat <= 12; $bulanwafat++) {
                                                                        if ($bulanwafat < 10) {
                                                                            $bulanwafat = "0" . $bulanwafat;
                                                                        }
                                                                        echo "<option value='$bulanwafat'>$bulanwafat</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select name="tahunwafat" class="form-control">
                                                                    <?php
                                                                    echo $optiontahunwafat;
                                                                    $tahunwafat = date('Y') - 0;
                                                                    $tahun2wafat = date('Y') - 30;
                                                                    for ($tahunwafat; $tahun2wafat < $tahunwafat; $tahunwafat--) {
                                                                        echo "<option value='$tahunwafat'>$tahunwafat</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="pendidikan" class="col-md-3 label-inline">Pendidikan
                                                                Ayah<span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <select class="form-control " id="pendidikanortu" name="pendidikanortu" required>
                                                                    <?php
                                                                    $current_pendidikan = $this->podb->from('pendidikan')
                                                                        ->where('pndrId', $current_peserta['pendidikan_orangtua_peserta'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_pendidikan)) {
                                                                        echo '<option value="' . $current_pendidikan['pndrId'] . '" hidden>' . $current_pendidikan['pndrNama'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $pendidikanortu = $this->podb->from('pendidikan')
                                                                        ->orderBy('pndrId ASC')
                                                                        ->fetchAll();
                                                                    foreach ($pendidikanortu as $pddo) {
                                                                        echo '<option value="' . $pddo['pndrId'] . '">' . $pddo['pndrNama'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="pekerjaan" class="col-md-3 label-inline">Pekerjaan
                                                                Ayah<span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <select class="form-control " id="pekerjaan" name="pekerjaan" required>
                                                                    <?php
                                                                    $current_pekerjaan = $this->podb->from('pekerjaan')
                                                                        ->where('id_pekerjaan', $current_peserta['pekerjaan_orangtua_peserta'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_pekerjaan)) {
                                                                        echo '<option value="' . $current_pekerjaan['id_pekerjaan'] . '" hidden>' . $current_pekerjaan['nm_pekerjaan'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $pekerjaan = $this->podb->from('pekerjaan')
                                                                        ->orderBy('id_pekerjaan ASC')
                                                                        ->fetchAll();
                                                                    foreach ($pekerjaan as $krj) {
                                                                        echo '<option value="' . $krj['id_pekerjaan'] . '">' . $krj['nm_pekerjaan'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-md-3">Penghasilan Ayah <span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <select class="form-control " id="penghasilanayah" name="penghasilanayah" required>
                                                                    <?php
                                                                    $current_penghasilan = $this->podb->from('penghasilan')
                                                                        ->where('phslrId', $current_peserta['penghasilan_orangtua_peserta'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_penghasilan)) {
                                                                        echo '<option value="' . $current_penghasilan['phslrId'] . '" hidden>' . $current_penghasilan['phslrBesar'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $penghasilan = $this->podb->from('penghasilan')
                                                                        ->orderBy('phslrId ASC')
                                                                        ->fetchAll();
                                                                    foreach ($penghasilan as $phs) {
                                                                        echo '<option value="' . $phs['phslrId'] . '">' . $phs['phslrBesar'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="tanggungan" class="col-md-3 label-inline">Tanggungan
                                                                Anak <span class="text-danger">*</span></label>
                                                            <div class="col-md-2">
                                                                <input type="number" class="form-control " id="tanggungan" name="tanggungan" value="<?= $current_peserta['tanggungan_orangtua_peserta']; ?>" required="" maxlength="2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="agamaayah" class="col-md-3 label-inline">Agama Ayah<span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <select class="form-control " id="agamaayah" name="agamaayah" required>

                                                                    <?php
                                                                    $current_agamaayah = $this->podb->from('agama')
                                                                        ->where('id_agama', $current_peserta['agama_orangtua_peserta'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_agamaayah)) {
                                                                        echo '<option value="' . $current_agamaayah['id_agama'] . '" hidden>' . $current_agamaayah['nama_agama'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $agamaayah = $this->podb->from('agama')
                                                                        ->orderBy('id_agama ASC')
                                                                        ->fetchAll();
                                                                    foreach ($agamaayah as $agmy) {
                                                                        echo '<option value="' . $agmy['id_agama'] . '">' . $agmy['nama_agama'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="message" class="col-md-3 label-inline">Alamat Ayah <span class="text-danger">*</span></label>
                                                            <div class="col-md-8">
                                                                <textarea name="alamat_ortu" class="form-control" style="width:100%; height:50px;" required><?= $current_peserta['alamat_orangtua_peserta']; ?></textarea>
                                                                <span class="help-block"><small>Alamat Ayah (tulis lengkap) Nama
                                                                        jalan dan nomor rumah, beserta nama desa atau kelurahan,
                                                                        kecamatan</small></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="kotaalamatayah" class="col-md-3 label-inline">Kota/Kab
                                                                dan Kode Pos Alamat Ayah<span class="text-danger">*</span></label>
                                                            <div class="col-md-5">
                                                                <select class="form-control select2" id="kotaalamatayah" name="kotaalamatayah" required>
                                                                    <?php
                                                                    $current_kotaalamatayah = $this->podb->from('kota')
                                                                        ->where('kotaKode', $current_peserta['kota_orangtua_peserta'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_kotaalamatayah)) {
                                                                        echo '<option value="' . $current_kotaalamatayah['kotaKode'] . '" hidden>' . $current_kotaalamatayah['kotaNama'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $kabalamatayah = $this->podb->from('kota')
                                                                        ->orderBy('kotaKode ASC')
                                                                        ->fetchAll();
                                                                    foreach ($kabalamatayah as $kabalaya) {
                                                                        echo '<option value="' . $kabalaya['kotaKode'] . '">' . $kabalaya['kotaNama'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" name="kodeposayah" class="form-control" value="<?= $current_peserta['kodepos_orangtua_peserta']; ?>" placeholder="Kode Pos" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="telp_ortu" class="col-md-3 label-inline">No. HP Ayah
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control " id="telp_ortu" name="telp_ortu" value="<?= $current_peserta['telp_orangtua_peserta']; ?>" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="emailayah" class="col-md-3 label-inline">Email Ayah
                                                            </label>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control " id="emailayah" name="emailayah" value="<?= $current_peserta['email_orangtua_peserta']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane " id="prodipilihan">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="pil_pertama" class="col-md-3 label-inline">Prodi Tujuan
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-md-7">
                                                                <select class="form-control " id="pil_pertama" name="pil_pertama" required>
                                                                    <?php
                                                                    $current_pil_satu = $this->podb->from('program_studi')
                                                                        ->where('prodiKode', $current_peserta['pilihan_pertama'])
                                                                        ->limit(1)
                                                                        ->fetch();
                                                                    if (!empty($current_pil_satu)) {
                                                                        echo '<option value="' . $current_pil_satu['prodiKode'] . '" hidden>' . $current_pil_satu['prodiNamaResmi'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="" hidden>Pilih</option>';
                                                                    }
                                                                    $pil_satu = $this->podb->from('program_studi')
                                                                        ->orderBy('prodiNamaSingkat ASC')
                                                                        ->fetchAll();
                                                                    foreach ($pil_satu as $pil1) {
                                                                        echo '<option value="' . $pil1['prodiKode'] . '">' . $pil1['prodiNamaResmi'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane " id="lainnya">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-md-3 " for="keinginan">Keinginan untuk mengikuti
                                                                pendidikan di Unifa <span class="text-danger">*</span></label>
                                                            <div class="col-md-5">
                                                                <select class="form-control " id="keinginan" name="keinginan" required>
                                                                    <?php
                                                                    if (!empty($current_peserta['keinginan'])) {
                                                                        $valuekeinginan = $current_peserta['keinginan'];
                                                                        $tampilkeinginan = $current_peserta['keinginan'];
                                                                    } else {
                                                                        $valuekeinginan = '';
                                                                        $tampilkeinginan = 'Pilih';
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $valuekeinginan; ?>" hidden="">
                                                                        <?= $tampilkeinginan; ?></option>
                                                                    <option value="Sangat Minat Sekali">Sangat Minat Sekali
                                                                    </option>
                                                                    <option value="Sangat Minat">Sangat Minat</option>
                                                                    <option value="Minat">Minat</option>
                                                                    <option value="Kurang Minat">Kurang Minat</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-md-3">Ukuran Jas <span class="text-danger">*</span></label>
                                                            <div class="col-md-3">
                                                                <select class="form-control " id="ukuran" name="ukuran" required>
                                                                    <?php
                                                                    if (!empty($current_peserta['ukuran_jas'])) {
                                                                        $valueukuran = $current_peserta['ukuran_jas'];
                                                                        $tampilukuran = $current_peserta['ukuran_jas'];
                                                                    } else {
                                                                        $valueukuran = '';
                                                                        $tampilukuran = 'Pilih';
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $valueukuran; ?>" hidden="">
                                                                        <?= $tampilukuran; ?></option>
                                                                    <option value="S">S</option>
                                                                    <option value="M">M</option>
                                                                    <option value="L">L</option>
                                                                    <option value="XL">XL</option>
                                                                    <option value="Lainnya">Lainnya</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control " id="ukuranlainnya" name="ukuranlain" placeholder="Ketik Ukuran Jas" value="<?= $current_peserta['ukuran_jas']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-md-3">Informasi Unifa diperoleh dari <span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <select class="form-control " id="peroleh" name="peroleh" required>
                                                                    <?php
                                                                    if (!empty($current_peserta['informasi_mengetahui_atk'])) {
                                                                        $valueperoleh = $current_peserta['informasi_mengetahui_atk'];
                                                                        $tampilperoleh = $current_peserta['informasi_mengetahui_atk'];
                                                                    } else {
                                                                        $valueperoleh = '';
                                                                        $tampilperoleh = 'Pilih';
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $valueperoleh; ?>" hidden="">
                                                                        <?= $tampilperoleh; ?></option>
                                                                    <option value="Sekolah/Presentasi">Sekolah/Presentasi
                                                                    </option>
                                                                    <option value="Alumni">Alumni</option>
                                                                    <option value="Mahasiswa Unifa">Mahasiswa Unifa</option>
                                                                    <option value="Pameran">Pameran</option>
                                                                    <option value="Iklan">Iklan</option>
                                                                    <option value="Internet">Internet</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <?= $this->pohtml->formAction(); ?>
                        </div>
                        <?= $this->pohtml->formEnd(); ?>
                </div>
            </div>
        </div>
    <?php
    }


    /**
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus peserta.
     *
     * This function is used to display and process delete peserta page.
     *
     */
    public function delete()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'delete')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $id = $this->postring->valid($_POST['id'], 'xss');
            $cek_peserta = $this->podb->from('peserta')
                ->where('id_session', $id)
                ->limit(1)
                ->fetch();

            $query = $this->podb->deleteFrom('peserta')->where('id_session', $cek_peserta['id_session']);
            $query->execute();

            $this->poflash->success('Peserta has been successfully deleted', 'admin.php?mod=peserta');
        }
    }

    /**
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus multi peserta.
     *
     * This function is used to display and process multi delete peserta page.
     *
     */
    public function multidelete()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'delete')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $totaldata = $this->postring->valid($_POST['totaldata'], 'xss');
            if ($totaldata != "0") {
                $items = $_POST['item'];
                foreach ($items as $item) {
                    $query = $this->podb->deleteFrom('peserta')->where('id_peserta', $this->postring->valid($item['deldata'], 'sql'));
                    $query->execute();
                }
                $this->poflash->success('Peserta has been successfully deleted', 'admin.php?mod=peserta');
            } else {
                $this->poflash->error('Error deleted peserta data', 'admin.php?mod=peserta');
            }
        }
    }

    /**
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman edit pengguna.
     *
     * This function is used to display and process edit user page.
     *
     */
    public function edit()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'update')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $this->poval->validation_rules(array(
                'nama_lengkap' => 'required|max_len,255|min_len,3',
                'email' => 'required|valid_email',
                'no_telp' => 'required'
            ));
            $this->poval->filter_rules(array(
                'nama_lengkap' => 'trim|sanitize_string',
                'email' => 'trim|sanitize_email',
                'no_telp' => 'trim'
            ));
            $validated_data = $this->poval->run(array_merge($_POST, $_FILES));
            if ($validated_data === false) {
                $this->poflash->error($GLOBALS['_']['peserta_message_5'], 'admin.php?mod=peserta&act=edit&id=' . $this->postring->valid($_POST['id'], 'xss'));
            } else {

                $data = array(
                    'jalur_pendaftaran' => $_POST['jalur'],
                    'nama_lengkap_peserta' => $_POST['nama_lengkap'],
                    'gelombang_daftar' => $_POST['gelombang'],
                    'jenjang_studi_id' => $_POST['jenjang'],
                    'pilihan_pertama' => $_POST['proditujuan'],
                    'kota_sekolah_peserta' => @$_POST['kotasekolah'],
                    'asal_sekolah_peserta' => @$_POST['sekolahasal'],
                    'kode_universitas' => @$_POST['perguruan_tinggi'],
                    'email_peserta' => $_POST['email'],
                    'telp_peserta' => $_POST['no_telp'],
                    'no_wa_peserta' => $_POST['no_wa']
                );
                $datafinal = array_merge($data);

                $query = $this->podb->update('peserta')
                    ->set($datafinal)
                    ->where('id_session', $this->postring->valid($_POST['id'], 'xss'));
                $query->execute();

                $this->poflash->success($GLOBALS['_']['peserta_message_2'], 'admin.php?mod=peserta');
            }
        }
        $id = $this->postring->valid($_GET['id'], 'xss');
        $current_user = $this->podb->from('peserta')
            ->where('id_session', $id)
            ->limit(1)
            ->fetch();
        if (empty($current_user)) {
            echo $this->pohtml->error();
            exit;
        }
    ?>
        <div class="block-content">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->pohtml->headTitle('Detail Peserta'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert-info" style="padding: 20px; margin-bottom: 20px;">Tanda <span class="text-danger">*</span>
                        berarti harus diisi!</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=peserta&act=edit&id=' . $current_user['id_session'], 'enctype' => true, 'autocomplete' => 'off')); ?>
                    <?= $this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_user['id_session'])); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <label for="username" class="col-md-3 label-inline">Kode Registrasi <span class="text-danger">*</span></label>
                                    <div class="col-md-2">
                                        <input type="text" name="username" id="username" class="form-control " value="<?= $current_user['kode_registrasi']; ?>" disabled="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <label for="nama_lengkap" class="col-md-3 label-inline">Nama Peserta <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control " value="<?= $current_user['nama_lengkap_peserta']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <label for="gelombang" class="col-md-3 label-inline">Gelombang Pendaftaran <span class="text-danger">*</span></label>
                                    <div class="col-md-2">
                                        <select class="form-control " id="gelombang" name="gelombang" required>
                                            <?php
                                            $current_gelombang = $this->podb->from('jadwal')
                                                ->where('jadwal_gelombang', $current_user['gelombang_daftar'])
                                                ->limit(1)
                                                ->fetch();
                                            if (!empty($current_gelombang)) {
                                                echo '<option value="' . $current_gelombang['jadwal_gelombang'] . '" hidden>' . $current_gelombang['jadwal_gelombang'] . '</option>';
                                            } else {
                                                echo '<option value="" hidden>Pilih</option>';
                                            }
                                            $gelombang = $this->podb->from('jadwal')
                                                ->where('tahun_ajaran', $this->posetting[30]['value'])
                                                ->orderBy('jadwal_gelombang ASC')
                                                ->fetchAll();
                                            foreach ($gelombang as $glb) {
                                                echo '<option value="' . $glb['jadwal_gelombang'] . '">' . $glb['jadwal_gelombang'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <label for="jenjang" class="col-md-3 label-inline">Jenjang Pendidikan Tujuan <span class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <select class="form-control select2" id="jenjang" name="jenjang" required>
                                            <?php
                                            $current_jenjang = $this->podb->from('jenjang_studi')
                                                ->where('jenjang_studi_id', $current_user['jenjang_studi_id'])
                                                ->limit(1)
                                                ->fetch();
                                            if (!empty($current_jenjang)) {
                                                echo '<option value="' . $current_jenjang['jenjang_studi_id'] . '" hidden>' . strtoupper($current_jenjang['jenjang_studi_singkatan']) . ' (' . strtoupper($current_jenjang['jenjang_studi_nama']) . ')</option>';
                                            } else {
                                                echo '<option value="" hidden>Pilih</option>';
                                            }
                                            $jenjang = $this->podb->from('jenjang_studi')
                                                ->orderBy('jenjang_studi_id DESC')
                                                ->fetchAll();
                                            foreach ($jenjang as $jen) {
                                                echo '<option value="' . $jen['jenjang_studi_id'] . '">' . strtoupper($jen['jenjang_studi_singkatan']) . ' (' . strtoupper($jen['jenjang_studi_nama']) . ')</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <label for="proditujuan" class="col-md-3 label-inline">Prodi Tujuan <span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                        <select class="form-control select2" id="proditujuan" name="proditujuan" required>
                                            <?php
                                            $current_prodi = $this->podb->from('program_studi')
                                                ->where('prodiKode', $current_user['pilihan_pertama'])
                                                ->limit(1)
                                                ->fetch();
                                            if (!empty($current_prodi)) {
                                                echo '<option value="' . $current_prodi['prodiKode'] . '" hidden>' . strtoupper($current_prodi['prodiNamaResmi']) . '</option>';
                                            } else {
                                                echo '<option value="" hidden>Pilih</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="menusekolah" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="kotasekolah" class="col-md-3 label-inline">Kota/Kab SMTA<span class="text-danger">*</span></label>
                                        <div class="col-md-5">
                                            <select class="form-control select2" id="kotasekolah" name="kotasekolah" required>
                                                <?php
                                                $current_kotasekolah = $this->podb->from('wilayah_data')
                                                    ->where('id_wil', $current_user['kota_sekolah_peserta'])
                                                    ->limit(1)
                                                    ->fetch();
                                                if (!empty($current_kotasekolah)) {
                                                    echo '<option value="' . $current_kotasekolah['id_wil'] . '" hidden>' . strtoupper($current_kotasekolah['nm_wil']) . '</option>';
                                                } else {
                                                    echo '<option value="" hidden>Pilih</option>';
                                                }
                                                $kotasekolah = $this->podb->from('wilayah_data')
                                                    ->where('id_level_wil', '2')
                                                    ->orderBy('nm_wil ASC')
                                                    ->fetchAll();
                                                foreach ($kotasekolah as $kabse) {
                                                    echo '<option value="' . $kabse['id_wil'] . '">' . $kabse['nm_wil'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="sekolahasal" class="col-md-3 label-inline">Nama SMTA<span class="text-danger">*</span></label>
                                        <div class="col-md-5">
                                            <select class="form-control select2" id="sekolahasal" name="sekolahasal" required>
                                                <?php
                                                $current_smta = $this->podb->from('smta')
                                                    ->where('smtaKode', $current_user['asal_sekolah_peserta'])
                                                    ->limit(1)
                                                    ->fetch();
                                                if (!empty($current_smta)) {
                                                    echo '<option value="' . $current_smta['smtaKode'] . '" hidden>' . strtoupper($current_smta['smtaNama']) . '</option>';
                                                } else {
                                                    echo '<option value="" hidden>Pilih</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="help-block"><small>Untuk melihat sekolah asal, harus memilih Kota/Kab
                                                    SMTA dahulu.</small></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="menukampus" style="display: none;">
                        <input type="hidden" id="iduniv" name="iduniv" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="universitas" class="col-md-3 label-inline">Perguruan Tinggi Asal <span class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <?php
                                            $current_universitas = $this->podb->from('universitas')
                                                ->where('kode_universitas', $current_user['kode_universitas'])
                                                ->limit(1)
                                                ->fetch();
                                            ?>
                                            <input type="text" name="universitas" id="universitas" class="form-control " value="<?= strtoupper($current_universitas['nama_universitas']); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <label for="jalur" class="col-md-3 label-inline">Jalur Pendaftaran <span class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <select class="form-control " id="jalur" name="jalur" required>
                                            <?php
                                            $current_jalur = $this->podb->from('jalur_pendaftaran')
                                                ->where('jalur_pendaftaran_id', $current_user['jalur_pendaftaran'])
                                                ->limit(1)
                                                ->fetch();
                                            if (!empty($current_jalur)) {
                                                echo '<option value="' . $current_jalur['jalur_pendaftaran_id'] . '" hidden>' . strtoupper($current_jalur['jalur_pendaftaran_nama']) . '</option>';
                                            } else {
                                                echo '<option value="" hidden>Pilih</option>';
                                            }
                                            $jalur = $this->podb->from('jalur_pendaftaran')
                                                ->orderBy('jalur_pendaftaran_id ASC')
                                                ->where('jalur_pendaftaran_aktif', 'Y')
                                                ->fetchAll();
                                            foreach ($jalur as $jlr) {
                                                echo '<option value="' . $jlr['jalur_pendaftaran_id'] . '">' . strtoupper($jlr['jalur_pendaftaran_nama']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <label for="email" class="col-md-3 label-inline">Email Peserta <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="email" id="email" class="form-control " value="<?= strtolower($current_user['email_peserta']); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <label for="no_telp" class="col-md-3 label-inline">No. Ponsel Peserta <span class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <input type="text" name="no_telp" id="no_telp" class="form-control" value="<?= $current_user['telp_peserta']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <label for="no_telp" class="col-md-3 label-inline">No. Whatsapp <span class="text-danger">*</span></label>
                                    <div class="col-md-3">
                                        <input type="text" name="no_wa" id="no_wa" class="form-control" value="<?= $current_user['no_wa_peserta']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->pohtml->formAction(); ?>
                        </div>
                    </div>
                    <?= $this->pohtml->formEnd(); ?>
                </div>
            </div>
        </div>
    <?php

    }

    /**
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman reset TPA peserta.
     *
     * This function is used to display and process reset TPA peserta page.
     *
     */
    public function resettpa()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'update')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $id = $this->postring->valid($_POST['id'], 'xss');
            $query = $this->podb->deleteFrom('tpa_mengerjakan')->where('id_peserta', $id);
            $query->execute();
            $query2 = $this->podb->deleteFrom('wawancara')->where('id_peserta', $id);
            $query2->execute();
            $this->poflash->success('Peserta has been successfully deleted TPA', 'admin.php?mod=peserta');
        }
    }

    /**
     * Fungsi ini digunakan untuk hasil tpa.
     *
     * This function use for tpa.
     *
     */
    public function hasiltpa()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'update')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $datapeserta = array(
                'status_seleksi' => $_POST['statusseleksi'],
                'prodi_lulus' => $_POST['prodilulus'],
                'tgl_input_seleksi' => date('Y-m-d H:i:s')
            );
            $querypeserta = $this->podb->update('peserta')
                ->set($datapeserta)
                ->where('id_peserta', $this->postring->valid($_POST['id'], 'xss'));
            $querypeserta->execute();

            $this->poflash->success('Berhasil! Hasil seleksi masuk telah ditentukan', 'admin.php?mod=peserta');
        }
        $id = $this->postring->valid($_GET['id'], 'xss');
        $current_peserta = $this->podb->from('peserta')
            ->where('id_session', $id)
            ->limit(1)
            ->fetch();

        $current_jalur = $this->podb->from('jalur_pendaftaran')
            ->where('jalur_pendaftaran_id', $current_peserta['jalur_pendaftaran'])
            ->orderBy('jalur_pendaftaran_nama ASC')
            ->limit('1')
            ->fetch();
        $current_testpa = $this->podb->from('tpa_mengerjakan')
            ->where('id_peserta', $current_peserta['id_peserta'])
            ->limit('1')
            ->fetch();
        $soaltpa = $this->podb->from('tpa_soal')->where('aktif', 'Y')->count();
        $settings = $this->podb->from('setting')->fetchAll();
        if (empty($current_peserta)) {
            echo $this->pohtml->error();
            exit;
        }


    ?>
        <div class="block-content">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->pohtml->headTitle('Hasil TPA'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form role="form" method="post" action="route.php?mod=peserta&act=tpa" autocomplete="off">
                        <?= $this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_peserta['id_peserta'])); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="kode" class="col-md-3 label-inline">No. Peserta </label>
                                        <div class="col-md-3">
                                            <input type="text" name="kode" value="<?= $current_peserta['no_peserta']; ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="nama" class="col-md-3 label-inline">Nama Lengkap </label>
                                        <div class="col-md-9">
                                            <input type="text" value="<?= ucwords($current_peserta['nama_lengkap_peserta']); ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="jalur" class="col-md-3 label-inline">Jalur Pendaftaran </label>
                                        <div class="col-md-2">
                                            <input type="text" value="<?= strtoupper($current_jalur['jalur_pendaftaran_nama']); ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="jalur" class="col-md-3 label-inline">Pelaksanaan Tes </label>
                                        <div class="col-md-4">
                                            <?php
                                            $pisahtanggalmulai = explode(' ', $current_testpa['tgl_mulai']);
                                            ?>
                                            <input type="text" value="<?= $this->tanggal_indo($pisahtanggalmulai['0']); ?> <?= $pisahtanggalmulai['1']; ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="jalur" class="col-md-3 label-inline">Jumlah Soal </label>
                                        <div class="col-md-2">
                                            <input type="text" value="<?= $soaltpa; ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="jalur" class="col-md-3 label-inline">Jawaban Benar </label>
                                        <div class="col-md-2">
                                            <input type="text" value="<?= $current_testpa['jml_benar']; ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="jalur" class="col-md-3 label-inline">Nilai Tes</label>
                                        <div class="col-md-2">
                                            <input type="text" value="<?= $current_testpa['nilai']; ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <?= $this->pohtml->formAction(); ?>
                        </div>
                        <?= $this->pohtml->formEnd(); ?>
                </div>
            </div>
        </div>
    <?php

    }

    /**
     * Fungsi ini digunakan untuk hasil seleksi.
     *
     * This function use for test.
     *
     */
    public function hasilseleksi()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'update')) {
            echo $this->pohtml->error();
            exit;
        }

        if (!empty($_POST)) {
            $rangebayar        = '+' . $this->posetting[37]['value'];
            $batasbayar        = date("Y-m-d", strtotime($rangebayar));
            //$batasbayar = '2022-08-08';
            $datapeserta = array(
                'batas_bayar_daftarulang' => $batasbayar . ' 23:59:59',
                'status_seleksi' => $_POST['statusseleksi'],
                'prodi_lulus' => $_POST['prodilulus'],
                'tgl_input_seleksi' => date('Y-m-d H:i:s')
            );
            $querypeserta = $this->podb->update('peserta')
                ->set($datapeserta)
                ->where('id_peserta', $this->postring->valid($_POST['id'], 'xss'));
            $querypeserta->execute();

            if ($_POST['statusseleksi'] == 'Lulus') {

                $current_peserta   = $this->podb->from('peserta')->where('id_peserta', $this->postring->valid($_POST['id'], 'sql'))->limit(1)->fetch();

                //INPUT KE BERKAS DAFTAR ULANG    
                $current_berkas_ulang = $this->podb->from('berkas')->where('id_peserta', $current_peserta['id_peserta'])->limit(1)->fetch();
                if (empty($current_berkas_ulang)) {
                    $berkasulang = array(
                        'id_peserta' => $current_peserta['id_peserta'],
                        'tahun_ajaran' => $this->posetting[30]['value']
                    );
                    $query_berkasrulang = $this->podb->insertInto('berkas')->values($berkasulang);
                    $query_berkasrulang->execute();
                }


                $current_jalur     = $this->podb->from('jalur_pendaftaran')->where('jalur_pendaftaran_id', $current_peserta['jalur_pendaftaran'])->limit(1)->fetch();
                $current_prodi     = $this->podb->from('program_studi')->where('prodiKode', $current_peserta['prodi_lulus'])->limit(1)->fetch();
                $website_name      = $this->posetting[0]['value'];
                $website_url       = $this->posetting[1]['value'];
                $subject           = "PENGUMUMAN SELEKSI MASUK UNIFA";
                $tahunmasuk        = $this->posetting[30]['value'];
                $tahunmasukend     = $this->posetting[30]['value'] + 1;
                $from              = $this->posetting[5]['value'];
                $telpon            = $this->posetting[7]['value'];
                $koderegis         = $current_peserta['kode_registrasi'];
                $ponsel            = $current_peserta['telp_peserta'];
                $username          = $current_peserta['nama_lengkap_peserta'];
                $email             = $current_peserta['email_peserta'];

                $client_id         = BNI_CLIENTID;
                $secret_key        = BNI_SECRETKEY;
                $urlBni            = BNI_APIURL;

                $nomorva             = $current_peserta['va'];
                $uniktrskode         = $current_peserta['kode_unik'];

                //kirim webservice bnis
                $hp_maba = str_replace("+62", "62", $ponsel);
                $hp_maba = str_replace(" ", "", $hp_maba);
                $hp_maba = str_replace("-", "", $hp_maba);
                $kode_depan = substr($hp_maba, 0, 1);
                if ($kode_depan == '0') {
                    $hp_maba = '62' . substr($hp_maba, 1, 30);
                }

                if ($current_peserta['jenjang_studi_id'] == '1') {

                    if ($current_peserta['jalur_pendaftaran'] == '3') {
                        $totalbiaya        = $current_prodi['biaya_pra_akademik'] + $current_prodi['biaya_registrasi_krs'] + $current_prodi['biaya_seragam'];
                    } else {
                        $totalbiaya        = $current_prodi['biaya_pra_akademik'] + $current_prodi['biaya_spp'] + $current_prodi['biaya_sks'] + $current_prodi['biaya_registrasi_krs'] + $current_prodi['biaya_seragam'];
                    }
                } elseif ($current_peserta['jenjang_studi_id'] == '2') {

                    if ($current_peserta['jalur_pendaftaran'] == '3') {
                        $totalbiaya        = $current_prodi['biaya_pra_akademik'] + $current_prodi['biaya_registrasi_krs'];
                    } else {
                        // $hitungsks         = $current_prodi['biaya_sks'];
                        $totalbiaya        = $current_prodi['biaya_pra_akademik'] + $current_prodi['biaya_spp'] + $current_prodi['biaya_sks'] + $current_prodi['biaya_registrasi_krs'];
                    }
                } elseif ($current_peserta['jenjang_studi_id'] == '3') {
                    $totalbiaya        = $current_prodi['biaya_pra_akademik'] + $current_prodi['biaya_sks'] + $current_prodi['biaya_registrasi_krs'];
                }
                //FORMAT VA
                //9880052200000001$jumlahAngkaRand
                //TRXID = TAHUN.1.RANDOM;
                $virtualaccount  = $nomorva;
                $data_asli = array(
                    'client_id' => $client_id,
                    'trx_id' => $this->posetting[30]['value'] . '.2.' . $uniktrskode, // fill with Billing ID
                    'trx_amount' => $totalbiaya,
                    'type' => 'createbilling',
                    'billing_type' => 'i',
                    'datetime_expired' => $batasbayar . ' 23:59:59', // billing will be expired in 2 hours
                    'virtual_account' => $virtualaccount,
                    'customer_name' => $username,
                    'customer_email' => $email,
                    'customer_phone' => $hp_maba,
                    'description' => 'Pembayaran Daftar Ulang PMB UNIFA ' . $this->posetting[30]['value'] . ''
                );

                $encryptBni = new BniEnc;
                $hashed_string = $encryptBni->encrypt(
                    $data_asli,
                    $client_id,
                    $secret_key
                );


                $databni = array(
                    'client_id' => $client_id,
                    'data' => $hashed_string,
                );

                $response = $this->get_content($urlBni, json_encode($databni));
                $response_json = json_decode($response, true);

                if ($response_json['status'] !== '000') {
                    //var_dump($response_json);
                } else {
                    $data_response = $encryptBni->decrypt($response_json['data'], $client_id, $secret_key);
                    //var_dump($data_response);
                }

                $batasbayaremail        = date("Y-m-d", strtotime('+14 days'));


                $urlfileCaraBayar       = $website_url  . DIR_INC . '/images/cara-bayar-bsi.jpg';
                $urlpernyataanKeuangan  = $website_url . DIR_CON . '/uploads/surat-pernyataan-biro-keuangan-new.pdf';
                $urlpernyataanKemahasiswaan =  $website_url . DIR_CON . '/uploads/surat-pernyataan-biro-kemahasiswaan-new.pdf';

                if ($current_prodi['fakultas_id'] == '1') {
                    $urlSkemaPembayaran  = $website_url . DIR_CON . '/uploads/feis-reguler.jpg';
                } elseif ($current_prodi['fakultas_id'] == '2') {
                    $urlSkemaPembayaran  = $website_url . DIR_CON . '/uploads/teknik-reguler.jpg';
                } elseif ($current_prodi['fakultas_id'] == '3') {
                    $urlSkemaPembayaran  = $website_url . DIR_CON . '/uploads/pascasarjana-reguler.jpg';
                }


                if ($current_peserta['jenjang_studi_id'] == '1') {
                    $message = "
                <table border='0' width='100%' cellspacing='0' cellpadding='0'>
                <tbody>
                <tr>
                <td style='color: #153643; font-family: Arial, sans-serif; font-size: 14px; line-height: 24px; padding: 20px 0px 30px; text-align: center;'>
                <table style='border-collapse: collapse; border: 1px solid #cccccc;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
                <tbody>
                <tr>
                <td style='padding: 40px 0 30px 0;' align='center' bgcolor='#003679'><img style='display: block;' src='" . $website_url . DIR_INC . "/images/unifamail.png' alt='LOGO SIMBA.' /></td>
                </tr>
                <tr>
                <td style='padding: 40px 30px 40px 30px;' bgcolor='#ffffff'>
                <table style='border-collapse: collapse;' border='0' width='100%' cellspacing='0' cellpadding='0'>
                <tbody>
                <tr>
                <td style='color: #153643; font-family: Arial, sans-serif; font-size: 14px; line-height: 24px; padding: 20px 0px 30px; text-align: center;'>
                <p style='text-align: left;'>Yang Terhormat <br /> <strong>$username</strong>. <br /> Calon Mahasiswa Baru Universitas Fajar <br /> Tahun Akademik $tahunmasuk/$tahunmasukend <br /> Di Tempat</p>
                <p style='text-align: justify;'>Berdasarkan hasil Keputusan Rapat Panitia Penerimaan Mahasiswa Baru Universitas Fajar Tahun Akademik $tahunmasuk/$tahunmasukend, kami sampaikan bahwa Anda dinyatakan <strong>LULUS</strong> pada program studi <strong>$current_prodi[prodiNamaResmi]</strong>. Selanjutnya Anda diharapkan untuk segera melakukan pembayaran dengan rincian biaya sebagai berikut:</p>
                <table style='border-collapse: collapse;' border='0' width='100%' cellspacing='0' cellpadding='0'>
                <thead>
                <tr style='background: #fefe00;'>
                <td style='border: 1px solid #000; border-collapse: collapse; text-align: center;'><span style='font-size: 10pt;'><strong>Jenis Pembayaran</strong></span></td>
                <td style='border: 1px solid #000; border-collapse: collapse; text-align: center; width:100px;'><span style='font-size: 10pt;'><strong>Jumlah</strong></span></td>
                </tr>
                </thead>
                <tbody>
                <tr style='border: 1px solid #000; border-collapse: collapse;'>
                <td style='border: 1px solid #000; border-collapse: collapse;'><strong>Pra Akademik</strong> <br /><small>Hanya di Semester I</small></td>
                <td style='text-align: left;'>" . $this->rupiah($current_prodi['biaya_pra_akademik']) . "</td>
                </tr>
                ";
                    if ($current_peserta['jalur_pendaftaran'] != '3') {
                        $message .= "<tr style='border: 1px solid #000; border-collapse: collapse;'>
                                                    <td style='border: 1px solid #000; border-collapse: collapse;'><strong>Sumbangan Penyelenggaraan Pendidikan (SPP)</strong><br><small>Dapat diangsur di Semester I & II, dengan min pembayaran Rp. 1.500.000,-</small></td>
                                                    <td style='text-align: left;'>" . $this->rupiah($current_prodi['biaya_spp']) . "</td>
                                                </tr>
                                                <tr style='border: 1px solid #000; border-collapse: collapse;'>
                                                <td style='border: 1px solid #000; border-collapse: collapse;'><strong>Biaya Penyelenggaraan Pendidikan (BPP) PAKET</strong><br /><small>Setiap Semester dan dapat diangsur sebanyak 4 (empat) bulan, dengan min pembayaran Rp. 750.000,-</small></td>
                                                    <td style='text-align: left;'>" . $this->rupiah($current_prodi['biaya_sks']) . "</td>
                                                </tr>";
                    }
                    $message .= "
                <tr style='border: 1px solid #000; border-collapse: collapse;'>
                <td style='border: 1px solid #000; border-collapse: collapse;'><strong>Seragam</strong><br /><small>Hanya di Semester I</small></td>
                <td style='text-align: left;'>" . $this->rupiah($current_prodi['biaya_seragam']) . "</td>
                </tr>
                <tr style='border: 1px solid #000; border-collapse: collapse; background: #dddddd;'>
                <td style='border: 1px solid #000; border-collapse: collapse;'><strong>TOTAL PEMBAYARAN</strong></td>
                <td style='text-align: left;'><strong>" . $this->rupiah($totalbiaya) . "</strong></td>
                </tr>
                </tbody>
                </table>
                <p style='text-align: left;'><span style='font-size: 8pt;'><em><strong>Keterangan</strong>:</em></span></p>
                <ul>
                <li style='text-align: left;'><span style='font-size: 10px;'><em>Untuk mengetahui rincian skema pembayaran dapat dilihat disini: <a href='$urlSkemaPembayaran' target='_blank'>Skema Pembayaran</a> </em></li>
                <li style='text-align: left;'><span style='font-size: 10px;'><em>Semester 1 s/d 4 hanya membayar BPP dengan tarif normal.</em></span></li>
                <li style='text-align: left;'><span style='font-size: 10px;'><em>Semester 5 dan seturusnya hanya membayar BPP sebesar 50% dari tarif normal jika yang diprogramkan Tugas Akhir dan Maksimum 2 Matakuliah Akhir.</em></span></li>
                <li style='text-align: left;'><span style='font-size: 10px;'><em>Semester 5 dan seturusnya membayar BPP dengan tarif normal jika yang diprogramkan Tugas Akhir dan Lebih dari 2 Matakuliah.</em></span></li>
                <li style='text-align: left;'><span style='font-size: 10px;'><em>BPP dapat diangsur hingga penyelenggaraan Ujian Tengah Semester setiap semester.</em></span></li>
                <li style='text-align: left;'><span style='font-size: 10px;'><em>Petunjuk pembayaran ke Virtual Account Bank Syariah Indonesia (BSI) <a href='$urlfileCaraBayar' target='_blank'>Download</a>.</em></span></li>
                </ul>
                <p style='text-align: justify;'>Lakukan pembayaran melalui transfer ke Nomor Virtual Account Bank Syariah Indonesia (BSI), di bawah ini :</p>
                <span style='display: inline-block; padding-top: 12px; padding-left: 24px; padding-bottom: 12px; padding-right: 24px; text-decoration: none; background-color: #47bbe4; border-radius: 5px; font-weight: bold; color: #ffffff; text-transform: uppercase; font-size: 16px;'>$virtualaccount</span>
                <p style='text-align: justify;'>Pembayaran wajib dilakukan paling lambat tanggal <span style='background-color: #ffff00;'><strong>" . $this->tanggal_indo($batasbayaremail) . "</strong></span>. Jika tidak melakukan pembayaran hingga batas waktu yang ditentukan, maka Anda dinyatakan <strong>Mengundurkan Diri</strong>.</p>
                <p style='text-align: justify;'>Sebelum melakukan pembayaran, harap mengisi surat penyataan di bawah:<br /> <strong>1. Surat Penyataan Biro Kemahasiswaan</strong> : <a href='$urlpernyataanKemahasiswaan' target='_blank'>Download</a><br /> <strong>2. Surat Penyataan Biro Keuangan</strong> : <a href='$urlpernyataanKeuangan' target='_blank'>Download</a><br /> Surat penyataan disetor langsung di Biro Keuangan yang berlokasi di kampus Universitas Fajar.</p>
                <p style='text-align: justify;'>Informasi lebih lanjut terkait Pembayaran, silahkan hubungi Biro Keuangan UNIFA via TELP/WHATSAPP/TELEGRAM/SMS: <strong>0822 3399 9389</strong> setiap hari kerja (Jam 08.00 sd 17.00 wita).</p>
                <p style='text-align: justify;'>Demikian yang perlu kami sampaikan, atas perhatiannya kami sampaikan terima kasih.</p>
                </td>
                </tr>
                </tbody>
                </table>
                </td>
                </tr>
                <tr>
                    <td style='padding: 30px 30px;' bgcolor='#013880'>
                        <table style='border-collapse: collapse;' border='0' width='100%' cellspacing='0' cellpadding='0'>
                        <tbody>
                            <tr>
                                <td style='color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;'>
                                <p style='margin: 0;'>&copy; Universitas Fajar<br /> PANITIA PMB <a style='color: #ffffff;' href='#'>' . date('Y') . '</a></p>
                                </td>
                                <td align='right'>&nbsp;</td>
                            </tr>
                        </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
                </table>
                </td>
                </tr>
                </tbody>
                </table>";
                } elseif ($current_peserta['jenjang_studi_id'] == '2') {
                    if ($current_prodi['fakultas_id'] == '1') {
                        $bulanan = 'Rp. 1.062.500,-';
                    } elseif ($current_prodi['fakultas_id'] == '2') {
                        $bulanan = 'Rp. 1.125.000,-';
                    }
                    $message = "
                    <table border='0' width='100%' cellspacing='0' cellpadding='0'>
                    <tbody>
                    <tr>
                    <td style='padding: 20px 0 30px 0;'>
                    <table style='border-collapse: collapse; border: 1px solid #cccccc;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
                    <tbody>
                    <tr>
                    <td style='padding: 40px 0 30px 0;' align='center' bgcolor='#003679'><img style='display: block;' src='" . $website_url . DIR_INC . "/images/unifamail.png' alt='LOGO SIMBA.' /></td>
                    </tr>
                    <tr>
                    <td style='padding: 40px 30px 40px 30px;' bgcolor='#ffffff'>
                    <table style='border-collapse: collapse;' border='0' width='100%' cellspacing='0' cellpadding='0'>
                    <tbody>
                    <tr>
                    <td style='color: #153643; font-family: Arial, sans-serif; font-size: 14px; line-height: 24px; padding: 20px 0px 30px; text-align: center;'>
                    <p style='text-align: left;'>Yang Terhormat <br /> <strong>$username</strong>. <br /> Calon Mahasiswa Baru Universitas Fajar <br /> Tahun Akademik $tahunmasuk/$tahunmasukend <br /> Di Tempat</p>
                    <p style='text-align: justify;'>Berdasarkan hasil Keputusan Rapat Panitia Penerimaan Mahasiswa Baru Universitas Fajar Tahun Akademik $tahunmasuk/$tahunmasukend, kami sampaikan bahwa Anda dinyatakan <strong>LULUS</strong> pada program studi <strong>$current_prodi[prodiNamaResmi]</strong>. Selanjutnya Anda diharapkan untuk segera melakukan pembayaran dengan rincian biaya sebagai berikut:</p>
                    <table style='border-collapse: collapse;' border='0' width='100%' cellspacing='0' cellpadding='0'>
                    <thead>
                    <tr style='background: #fefe00;'>
                        <td style='border: 1px solid #000; border-collapse: collapse; text-align: center;'><span style='font-size: 10pt;'><strong>Jenis Pembayaran</strong></span></td>
                        <td style='border: 1px solid #000; border-collapse: collapse; text-align: center; width:100px;'><span style='font-size: 10pt;'><strong>Jumlah</strong></span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style='border: 1px solid #000; border-collapse: collapse;'>
                    <td style='border: 1px solid #000; border-collapse: collapse;'><strong>Pra Akademik</strong><br><small>Hanya di Semester I</small></td>
                    <td style='text-align: left;'>" . $this->rupiah($current_prodi['biaya_pra_akademik']) . "</td>
                    </tr>";
                    if ($current_peserta['jalur_pendaftaran'] != '3') {
                        $message .= "<tr style='border: 1px solid #000; border-collapse: collapse;'>
                                                    <td style='border: 1px solid #000; border-collapse: collapse;'><strong>Sumbangan Penyelenggaraan Pendidikan (SPP)</strong><br><small>Dapat diangsur di Semester I & II, dengan min pembayaran Rp. 3.000.000,-</small></td>
                                                    <td style='text-align: left;'>" . $this->rupiah($current_prodi['biaya_spp']) . "</td>
                                                </tr>
                                                <tr style='border: 1px solid #000; border-collapse: collapse;'>
                                                    <td style='border: 1px solid #000; border-collapse: collapse;'><strong>Biaya Penyelenggaraan Pendidikan (BPP) PAKET</strong><br /><small>Setiap Semester dan dapat diangsur sebanyak 4 (empat) bulan, dengan min pembayaran $bulanan</small></td>
                                                    <td style='text-align: left;'>" . $this->rupiah($current_prodi['biaya_sks']) . "</td>
                                                </tr>";
                    }
                    $message .= "
                    <tr style='border: 1px solid #000; border-collapse: collapse; background: #dddddd;'>
                        <td style='border: 1px solid #000; border-collapse: collapse;'><strong>TOTAL PEMBAYARAN</strong></td>
                        <td style='text-align: left;'><strong>" . $this->rupiah($totalbiaya) . "</strong></td>
                    </tr>
                    </tbody>
                    </table>
                    <p style='text-align: left;'><span style='font-size: 8pt;'><em><strong>Keterangan</strong>:</em></span></p>
                    <ul>
                    <li style='text-align: left;'><span style='font-size: 10px;'><em>Untuk mengetahui rincian skema pembayaran dapat dilihat disini: <a href='$urlSkemaPembayaran' target='_blank'>Skema Pembayaran</a> </em></li>
                        <li style='text-align: left;'><span style='font-size: 10px;'><span style='font-size: 10px;'><em>Semester 1 s/d 8 hanya membayar BPP dengan tarif normal.</em></span></li>
                        <li style='text-align: left;'><span style='font-size: 10px;'><span style='font-size: 10px;'><em>Semester 9 dan seturusnya hanya membayar BPP sebesar 50% dari tarif normal jika yang diprogramkan Tugas Akhir dan Maksimum 2 Matakuliah Akhir.</em></span></li>
                        <li style='text-align: left;'><span style='font-size: 10px;'><span style='font-size: 10px;'><em>Semester 9 dan seturusnya membayar BPP dengan tarif normal jika yang diprogramkan Tugas Akhir dan Lebih dari 2 Matakuliah.</em></span></li>
                        <li style='text-align: left;'><span style='font-size: 10px;'><span style='font-size: 10px;'><em>BPP dapat diangsur hingga penyelenggaraan Ujian Tengah Semester setiap semester.</em></span></li>
                        <li style='text-align: left;'><span style='font-size: 10px;'><span style='font-size: 10px;'><em>Petunjuk pembayaran ke Virtual Account Bank Syariah Indonesia (BSI) <a href='$urlfileCaraBayar' target='_blank'>Download</a>.</em></span></li>
                    </ul>
                    <p style='text-align: justify;'>Lakukan pembayaran melalui transfer ke Nomor Virtual Account Bank Syariah Indonesia (BSI), di bawah ini :</p>
                    <span style='display: inline-block; padding-top: 12px; padding-left: 24px; padding-bottom: 12px; padding-right: 24px; text-decoration: none; background-color: #47bbe4; border-radius: 5px; font-weight: bold; color: #ffffff; text-transform: uppercase; font-size: 16px;'>$virtualaccount</span>
                    <p style='text-align: justify;'>Pembayaran wajib dilakukan paling lambat tanggal <span style='background-color: #ffff00;'><strong>" . $this->tanggal_indo($batasbayaremail) . "</strong></span>. Jika tidak melakukan pembayaran hingga batas waktu yang ditentukan, maka Anda dinyatakan <strong>Mengundurkan Diri</strong>.</p>
                    <p style='text-align: justify;'>Sebelum melakukan pembayaran, harap mengisi surat penyataan di bawah:<br /> <strong>1. Surat Penyataan Biro Kemahasiswaan</strong> : <a href='$urlpernyataanKemahasiswaan' target='_blank'>Download</a><br /> <strong>2. Surat Penyataan Biro Keuangan</strong> : <a href='$urlpernyataanKeuangan' target='_blank'>Download</a><br /> Surat penyataan disetor langsung di Biro Keuangan yang berlokasi di kampus Universitas Fajar.</p>
                    <p style='text-align: justify;'>Informasi lebih lanjut terkait Pembayaran, silahkan hubungi Biro Keuangan UNIFA via TELP/WHATSAPP/TELEGRAM/SMS: <strong>0822 3399 9389</strong> setiap hari kerja (Jam 08.00 sd 17.00 wita).</p>
                    <p style='text-align: justify;'>Demikian yang perlu kami sampaikan, atas perhatiannya kami sampaikan terima kasih.</p>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    </td>
                    </tr>
                    <tr>
                    <td style='padding: 30px 30px;' bgcolor='#013880'>
                    <table style='border-collapse: collapse;' border='0' width='100%' cellspacing='0' cellpadding='0'>
                    <tbody>
                    <tr>
                    <td style='color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;'>
                    <p style='margin: 0;'>&copy; Universitas Fajar<br /> PANITIA PMB <a style='color: #ffffff;' href='#'>" . date('Y') . "</a></p>
                    </td>
                    <td align='right'>&nbsp;</td>
                    </tr>
                    </tbody>
                    </table>
                    </td>
                    </tr>
                    </tbody>
                    </table>";
                } elseif ($current_peserta['jenjang_studi_id'] == '3') {
                    if ($current_prodi['prodiKode'] == '39') {
                        $bulanan = 'Rp. 1.750.000,-';
                    } else {
                        $bulanan = 'Rp. 1.375.000,-';
                    }
                    $message = "
                    <table border='0' width='100%' cellspacing='0' cellpadding='0'>
                    <tbody>
                    <tr>
                    <td style='padding: 20px 0 30px 0;'>
                    <table style='border-collapse: collapse; border: 1px solid #cccccc;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
                    <tbody>
                    <tr>
                    <td style='padding: 40px 0 30px 0;' align='center' bgcolor='#003679'><img style='display: block;' src='" . $website_url . DIR_INC . "/images/unifamail.png' alt='LOGO SIMBA.' /></td>
                    </tr>
                    <tr>
                    <td style='padding: 40px 30px 40px 30px;' bgcolor='#ffffff'>
                    <table style='border-collapse: collapse;' border='0' width='100%' cellspacing='0' cellpadding='0'>
                    <tbody>
                    <tr>
                    <td style='color: #153643; font-family: Arial, sans-serif; font-size: 14px; line-height: 24px; padding: 20px 0px 30px; text-align: center;'>
                    <p style='text-align: left;'>Yang Terhormat <br /> <strong>$username</strong>. <br /> Calon Mahasiswa Baru Universitas Fajar <br /> Tahun Akademik $tahunmasuk/$tahunmasukend <br /> Di Tempat</p>
                    <p style='text-align: justify;'>Berdasarkan hasil Keputusan Rapat Panitia Penerimaan Mahasiswa Baru Universitas Fajar Tahun Akademik $tahunmasuk/$tahunmasukend, kami sampaikan bahwa Anda dinyatakan <strong>LULUS</strong> pada program studi <strong>$current_prodi[prodiNamaResmi]</strong>. Selanjutnya Anda diharapkan untuk segera melakukan pembayaran dengan rincian biaya sebagai berikut:</p>
                    <table style='border-collapse: collapse;' border='0' width='100%' cellspacing='0' cellpadding='0'>
                    <thead>
                    <tr style='background: #fefe00;'>
                    <td style='border: 1px solid #000; border-collapse: collapse; text-align: center;'><span style='font-size: 10pt;'><strong>Jenis Pembayaran</strong></span></td>
                    <td style='border: 1px solid #000; border-collapse: collapse; text-align: center; width:100px'><span style='font-size: 10pt;'><strong>Jumlah</strong></span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style='border: 1px solid #000; border-collapse: collapse;'>
                    <td style='border: 1px solid #000; border-collapse: collapse;'><strong>Pra Akademik</strong><br><small>Hanya di Semester I</small></td>
                    <td style='text-align: left;'>" . $this->rupiah($current_prodi['biaya_pra_akademik']) . "</td>
                    </tr>
                    <tr style='border: 1px solid #000; border-collapse: collapse;'>
                        <td style='border: 1px solid #000; border-collapse: collapse;'><strong>Biaya Penyelenggaraan Pendidikan (BPP) PAKET</strong><br><small>Setiap Semester dan dapat diangsur sebanyak 4 (empat) bulan, dengan min pembayaran $bulanan</small></td>
                        <td style='text-align: left;'>" . $this->rupiah($current_prodi['biaya_sks']) . "</td>
                    </tr>
                    <tr style='border: 1px solid #000; border-collapse: collapse; background: #dddddd;'>
                        <td style='border: 1px solid #000; border-collapse: collapse;'>TOTAL PEMBAYARAN </td>
                        <td style='text-align: left;'><strong>" . $this->rupiah($totalbiaya) . "</strong></td>
                    </tr>
                    </tbody>
                    </table>
                    <p style='text-align: left;'><span style='font-size: 8pt;'><em><strong>Keterangan</strong>:</em></span></p>
                     <ul>
                    <li style='text-align: left;'><span style='font-size: 10px;'><em>Untuk mengetahui rincian skema pembayaran dapat dilihat disini: <a href='$urlSkemaPembayaran' target='_blank'>Skema Pembayaran</a> </em></li>
                        <li><span style='font-size: 10px;'><em>Semester 1 s/d 4 hanya membayar BPP dengan tarif normal.</em></span></li>
                        <li><span style='font-size: 10px;'><em>Semester 5 dan seturusnya hanya membayar BPP sebesar 50% dari tarif normal jika yang diprogramkan Tugas Akhir dan Maksimum 2 Matakuliah Akhir.</em></span></li>
                        <li><span style='font-size: 10px;'><em>Semester 5 dan seturusnya membayar BPP dengan tarif normal jika yang diprogramkan Tugas Akhir dan Lebih dari 2 Matakuliah.</em></span></li>
                        <li><span style='font-size: 10px;'><em>BPP dapat diangsur hingga penyelenggaraan Ujian Tengah Semester setiap semester.</em></span></li>
                        <li><span style='font-size: 10px;'><em>Petunjuk pembayaran ke Virtual Account Bank Syariah Indonesia (BSI) <a href='$urlfileCaraBayar' target='_blank'>Download</a>.</em></span></li>
                    </ul>
                    <p style='text-align: justify;'>Lakukan pembayaran melalui transfer ke Nomor Virtual Account Bank Syariah Indonesia (BSI), di bawah ini :</p>
                    <span style='display: inline-block; padding-top: 12px; padding-left: 24px; padding-bottom: 12px; padding-right: 24px; text-decoration: none; background-color: #47bbe4; border-radius: 5px; font-weight: bold; color: #ffffff; text-transform: uppercase; font-size: 16px;'>$virtualaccount</span>
                    <p style='text-align: justify;'>Pembayaran wajib dilakukan paling lambat tanggal <span style='background-color: #ffff00;'><strong>" . $this->tanggal_indo($batasbayaremail) . "</strong></span>. Jika tidak melakukan pembayaran hingga batas waktu yang ditentukan, maka Anda dinyatakan <strong>Mengundurkan Diri</strong>.</p>
                <p style='text-align: justify;'>Sebelum melakukan pembayaran, harap mengisi surat penyataan di bawah:<br /> <strong>1. Surat Penyataan Biro Kemahasiswaan</strong> : <a href='$urlpernyataanKemahasiswaan' target='_blank'>Download</a><br /> <strong>2. Surat Penyataan Biro Keuangan</strong> : <a href='$urlpernyataanKeuangan' target='_blank'>Download</a><br /> Surat penyataan disetor langsung di Biro Keuangan yang berlokasi di kampus Universitas Fajar.</p>
                    <p style='text-align: justify;'>Informasi lebih lanjut terkait Pembayaran, silahkan hubungi Biro Keuangan UNIFA via TELP/WHATSAPP/TELEGRAM/SMS: <strong>0822 3399 9389</strong> setiap hari kerja (Jam 08.00 sd 17.00 wita).</p>
                    <p style='text-align: justify;'>Demikian yang perlu kami sampaikan, atas perhatiannya kami sampaikan terima kasih.</p>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    </td>
                    </tr>
                    <tr>
                    <td style='padding: 30px 30px;' bgcolor='#013880'>
                    <table style='border-collapse: collapse;' border='0' width='100%' cellspacing='0' cellpadding='0'>
                    <tbody>
                    <tr>
                    <td style='color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;'>
                    <p style='margin: 0;'>&copy; Universitas Fajar<br /> PANITIA PMB <a style='color: #ffffff;' href='#'>" . date('Y') . "</a></p>
                    </td>
                    <td align='right'>&nbsp;</td>
                    </tr>
                    </tbody>
                    </table>
                    </td>
                    </tr>
                    </tbody>
                    </table>";
                }

                if ($this->posetting[23]['value'] != 'SMTP') {
                    $poemail = new PoEmail;
                    $send = $poemail->setOption(array(messageType => 'html'))
                        ->to($email)
                        ->subject($subject)
                        ->message($message)
                        ->from($from)
                        ->mail();
                } else {
                    $this->pomail->isSMTP();
                    $this->pomail->SMTPDebug = 0;
                    $this->pomail->Debugoutput = 'html';
                    $this->pomail->Host = $this->posetting[24]['value'];
                    $this->pomail->Port = $this->posetting[27]['value'];
                    $this->pomail->SMTPSecure = 'tls';
                    $this->pomail->SMTPAuth = true;
                    $this->pomail->Username = $this->posetting[25]['value'];
                    $this->pomail->Password = $this->posetting[26]['value'];
                    $this->pomail->setFrom($this->posetting[5]['value'], $this->posetting[0]['value']);
                    $this->pomail->addReplyTo($this->posetting[5]['value'], $this->posetting[0]['value']);
                    $this->pomail->addAddress($email, $username);
                    $this->pomail->Subject = $subject;
                    $this->pomail->Body = $message;
                    $this->pomail->IsHTML(true);
                    $this->pomail->send();
                }
                // echo $message;
            } else {

                $current_peserta   = $this->podb->from('peserta')->where('id_peserta', $this->postring->valid($_POST['id'], 'sql'))->limit(1)->fetch();
                $current_jalur     = $this->podb->from('jalur_pendaftaran')->where('jalur_pendaftaran_id', $current_peserta['jalur_pendaftaran'])->limit(1)->fetch();
                $website_name      = $this->posetting[0]['value'];
                $website_url       = $this->posetting[1]['value'];
                $subject           = "PENGUMUMAN SELEKSI MASUK UNIFA";
                $tahunmasuk        = $this->posetting[30]['value'];
                $tahunmasukend     = $this->posetting[30]['value'] + 1;
                $from              = $this->posetting[5]['value'];
                $telpon            = $this->posetting[7]['value'];
                $koderegis         = $current_peserta['kode_registrasi'];
                $ponsel            = $current_peserta['telp_peserta'];
                $username          = $current_peserta['nama_lengkap_peserta'];
                $email             = $current_peserta['email_peserta'];
                $message = "<html>
                                <body>
                                    <br/>
                                    <p>Yang Terhormat $username,<br /> Calon Mahasiswa Baru Universitas Fajar Tahun Akademik $tahunmasuk/$tahunmasukend <br /> Di tempat<br /><br /></p>
                                    <p style='align: justify;'>Bersama dengan surel ini, kami sampaikan bahwa Anda dinyatakan $_POST[statusseleksi] </p>
                                    
                                    <p><br /> Silahkan mencoba ditahun depan.</p>
                                    <p>&nbsp;</p>
                                    <p>Salam hangat,<br /><strong>PANITIA SIMBA UNIFA</strong>.<br /><br /><br /></p>
                                                        
                                </body>
                            </html>";

                if ($this->posetting[23]['value'] != 'SMTP') {
                    $poemail = new PoEmail;
                    $send = $poemail->setOption(array(messageType => 'html'))
                        ->to($email)
                        ->subject($subject)
                        ->message($message)
                        ->from($from)
                        ->mail();
                } else {
                    $this->pomail->isSMTP();
                    $this->pomail->SMTPDebug = 0;
                    $this->pomail->Debugoutput = 'html';
                    $this->pomail->Host = $this->posetting[24]['value'];
                    $this->pomail->Port = $this->posetting[27]['value'];
                    $this->pomail->SMTPSecure = 'tls';
                    $this->pomail->SMTPAuth = true;
                    $this->pomail->Username = $this->posetting[25]['value'];
                    $this->pomail->Password = $this->posetting[26]['value'];
                    $this->pomail->setFrom($this->posetting[5]['value'], $this->posetting[0]['value']);
                    $this->pomail->addReplyTo($this->posetting[5]['value'], $this->posetting[0]['value']);
                    $this->pomail->addAddress($email, $username);
                    $this->pomail->Subject = $subject;
                    $this->pomail->Body = $message;
                    $this->pomail->IsHTML(true);
                    $this->pomail->send();
                }
            }

            unset($_POST);

            $this->poflash->success('Berhasil! Hasil seleksi masuk telah ditentukan', 'admin.php?mod=peserta');
        }
        $id = $this->postring->valid($_GET['id'], 'xss');
        $current_peserta = $this->podb->from('peserta')
            ->where('id_session', $id)
            ->limit(1)
            ->fetch();
        if (empty($current_peserta)) {
            echo $this->pohtml->error();
            exit;
        }
        $settings = $this->podb->from('setting')->fetchAll();

        $current_jalur = $this->podb->from('jalur_pendaftaran')
            ->where('jalur_pendaftaran_id', $current_peserta['jalur_pendaftaran'])
            ->orderBy('jalur_pendaftaran_nama ASC')
            ->limit('1')
            ->fetch();
        $current_raport = $this->podb->from('raport')
            ->where('id_peserta', $current_peserta['id_peserta'])
            ->where('tahun_ajaran', $this->posetting[30]['value'])
            ->limit('1')
            ->fetch();

    ?>

        <div class="block-content">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->pohtml->headTitle($GLOBALS['_']['peserta_seleksi']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form role="form" method="post" action="route.php?mod=peserta&act=hasilseleksi" autocomplete="off">
                        <?= $this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_peserta['id_peserta'])); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="kode" class="col-md-3 label-inline">No. Peserta </label>
                                        <div class="col-md-4">
                                            <input type="text" name="kode" value="<?= $current_peserta['no_peserta']; ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="nama" class="col-md-3 label-inline">Nama Lengkap </label>
                                        <div class="col-md-9">
                                            <input type="text" value="<?= ucwords($current_peserta['nama_lengkap_peserta']); ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="jalur" class="col-md-3 label-inline">Jalur Pendaftaran </label>
                                        <div class="col-md-5">
                                            <input type="text" value="<?= strtoupper($current_jalur['jalur_pendaftaran_nama']); ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="prodilulus" class="col-md-3 label-inline">Prodi Tujuan </label>
                                        <div class="col-md-6">
                                            <?php
                                            $pil_satu = $this->podb->from('program_studi')
                                                ->where('prodiKode', $current_peserta['pilihan_pertama'])
                                                ->limit(1)
                                                ->fetch();

                                            ?>
                                            <input type="hidden" name="prodilulus" value="<?= $current_peserta['pilihan_pertama']; ?>" />
                                            <input type="text" value="<?= $pil_satu['prodiNamaResmi']; ?>" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="statusseleksi" class="col-md-3 label-inline">Status Seleksi </label>
                                        <div class="col-md-4">
                                            <select class="form-control" id="statusseleksi" name="statusseleksi" required>
                                                <?php
                                                if (!empty($current_peserta['status_seleksi'])) {
                                                    $valueseleksi = $current_peserta['status_seleksi'];
                                                    $tampilseleksi = "Terpilih - " . $current_peserta['status_seleksi'];
                                                } else {
                                                    $valueseleksi = '';
                                                    $tampilseleksi = 'Pilih';
                                                }
                                                ?>
                                                <option value="<?= $valueseleksi; ?>" hidden=""><?= $tampilseleksi; ?></option>
                                                <option value="Lulus">Lulus</option>
                                                <option value="Cadangan">Cadangan</option>
                                                <option value="Tidak Lulus">Tidak Lulus</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="col-md-12">
                            <?= $this->pohtml->formAction(); ?>
                        </div>
                        <?= $this->pohtml->formEnd(); ?>
                </div>
            </div>
        </div>

    <?php

    }
    /**
     * Fungsi ini digunakan untuk hasil tpa.
     *
     * This function use for tpa.
     *
     */
    public function gantipassword()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'update')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $newpass = md5($_POST['renewpassword']);
            $datapeserta = array(
                'password' => $newpass
            );
            $querypeserta = $this->podb->update('peserta')
                ->set($datapeserta)
                ->where('id_peserta', $this->postring->valid($_POST['id'], 'xss'));
            $querypeserta->execute();

            $this->poflash->success('Berhasil! Ganti Password', 'admin.php?mod=peserta');
        }
        $id = $this->postring->valid($_GET['id'], 'xss');
        $current_peserta = $this->podb->from('peserta')
            ->where('id_session', $id)
            ->limit(1)
            ->fetch();

        if (empty($current_peserta)) {
            echo $this->pohtml->error();
            exit;
        }


    ?>

        <div class="block-content">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->pohtml->headTitle('Ganti Password'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form role="form" method="post" id="passwordForm" action="route.php?mod=peserta&act=gantipassword" autocomplete="off">
                        <?= $this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_peserta['id_peserta'])); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="kode" class="col-md-3 label-inline">Password Baru </label>
                                        <div class="col-md-3">
                                            <input type="password" name="newpassword" id="newpassword" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="nama" class="col-md-3 label-inline">Ulangi Password Baru </label>
                                        <div class="col-md-3">
                                            <input type="password" class="form-control" name="renewpassword" id="renewpassword" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <?= $this->pohtml->formAction(); ?>
                        </div>
                        <?= $this->pohtml->formEnd(); ?>
                </div>
            </div>
        </div>

<?php }

    /**
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman membaca smta.
     *
     * This function is used to display and process read smta page.
     *
     */
    public function smta()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'read')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $html = "";
            $smta = $this->podb->from('smta')
                ->where('id_wil', $_POST['kota_id'])
                ->orderBy('smtaKode ASC')
                ->fetchAll();
            if (!empty($smta)) {
                foreach ($smta as $ta) {
                    $html .= '<option value="' . $ta['smtaKode'] . '">' . $ta['smtaNama'] . '</option>';
                }
            } else {
                $html = '<option value="0">LAINNYA</option>';
            }
            $callback = array('data_smta' => $html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota
            echo json_encode($callback); // konversi varibael $callback menjadi JSON    

        }
    }

    /**
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman membaca prodi.
     *
     * This function is used to display and process read prodi page.
     *
     */
    public function prodi()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'read')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $prodi = $this->podb->from('program_studi')
                ->where('jenjang_studi_id', $_POST['jenjang_id'])
                ->orderBy('prodiNamaSingkat ASC')
                ->fetchAll();
            if (!empty($prodi)) {
                foreach ($prodi as $pr) {
                    echo '<option value="' . $pr['prodiKode'] . '">' . strtoupper($pr['prodiNamaSingkat']) . '</option>';
                }
            } else {
                echo '<option value="0">LAINNYA</option>';
            }
        }
    }

    /**
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman membaca universitas.
     *
     * This function is used to display and process read universitas page.
     *
     */
    public function universitas()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'read')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {

            $json = array();
            $universitas = $this->podb->from('universitas')
                ->where('nama_universitas LIKE "%' . $_POST['cari'] . '%"')
                ->orderBy('nama_universitas ASC')
                ->fetchAll();
            if (!empty($universitas)) {
                foreach ($universitas as $un) {
                    $json[] = array('universitas' => strtoupper($un['nama_universitas']), 'iduniv' => $un['kode_universitas']);
                }
            }
            echo json_encode($json);
        }
    }

    /**
     * Fungsi ini digunakan untuk mengganti mengaktifkan akun.
     *
     * This function use for change account activation.
     *
     */
    public function penilaianwawancara()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'update')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $datapeserta = array(
                'jadwal_sudah' => 'Y',
                'nilai_wawancara' => $_POST['nilai'],
                'id_user' => $_SESSION['iduser'],
                'tanggal_penilaian' => date('Y-m-d')
            );
            $querypeserta = $this->podb->update('wawancara')
                ->set($datapeserta)
                ->where('id_peserta', $this->postring->valid($_POST['id'], 'sql'));
            $querypeserta->execute();

            unset($_POST);
            $this->poflash->success('Penilaian wawancara berhasil disimpan', 'admin.php?mod=peserta');
        }
    }
}
