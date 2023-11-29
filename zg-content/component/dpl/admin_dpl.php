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

class dpl extends PoCore
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
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'read')) {
            echo $this->pohtml->error();
            exit;
        } ?>
<div class="block-content">
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->headTitle('Kelas DPL', ''); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
                    $columns = array(
                        array('title' => 'Kode Dosen', 'options' => ''),
                        array('title' => 'BKP', 'options' => ''),
                        array('title' => 'Mhs. Program', 'options' => ''),
                        array('title' => 'Mhs. Belum Ada Kelas', 'options' => ''),
                        array('title' => 'Kelas DPL', 'options' => 'class="no-sort" style="width:150px;"')
                    );
                    ?>
            <?= $this->pohtml->createTable(array('id' => 'table-dpl', 'class' => 'table table-striped table-bordered'), $columns, $tfoot = false); ?>

        </div>
    </div>
</div>
<?= $this->pohtml->dialogAktifasi('dpl'); ?>
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
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'read')) {
            echo $this->pohtml->error();
            exit;
        }
        $table = 'peserta';
        $primarykey = 'no_peserta';
        $settings = $this->podb->from('setting')->fetchAll();
        $columns = array(
            array('db' => 'p.id_session', 'dt' => null, 'field' => 'id_session'),
            array('db' => 'p.status_seleksi', 'dt' => null, 'field' => 'status_seleksi'),
            array('db' => 'p.jalur_pendaftaran', 'dt' => null, 'field' => 'jalur_pendaftaran'),
            array('db' => 'p.pilihan_pertama', 'dt' => null, 'field' => 'pilihan_pertama'),
            array('db' => 'p.prodi_lulus', 'dt' => null, 'field' => 'prodi_lulus'),
            array('db' => 'p.id_peserta', 'dt' => 'null', 'field' => 'id_peserta'),
            array('db' => 'p.' . $primarykey, 'dt' => '0', 'field' => $primarykey),
            array(
                'db' => 'p.nama_lengkap_peserta', 'dt' => '1', 'field' => 'nama_lengkap_peserta',
                'formatter' => function ($d, $row, $i) {
                    $namacapital = ucwords(strtolower($row['nama_lengkap_peserta']));
                    return $namacapital;
                }
            ),
            array('db' => 'jl.jalur_pendaftaran_nama', 'dt' => '2', 'field' => 'jalur_pendaftaran_nama'),
            array('db' => 'p.gelombang_daftar', 'dt' => '3', 'field' => 'gelombang_daftar'),
            array('db' => 'p.tahun_ajaran', 'dt' => '4', 'field' => 'tahun_ajaran'),
            array(
                'db' => 'p.' . $primarykey, 'dt' => '5', 'field' => $primarykey,
                'formatter' => function ($d, $row, $i) {
                    if (empty($row['status_seleksi'])) {
                        $status = "-";
                    } else {
                        $prodix = $this->podb->from('program_studi')->where('prodiKode', $row['prodi_lulus'])->fetch();
                        if ($row['status_seleksi'] == "Lulus") {
                            $status = "<span class='label label-success'>Lulus Pada Prodi $prodix[prodiNamaSingkat]</span>";
                        } elseif ($row['status_seleksi'] == "Cadangan") {
                            $status = "<span class='label label-warning'>Cadangan Pada Prodi $prodix[prodiNamaSingkat]</span>";
                        } else {
                            $status = "<span class='label label-danger'>Tidak Lulus</span>";
                        }
                    }
                    return "$status";
                }
            ),
            array(
                'db' => 'p.' . $primarykey, 'dt' => '6', 'field' => $primarykey,
                'formatter' => function ($d, $row, $i) {
                    if ($_SESSION['leveluser'] == '9') {
                        $tombolaksi = "
                            <a href='#' class='btn btn-xs btn-success aktifdata'  data-toggle='tooltip' title='Validasi Pembayaran Daftar Ulang' id='" . $row['id_peserta'] . "'><i class='fa fa-lock'></i> <i class='fa fa-money'></i></a>
                            <a href='admin.php?mod=dpl&act=edit&id=" . $row['id_session'] . "' class='btn btn-xs btn-default' data-toggle='tooltip' title='Detail'><i class='fa fa-pencil'></i></a>
						    <a href='admin.php?mod=dpl&act=gantipassword&id=" . $row['id_session'] . "' class='btn btn-xs btn-default' style='background:#2D1780; border-color:#2D1780;' data-toggle='tooltip' title='Ganti Password'><i class='fa fa-key'></i></a>
                            ";
                    } else {
                        $tombolaksi = "
                            <a href='admin.php?mod=dpl&act=dpl&id=" . $row['id_session'] . "' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Penentuan Seleksi'><i class='fa fa-bullhorn'></i></a>
                            <a href='admin.php?mod=dpl&act=edit&id=" . $row['id_session'] . "' class='btn btn-xs btn-default' data-toggle='tooltip' title='Detail'><i class='fa fa-pencil'></i></a>
						    <a href='admin.php?mod=dpl&act=gantipassword&id=" . $row['id_session'] . "' class='btn btn-xs btn-default' style='background:#2D1780; border-color:#2D1780;' data-toggle='tooltip' title='Ganti Password'><i class='fa fa-key'></i></a>
                            ";
                    }
                    return "<div class='text-center'>
						<div class='btn-group btn-group-xs'>$tombolaksi
						
                        </div>
					</div>";
                }
            ),
        );
        $joinquery = "FROM peserta AS p JOIN jalur_pendaftaran AS jl ON (jl.jalur_pendaftaran_id=p.jalur_pendaftaran) ";
        $extraWhere = "p.tahun_ajaran='" . $settings[30]['value'] . "'  AND p.block = 'N' AND p.status_seleksi != '' AND p.bayar_daftarulang='N'";
        echo json_encode(SSP::simple($_POST, $this->poconnect, $table, $primarykey, $columns, $joinquery, $extraWhere));
    }

    /**
     * Fungsi ini digunakan untuk mengganti mengaktifkan akun.
     *
     * This function use for change account activation.
     *
     */
    public function aktifdata()
    {
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'update')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {

            $datapeserta = array(
                'tgl_konfirmasi_daftar_ulang' => date('Y-m-d'),
                'bayar_daftarulang' => 'Y',
                'user_konfirmasi_daftar_ulang' => $_SESSION['iduser']
            );
            $querypeserta = $this->podb->update('peserta')
                ->set($datapeserta)
                ->where('id_peserta', $this->postring->valid($_POST['id'], 'sql'));
            $querypeserta->execute();
            $this->poflash->success('Konfirmasi bayar daftar ulang telah berhasil', 'admin.php?mod=dpl');
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
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'update')) {
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
                $this->poflash->error($GLOBALS['_']['dpl_message_5'], 'admin.php?mod=dpl&act=edit&id=' . $this->postring->valid($_POST['id'], 'xss'));
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

                $this->poflash->success($GLOBALS['_']['dpl_message_2'], 'admin.php?mod=dpl');
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
            <?= $this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=dpl&act=edit&id=' . $current_user['id_session'], 'enctype' => true, 'autocomplete' => 'off')); ?>
            <?= $this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_user['id_session'])); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="username" class="col-md-3 label-inline">Kode Registrasi <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <input type="text" name="username" id="username" class="form-control "
                                    value="<?= $current_user['kode_registrasi']; ?>" disabled="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="nama_lengkap" class="col-md-3 label-inline">Nama Peserta <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control "
                                    value="<?= $current_user['nama_lengkap_peserta']; ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="gelombang" class="col-md-3 label-inline">Gelombang Pendaftaran <span
                                    class="text-danger">*</span></label>
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
                            <label for="jenjang" class="col-md-3 label-inline">Jenjang Pendidikan Tujuan <span
                                    class="text-danger">*</span></label>
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
                            <label for="proditujuan" class="col-md-3 label-inline">Prodi Tujuan <span
                                    class="text-danger">*</span></label>
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
                                <label for="kotasekolah" class="col-md-3 label-inline">Kota/Kab SMTA<span
                                        class="text-danger">*</span></label>
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
                                <label for="sekolahasal" class="col-md-3 label-inline">Nama SMTA<span
                                        class="text-danger">*</span></label>
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
                                <label for="universitas" class="col-md-3 label-inline">Perguruan Tinggi Asal <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <?php
                                            $current_universitas = $this->podb->from('universitas')
                                                ->where('kode_universitas', $current_user['kode_universitas'])
                                                ->limit(1)
                                                ->fetch();
                                            ?>
                                    <input type="text" name="universitas" id="universitas" class="form-control "
                                        value="<?= strtoupper($current_universitas['nama_universitas']); ?>">
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
                            <label for="jalur" class="col-md-3 label-inline">Jalur Pendaftaran <span
                                    class="text-danger">*</span></label>
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
                            <label for="email" class="col-md-3 label-inline">Email Peserta <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="email" id="email" class="form-control "
                                    value="<?= strtolower($current_user['email_peserta']); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="no_telp" class="col-md-3 label-inline">No. Ponsel Peserta <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="no_telp" id="no_telp" class="form-control"
                                    value="<?= $current_user['telp_peserta']; ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="no_telp" class="col-md-3 label-inline">No. Whatsapp <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="no_wa" id="no_wa" class="form-control"
                                    value="<?= $current_user['no_wa_peserta']; ?>" required>
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
     * Fungsi ini digunakan untuk hasil tpa.
     *
     * This function use for tpa.
     *
     */
    public function gantipassword()
    {
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'update')) {
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

            $this->poflash->success('Berhasil! Ganti Password', 'admin.php?mod=dpl');
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
            <form role="form" method="post" id="passwordForm" action="route.php?mod=dpl&act=gantipassword"
                autocomplete="off">
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
                                    <input type="password" class="form-control" name="renewpassword"
                                        id="renewpassword" />
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
     * Fungsi ini digunakan untuk hasil nilia.
     *
     * This function use for tpa.
     *
     */
    public function nilairaport()
    {
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'update')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $datapeserta = array(
                'status_seleksi' => $_POST['statusseleksi'],
                'prodi_lulus' => $_POST['prodilulus'],
                'tgl_input_seleksi' => date('Y-m-d H:i:s')
            );
            $querypeserta = $this->podb->update('raport')
                ->set($datapeserta)
                ->where('id_peserta', $this->postring->valid($_POST['id'], 'xss'))
                ->where('tahun_ajaran', $this->posetting[30]['value']);
            $querypeserta->execute();

            $this->poflash->success('Berhasil! Mengubah data Nilai Raport', 'admin.php?mod=dpl');
        }
        $id = $this->postring->valid($_GET['id'], 'xss');
        $current_peserta = $this->podb->from('peserta')
            ->where('id_session', $id)
            ->where('tahun_ajaran', $this->posetting[30]['value'])
            ->limit(1)
            ->fetch();

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
        $settings = $this->podb->from('setting')->fetchAll();
        if (empty($current_peserta)) {
            echo $this->pohtml->error();
            exit;
        }


    ?>
<div class="block-content">
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->headTitle('Nilai Raport'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form role="form" method="post" action="route.php?mod=dpl&act=raport" autocomplete="off">
                <?= $this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_peserta['id_peserta'])); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="kode" class="col-md-3 label-inline">No. Peserta </label>
                                <div class="col-md-3">
                                    <input type="text" name="kode" value="<?= $current_peserta['no_peserta']; ?>"
                                        class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-md-3 label-inline">Nama Lengkap </label>
                                <div class="col-md-9">
                                    <input type="text" value="<?= ucwords($current_peserta['nama_lengkap_peserta']); ?>"
                                        class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="jalur" class="col-md-3 label-inline">Jalur Pendaftaran </label>
                                <div class="col-md-2">
                                    <input type="text"
                                        value="<?= strtoupper($current_jalur['jalur_pendaftaran_nama']); ?>"
                                        class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="jalur" class="col-md-3 label-inline">Nilai Matematika <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-2">
                                    <input type="number" value="<?= $current_raport['raport_matematika']; ?>"
                                        name="matematika" class="form-control" required="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="jalur" class="col-md-3 label-inline">Nilai Bahasa Indonesia <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-2">
                                    <input type="number" value="<?= $current_raport['raport_indonesia']; ?>"
                                        name="indonesia" class="form-control" required="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="jalur" class="col-md-3 label-inline">Nilai Bahasa Inggris <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-2">
                                    <input type="number" value="<?= $current_raport['raport_inggris']; ?>"
                                        name="inggris" class="form-control" required="" />
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
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman edit pengguna.
     *
     * This function is used to display and process edit user page.
     *
     */
    public function nilai()
    {
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'update')) {
            echo $this->pohtml->error();
            exit;
        }
        $id = $this->postring->valid($_GET['id'], 'xss');
        $current_user = $this->podb->from('peserta')
            ->where('id_session', $id)
            ->limit(1)
            ->fetch();
        $current_tpa = $this->podb->from('tpa_mengerjakan')
            ->where('id_peserta', $current_user['id_peserta'])
            ->limit(1)
            ->fetch();
        $current_wawancara = $this->podb->from('wawancara')
            ->where('id_peserta', $current_user['id_peserta'])
            ->limit(1)
            ->fetch();

        if (!empty($_POST)) {
            $this->poval->validation_rules(array(
                'skor' => 'required'
            ));
            $this->poval->filter_rules(array(
                'skor' => 'trim'
            ));
            $validated_data = $this->poval->run(array_merge($_POST));
            if ($validated_data === false) {
                $this->poflash->error($GLOBALS['_']['dpl_message_5'], 'admin.php?mod=dpl&act=edit&id=' . $this->postring->valid($_POST['id'], 'xss'));
            } else {


                $cek_data  = $this->podb->from('skor_utbk')
                    ->where('id_peserta', $current_user['id_peserta'])
                    ->count();
                if ($cek_data > 0) {
                    $data = array(
                        'skor_utbk' => $_POST['skor'],
                        'skor_utbk_tanggal' => date('Y-m-d'),
                        'tahun_ajaran' => $this->posetting['30']['value'],
                        'id_user' => $_SESSION['iduser']
                    );
                    $query = $this->podb->update('skor_utbk')
                        ->set($data)
                        ->where('id_peserta', $current_user['id_peserta']);
                    $query->execute();
                } else {
                    $data = array(
                        'id_peserta' => $current_user['id_peserta'],
                        'skor_utbk' => $_POST['skor'],
                        'skor_utbk_tanggal' => date('Y-m-d'),
                        'tahun_ajaran' => $this->posetting['30']['value'],
                        'id_user' => $_SESSION['iduser']
                    );
                    $query = $this->podb->insertInto('skor_utbk')->values($data);
                    $query->execute();
                }


                $this->poflash->success($GLOBALS['_']['dpl_message_2'], 'admin.php?mod=dpl');
            }
        }
        $current_skor = $this->podb->from('skor_utbk')
            ->where('id_peserta', $current_user['id_peserta'])
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
            <?= $this->pohtml->headTitle('Nilai Tes Peserta'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=dpl&act=nilai&id=' . $current_user['id_session'], 'enctype' => true, 'autocomplete' => 'off')); ?>
            <?= $this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_user['id_session'])); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="username" class="col-md-3 label-inline">No. Peserta</label>
                            <div class="col-md-2">
                                <input type="text" name="username" id="username" class="form-control "
                                    value="<?= $current_user['kode_registrasi']; ?>" disabled="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="nama_lengkap" class="col-md-3 label-inline">Nama Peserta</label>
                            <div class="col-md-9">
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control "
                                    value="<?= $current_user['nama_lengkap_peserta']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    if ($current_user['jalur_pendaftaran'] == '4') {
                    ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="skor" class="col-md-3 label-inline">Skor UTBK</label>
                            <div class="col-md-2">
                                <input type="text" name="skor" id="skor" class="form-control "
                                    value="<?= $current_skor['skor_utbk']; ?>" maxlength="3" required="">
                                <span class="help-block"><small>Penulisan skor, dari angka 0 s/d 100.</small></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } elseif ($current_user['jalur_pendaftaran'] == '3') { ?>


            <?php } else { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="tpa" class="col-md-3 label-inline">Skor TPA</label>
                            <div class="col-md-2">
                                <input type="text" name="tpa" id="tpa" class="form-control "
                                    value="<?= $current_tpa['nilai']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="wawancara" class="col-md-3 label-inline">Skor Wawancara </label>
                            <div class="col-md-2">
                                <input type="text" name="wawancara" id="wawancara" class="form-control "
                                    value="<?= $current_wawancara['nilai_wawancara']; ?>" disabled>
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
     * Fungsi ini digunakan untuk hasil seleksi.
     *
     * This function use for test.
     *
     */
    public function dpl()
    {
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'update')) {
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

            $this->poflash->success('Berhasil! Hasil seleksi masuk telah ditentukan', 'admin.php?mod=dpl');
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
            <?= $this->pohtml->headTitle('Penentuan seleksi'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form role="form" method="post" action="route.php?mod=dpl&act=dpl" autocomplete="off">
                <?= $this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_peserta['id_peserta'])); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="kode" class="col-md-3 label-inline">No. Peserta </label>
                                <div class="col-md-4">
                                    <input type="text" name="kode" value="<?= $current_peserta['no_peserta']; ?>"
                                        class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-md-3 label-inline">Nama Lengkap </label>
                                <div class="col-md-9">
                                    <input type="text" value="<?= ucwords($current_peserta['nama_lengkap_peserta']); ?>"
                                        class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="jalur" class="col-md-3 label-inline">Jalur Pendaftaran </label>
                                <div class="col-md-5">
                                    <input type="text"
                                        value="<?= strtoupper($current_jalur['jalur_pendaftaran_nama']); ?>"
                                        class="form-control" readonly />
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
                                    <input type="hidden" name="prodilulus"
                                        value="<?= $current_peserta['pilihan_pertama']; ?>" />
                                    <input type="text" value="<?= $pil_satu['prodiNamaResmi']; ?>" class="form-control"
                                        readonly />
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
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus peserta.
     *
     * This function is used to display and process delete peserta page.
     *
     */
    public function delete()
    {
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'delete')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $query = $this->podb->deleteFrom('dpl')->where('id_session', $this->postring->valid($_POST['id'], 'xss'));
            $query->execute();
            $this->poflash->success('Peserta has been successfully deleted', 'admin.php?mod=dpl');
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
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'delete')) {
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
                $this->poflash->success('Peserta has been successfully deleted', 'admin.php?mod=dpl');
            } else {
                $this->poflash->error('Error deleted peserta data', 'admin.php?mod=dpl');
            }
        }
    }

    /**
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman membaca smta.
     *
     * This function is used to display and process read smta page.
     *
     */
    public function smta()
    {
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'read')) {
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
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'read')) {
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
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'read')) {
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
     * Fungsi ini digunakan untuk mengganti verifikasi berkas.
     *
     * This function use for change verification documents.
     *
     */
    public function verifikasi()
    {
        if (!$this->auth($_SESSION['leveluser'], 'dpl', 'update')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $getdata = $this->podb->from('peserta')
                ->where('id_session', $this->postring->valid($_POST['id'], 'xss'))
                ->limit(1)
                ->fetch();
            $thnmasuk = substr($this->posetting[30]['value'], 2, 2);
            //mengambil nilai notes terakhir
            //select nim from peserta WHERE pilihan_pertama='21' ORDER BY nim DESC
            $getnim  = $this->podb->from('peserta')->where('prodi_lulus', $getdata['prodi_lulus'])->where('status_seleksi', 'Lulus')->where('tahun_ajaran', $this->posetting[30]['value'])->orderBy('nim DESC')->limit(1)->fetch();
            $getprodi = $this->podb->from('program_studi')
                ->select('fakultas.fakultas_kode, jenjang_studi.jenjang_studi_kode, jenjang_studi.jenjang_studi_kode,program_studi.prodiUrutan')
                ->leftJoin('jenjang_studi ON jenjang_studi.jenjang_studi_id = program_studi.jenjang_studi_id')
                ->leftJoin('fakultas ON fakultas.fakultas_id = program_studi.fakultas_id')
                ->where('program_studi.prodiKode', $getdata['prodi_lulus'])->limit(1)->fetch();
            if ($getnim['nim']) {
                // membuat variabel baru untuk mengambil kode  mulai dari 1
                $nilaikode = substr($getnim['nim'], 0);
                // menjadikan $nilaikode ( int )
                $kodeurutan = (int) $nilaikode;
                // setiap $kodeurutan di tambah 1
                $kodeurutan = $kodeurutan + 1;
                // hasil untuk menambahkan kode
                // angka 3 untuk menambahkan tiga angka setelah B dan angka 0 angka yang berada di tengah
                // atau angka sebelum $kodeurutan
                //1810121001
                //tahun.kode fakultas.urutan prodi.jenjang studi.kelas reguler
                //$stambuk = $thnmasuk.$getprodi['fakultas_kode'].$getprodi['prodiUrutan'].$getprodi['jenjang_studi_kode'].'1'.$urut;
                $stambuk = str_pad($kodeurutan, 3, "0", STR_PAD_LEFT);
            } else {
                $stambuk = $thnmasuk . $getprodi['fakultas_kode'] . $getprodi['prodiUrutan'] . $getprodi['jenjang_studi_kode'] . '1' . "001";
            }
            $datapeserta = array(
                'verifikasi_berkas' => 'Y',
                'tgl_verifikasi_berkas' => date('Y-m-d'),
                'nim' => $stambuk,
                'user_konfirmasi_verifkasi_berkas' => $_SESSION['iduser']
            );

            $querypeserta = $this->podb->update('peserta')
                ->set($datapeserta)
                ->where('id_peserta', $getdata['id_peserta']);
            $querypeserta->execute();

            //INPUT KE DAFTAR ULANG
            $current_daftar_ulang = $this->podb->from('peserta_daftar_ulang')->where('id_peserta', $getdata['id_peserta'])->limit(1)->fetch();

            if (empty($current_daftar_ulang)) {
                $daftarulang = array(
                    'id_peserta' => $getdata['id_peserta'],
                    'tahun_ajaran' => $this->posetting[30]['value']
                );
                $query_daftarulang = $this->podb->insertInto('peserta_daftar_ulang')->values($daftarulang);
                $query_daftarulang->execute();
            }
            //INPUT KE BERKAS DAFTAR ULANG    
            $current_berkas_ulang = $this->podb->from('berkas')->where('id_peserta', $getdata['id_peserta'])->limit(1)->fetch();
            if (empty($current_berkas_ulang)) {
                $berkasulang = array(
                    'id_peserta' => $getdata['id_peserta'],
                    'tahun_ajaran' => $this->posetting[30]['value']
                );
                $query_berkasrulang = $this->podb->insertInto('berkas')->values($berkasulang);
                $query_berkasrulang->execute();
            }


            $this->poflash->success('Data camaba telah berhasil diverifikasi', 'admin.php?mod=maba');
        }
    }
}