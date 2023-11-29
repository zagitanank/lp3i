<?php
/*
 *
 * - Zagitanank Admin File
 *
 * - File : admin_jadwal.php
 * - Version : 1.1
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses admin pada halaman.
 * This is a php file for handling admin process for jadwal.
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

class jadwal extends PoCore
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
	 * Fungsi ini digunakan untuk menampilkan halaman index halaman.
	 *
	 * This function use for index jadwal.
	 *
	 */
	public function index()
	{
		if (!$this->auth($_SESSION['leveluser'], 'jadwal', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
?>
<div class="block-content">
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->headTitle(
						'Jadwal MBKM',
						'<div class="btn-title pull-right">
					   <a href="admin.php?mod=jadwal&act=addnew" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> ' . $GLOBALS['_']['addnew'] . '</a>
					</div>'
					); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=jadwal&act=multidelete', 'autocomplete' => 'off')); ?>
            <?= $this->pohtml->inputHidden(array('name' => 'totaldata', 'value' => '0', 'options' => 'id="totaldata"')); ?>
            <?php
					$columns = array(
						array('title' => 'Id', 'options' => 'style="width:30px;"'),
						array('title' => 'Gel', 'options' => 'style="width:30px;"'),
						array('title' => 'Periode Akademik', 'options' => 'class="no-sort"'),
						array('title' => 'Tgl. Daftar', 'options' => 'class="no-sort"'),
						array('title' => 'Tahun', 'options' => 'style="width:30px;"'),
						array('title' => 'Aktif', 'options' => 'class="no-sort"'),
						array('title' => 'Tindakan', 'options' => 'class="no-sort" style="width:50px;"')
					);
					?>
            <?= $this->pohtml->createTable(array('id' => 'table-jadwal', 'class' => 'table table-striped table-bordered'), $columns, $tfoot = true); ?>
            <?= $this->pohtml->formEnd(); ?>
        </div>
    </div>
</div>
<?= $this->pohtml->dialogDelete('jadwal'); ?>
<?= $this->pohtml->dialogAktifasi('jadwal'); ?>
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
		if (!$this->auth($_SESSION['leveluser'], 'jadwal', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
		$table = 'mbkm_jadwal';
		$primarykey = 'mbkm_jadwal_id';
		$columns = array(
			array('db' => 'mbkm_jadwal_periode', 'dt' => null, 'field' => 'mbkm_jadwal_periode'),
			array('db' => 'mbkm_jadwal_aktif', 'dt' => null, 'field' => 'mbkm_jadwal_aktif'),
			array('db' => 'mbkm_jadwal_awal', 'dt' => null, 'field' => 'mbkm_jadwal_awal'),
			array('db' => 'mbkm_jadwal_akhir', 'dt' => null, 'field' => 'mbkm_jadwal_akhir'),
			array('db' => 'mbkm_jadwal_tes_tulis', 'dt' => null, 'field' => 'mbkm_jadwal_tes_tulis'),
			array('db' => 'mbkm_jadwal_tes_wawancara', 'dt' => null, 'field' => 'mbkm_jadwal_tes_wawancara'),
			array('db' => 'mbkm_jadwal_pengumuman', 'dt' => null, 'field' => 'mbkm_jadwal_pengumuman'),
			array('db' => 'mbkm_jadwal_pembekalan', 'dt' => null, 'field' => 'mbkm_jadwal_pembekalan'),
			array(
				'db' =>  $primarykey, 'dt' => '0', 'field' => $primarykey,
				'formatter' => function ($d, $row, $i) {
					return "<div class='text-center'>\n
						<input type='checkbox' id='titleCheckdel' />\n
						<input type='hidden' class='deldata' name='item[" . $i . "][deldata]' value='" . $d . "' disabled />\n
					</div>\n";
				}
			),
			array('db' => $primarykey, 'dt' => '1', 'field' => $primarykey),
			array('db' => 'mbkm_jadwal_gelombang', 'dt' => '2', 'field' => 'mbkm_jadwal_gelombang'),
			array(
				'db' => $primarykey, 'dt' => '3', 'field' => $primarykey,
				'formatter' => function ($d, $row, $i) {
					return $this->Convert_periode_totext($row['mbkm_jadwal_periode']);
				}
			),
			array(
				'db' => $primarykey, 'dt' => '4', 'field' => $primarykey,
				'formatter' => function ($d, $row, $i) {
					return $this->tanggal_indo($row['mbkm_jadwal_awal']) . ' s/d ' . $this->tanggal_indo($row['mbkm_jadwal_akhir']);
				}
			),
			array('db' => 'mbkm_jadwal_tahun', 'dt' => '5', 'field' => 'mbkm_jadwal_tahun'),
			array(
				'db' => $primarykey, 'dt' => '6', 'field' => $primarykey,
				'formatter' => function ($d, $row, $i) {
					if ($row['mbkm_jadwal_aktif'] == 'Y') {
						$blockdata = "<a href='#' class='btn btn-xs btn-success'  data-toggle='tooltip' title='Aktif' >Aktif</a>";
					} else {
						$blockdata = "<a class='btn btn-xs btn-primary aktifdata'  data-toggle='tooltip' title='Tertutup' id='" . $d . "'>Tertutup</a>";
					}
					return "<div class='text-center'>" . $blockdata . "</div>\n";
				}
			),
			array(
				'db' => $primarykey, 'dt' => '7', 'field' => $primarykey,
				'formatter' => function ($d, $row, $i) {
					return "<div class='text-center'>\n
						<div class='btn-group btn-group-xs'>\n
							<a href='admin.php?mod=jadwal&act=edit&id=" . $d . "' class='btn btn-xs btn-default' id='" . $d . "' data-toggle='tooltip' title='{$GLOBALS['_']['action_1']}'><i class='fa fa-pencil'></i></a>
							<a class='btn btn-xs btn-danger alertdel' id='" . $d . "' data-toggle='tooltip' title='{$GLOBALS['_']['action_2']}'><i class='fa fa-times'></i></a>
						</div>\n
					</div>\n";
				}
			)

		);
		$joinquery = "FROM mbkm_jadwal";
		$extrawhere = "";
		echo json_encode(SSP::simple($_POST, $this->poconnect, $table, $primarykey, $columns, $joinquery, $extrawhere));
	}

	/**
	 * Fungsi ini digunakan untuk mengganti mengaktifkan akun.
	 *
	 * This function use for change account activation.
	 *
	 */
	public function aktifdata()
	{
		if (!$this->auth($_SESSION['leveluser'], 'jadwal', 'update')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {

			$dataupdate = array(
				'mbkm_jadwal_aktif' => 'N'
			);
			$queryupdate = $this->podb->update('mbkm_jadwal')
				->set($dataupdate);
			$queryupdate->execute();

			$datapeserta = array(
				'mbkm_jadwal_aktif' => 'Y'
			);
			$querypeserta = $this->podb->update('mbkm_jadwal')
				->set($datapeserta)
				->where('mbkm_jadwal_id', $this->postring->valid($_POST['id'], 'sql'));
			$querypeserta->execute();


			if ($querypeserta) {
				echo $this->poflash->success('Jadwal telah berhasil diaktifkan', 'admin.php?mod=peserta');
			} else {
				echo $this->poflash->warning('Gagal diaktifkan, terjadi kesalahan ' . $querypeserta->errorInfo(), 'admin.php?mod=registrasi');
			}
		}
	}


	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman add halaman.
	 *
	 * This function is used to display and process add jadwal.
	 *
	 */
	public function addnew()
	{
		if (!$this->auth($_SESSION['leveluser'], 'jadwal', 'create')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$tanggalbuat = date("Y-m-d H:i:s");
			$jadwal = array(
				'mbkm_jadwal_gelombang' => $this->postring->valid($_POST['gelombang'], 'sql'),
				'mbkm_jadwal_awal' => $_POST['tahunawaldaftar'] . '-' . $_POST['bulanawaldaftar'] . '-' . $_POST['hariawaldaftar'],
				'mbkm_jadwal_akhir' => $_POST['tahunakhirdaftar'] . '-' . $_POST['bulanakhirdaftar'] . '-' . $_POST['hariakhirdaftar'],
				'mbkm_jadwal_tahun' => $this->postring->valid($_POST['tahun'], 'xss'),
				'mbkm_jadwal_periode' => $this->postring->valid($_POST['periode'], 'xss'),
				'user_id_pembuat' => $_SESSION['iduser'],
				'user_id_pembuat_date' => $tanggalbuat
			);
			$query_jadwal = $this->podb->insertInto('mbkm_jadwal')->values($jadwal);
			$query_jadwal->execute();
			$this->poflash->success('Jadwal MBKM berhasil ditambahkan', 'admin.php?mod=jadwal');
		}
	?>
<div class="block-content">
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->headTitle('Tambah Jadwal'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=jadwal&act=addnew', 'autocomplete' => 'off')); ?>
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="gelombang" class="col-md-3 label-inline">Gelombang <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select class="form-control " id="gelombang" name="gelombang" required>
                                    <option value="" hidden="">Pilih</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Tahun <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="number" name="tahun" id="tahun"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    maxlength="4" class="form-control" required>
                                <span class="help-block"><small>Contoh : 2022<br>Harus Angka</small></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Periode Akademik <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="number" name="periode"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    id="periode" maxlength="5" class="form-control" required>
                                <span class="help-block"><small>Contoh : 20221<br>Harus Angka
                                    </small></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Awal Pendaftaran <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select name="hariawaldaftar" class="form-control" required>
                                    <?php
											echo "<option value='' hidden=''>Pilih</option>";
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
                                <select name="bulanawaldaftar" class="form-control" required>
                                    <?php
											echo "<option value='' hidden=''>Pilih</option>";
											for ($bulan = 1; $bulan <= 12; $bulan++) {
												if ($bulan < 10) {
													$bulan = "0" . $bulan;
												}
												echo "<option value='$bulan'>$bulan</option>";
											}
											?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="tahunawaldaftar" class="form-control" required>
                                    <?php
											echo "<option value='' hidden=''>Pilih</option>";
											$tahun = date('Y') + 1;
											$tahun2 = date('Y') - 2;
											for ($tahun; $tahun2 < $tahun; $tahun--) {
												echo "<option value='$tahun'>$tahun</option>";
											}
											?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Batas Pendaftaran <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select name="hariakhirdaftar" class="form-control" required>
                                    <?php
											echo "<option value='' hidden=''>Pilih</option>";
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
                                <select name="bulanakhirdaftar" class="form-control" required>
                                    <?php
											echo "<option value='' hidden=''>Pilih</option>";
											for ($bulan = 1; $bulan <= 12; $bulan++) {
												if ($bulan < 10) {
													$bulan = "0" . $bulan;
												}
												echo "<option value='$bulan'>$bulan</option>";
											}
											?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="tahunakhirdaftar" class="form-control" required>
                                    <?php
											echo "<option value='' hidden=''>Pilih</option>";
											$tahun = date('Y') + 1;
											$tahun2 = date('Y') - 2;
											for ($tahun; $tahun2 < $tahun; $tahun--) {
												echo "<option value='$tahun'>$tahun</option>";
											}
											?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


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
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman edit halaman.
	 *
	 * This function is used to display and process edit jadwal.
	 *
	 */
	public function edit()
	{
		if (!$this->auth($_SESSION['leveluser'], 'jadwal', 'update')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$tanggalbuat = date("Y-m-d H:i:s");
			$jadwal = array(
				'mbkm_jadwal_gelombang' => $this->postring->valid($_POST['gelombang'], 'sql'),
				'mbkm_jadwal_awal' => $_POST['tahunawaldaftar'] . '-' . $_POST['bulanawaldaftar'] . '-' . $_POST['hariawaldaftar'],
				'mbkm_jadwal_akhir' => $_POST['tahunakhirdaftar'] . '-' . $_POST['bulanakhirdaftar'] . '-' . $_POST['hariakhirdaftar'],
				'mbkm_jadwal_tahun' => $this->postring->valid($_POST['tahun'], 'xss'),
				'mbkm_jadwal_periode' => $this->postring->valid($_POST['periode'], 'xss'),
				'mbkm_jadwal_aktif' => $_POST['active'],
				'user_id_update' => $_SESSION['iduser'],
				'user_id_update_date' => $tanggalbuat
			);
			$query_jadwal = $this->podb->update('mbkm_jadwal')
				->set($jadwal)
				->where('mbkm_jadwal_id', $this->postring->valid($_POST['id'], 'sql'));
			$query_jadwal->execute();
			$this->poflash->success('Jadwal berhasil diupdate', 'admin.php?mod=jadwal');
		}
		$id = $this->postring->valid($_GET['id'], 'sql');
		$current_jadwal = $this->podb->from('mbkm_jadwal')
			->where('mbkm_jadwal_id', $id)
			->limit(1)
			->fetch();
		if (empty($current_jadwal)) {
			echo $this->pohtml->error();
			exit;
		}
	?>
<div class="block-content">
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->headTitle('Edit Jadwal'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=jadwal&act=edit&id=' . $current_jadwal['mbkm_jadwal_id'], 'autocomplete' => 'off')); ?>
            <div class="row">
                <?= $this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_jadwal['mbkm_jadwal_id'])); ?>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="gelombang" class="col-md-3 label-inline">Gelombang <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select class="form-control " id="gelombang" name="gelombang" required>
                                    <option value="<?= $current_jadwal['mbkm_jadwal_gelombang']; ?>" hidden="">
                                        <?= $current_jadwal['mbkm_jadwal_gelombang']; ?></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Tahun <span class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="number" name="tahun" id="tahun"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    maxlength="4" class="form-control"
                                    value="<?= $current_jadwal['mbkm_jadwal_tahun']; ?>" required>
                                <span class="help-block"><small>Contoh : 2022<br>Harus Angka</small></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Periode Akademik <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="number" name="periode"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    value="<?= $current_jadwal['mbkm_jadwal_periode']; ?>" id="periode" maxlength="5"
                                    class="form-control" required>
                                <span class="help-block"><small>Contoh : 20221<br>Harus Angka
                                    </small></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <?php
									if (empty($current_jadwal['mbkm_jadwal_awal'])) {
										$optionhari_awal  = "<option value='' hidden=''>Pilih</option>";
										$optionbulan_awal = "<option value='' hidden=''>Pilih</option>";
										$optiontahun_awal = "<option value='' hidden=''>Pilih</option>";
									} else {
										$pisahtanggal_awal = explode('-', $current_jadwal['mbkm_jadwal_awal']);
										$optionhari_awal  = "<option value='$pisahtanggal_awal[2]' hidden=''>$pisahtanggal_awal[2]</option>";
										$optionbulan_awal = "<option value='$pisahtanggal_awal[1]' hidden=''>$pisahtanggal_awal[1]</option>";
										$optiontahun_awal = "<option value='$pisahtanggal_awal[0]' hidden=''>$pisahtanggal_awal[0]</option>";
									}
									?>
                            <label class="col-md-3 label-inline">Awal Pendaftaran <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select name="hariawaldaftar" class="form-control" required>
                                    <?php
											echo "<option value='$optionhari_awal' hidden=''>$optionhari_awal</option>";
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
                                <select name="bulanawaldaftar" class="form-control" required>
                                    <?php
											echo "<option value='$optionbulan_awal' hidden=''>$optionbulan_awal</option>";
											for ($bulan = 1; $bulan <= 12; $bulan++) {
												if ($bulan < 10) {
													$bulan = "0" . $bulan;
												}
												echo "<option value='$bulan'>$bulan</option>";
											}
											?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="tahunawaldaftar" class="form-control" required>
                                    <?php
											echo "<option value='$optiontahun_awal' hidden=''>$optiontahun_awal</option>";
											$tahun = date('Y') + 1;
											$tahun2 = date('Y') - 2;
											for ($tahun; $tahun2 < $tahun; $tahun--) {
												echo "<option value='$tahun'>$tahun</option>";
											}
											?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <?php
									if (empty($current_jadwal['mbkm_jadwal_akhir'])) {
										$optionhariakhir  = "<option value='' hidden=''>Pilih</option>";
										$optionbulanakhir = "<option value='' hidden=''>Pilih</option>";
										$optiontahunakhir = "<option value='' hidden=''>Pilih</option>";
									} else {
										$pisahtanggalakhir = explode('-', $current_jadwal['mbkm_jadwal_akhir']);
										$optionhariakhir  = "<option value='$pisahtanggalakhir[2]' hidden=''>$pisahtanggalakhir[2]</option>";
										$optionbulanakhir = "<option value='$pisahtanggalakhir[1]' hidden=''>$pisahtanggalakhir[1]</option>";
										$optiontahunakhir = "<option value='$pisahtanggalakhir[0]' hidden=''>$pisahtanggalakhir[0]</option>";
									}
									?>
                            <label class="col-md-3 label-inline">Batas Pendaftaran <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select name="hariakhirdaftar" class="form-control" required>
                                    <?php
											echo "<option value='$optionhariakhir' hidden=''>$optionhariakhir</option>";
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
                                <select name="bulanakhirdaftar" class="form-control" required>
                                    <?php
											echo "<option value='$optionbulanakhir' hidden=''>$optionbulanakhir</option>";
											for ($bulan = 1; $bulan <= 12; $bulan++) {
												if ($bulan < 10) {
													$bulan = "0" . $bulan;
												}
												echo "<option value='$bulan'>$bulan</option>";
											}
											?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="tahunakhirdaftar" class="form-control" required>
                                    <?php
											echo "<option value='$optiontahunakhir' hidden=''>$optiontahunakhir</option>";
											$tahun = date('Y') + 1;
											$tahun2 = date('Y') - 2;
											for ($tahun; $tahun2 < $tahun; $tahun--) {
												echo "<option value='$tahun'>$tahun</option>";
											}
											?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <?php
							if ($current_jadwal['mbkm_jadwal_aktif'] == 'N') {
								$radioitem = array(
									array('name' => 'active', 'id' => 'active', 'value' => 'Y', 'options' => '', 'title' => 'YA'),
									array('name' => 'active', 'id' => 'active', 'value' => 'N', 'options' => 'checked', 'title' => 'TIDAK')
								);
								echo $this->pohtml->inputRadio(array('label' =>
								'Jadwal Aktif', 'mandatory' => true), $radioitem, $inline = true);
							} else {
								$radioitem = array(
									array('name' => 'active', 'id' => 'active', 'value' => 'Y', 'options' => 'checked', 'title' => 'YA'),
									array('name' => 'active', 'id' => 'active', 'value' => 'N', 'options' => '', 'title' => 'TIDAK')
								);
								echo $this->pohtml->inputRadio(array('label' => "Jadwal Aktif", 'mandatory' => true), $radioitem, $inline = true);
							}
							?>
                </div>
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
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus halaman.
	 *
	 * This function is used to display and process delete jadwal.
	 *
	 */
	public function delete()
	{
		if (!$this->auth($_SESSION['leveluser'], 'jadwal', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$query_pag = $this->podb->deleteFrom('mbkm_jadwal')->where('mbkm_jadwal_id', $this->postring->valid($_POST['id'], 'sql'));
			$query_pag->execute();
			$this->poflash->success('Data jadwal berhasil terhapus', 'admin.php?mod=jadwal');
		}
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus multi halaman.
	 *
	 * This function is used to display and process multi delete jadwal.
	 *
	 */
	public function multidelete()
	{
		if (!$this->auth($_SESSION['leveluser'], 'jadwal', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$totaldata = $this->postring->valid($_POST['totaldata'], 'xss');
			if ($totaldata != "0") {
				$items = $_POST['item'];
				foreach ($items as $item) {
					$query_pag = $this->podb->deleteFrom('mbkm_jadwal')->where('mbkm_jadwal_id', $this->postring->valid($item['deldata'], 'sql'));
					$query_pag->execute();
				}
				$this->poflash->success('Semua data jadwal telah terhapus', 'admin.php?mod=jadwal');
			} else {
				$this->poflash->error('Semua data jadwal gagal terhapus', 'admin.php?mod=jadwal');
			}
		}
	}

}