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
            <?= $this->pohtml->headTitle($GLOBALS['_']['component_name'], '<div class="btn-title pull-right">
					   <a href="admin.php?mod=peserta&act=addnew" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Peserta</a>
					</div>'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=peserta&act=multidelete', 'autocomplete' => 'off')); ?>
            <?= $this->pohtml->inputHidden(array('name' => 'totaldata', 'value' => '0', 'options' => 'id="totaldata"')); ?>
            <?php
                    $columns = array(
                        array('title' => 'Id', 'options' => 'style="width:30px;"'),
                        array('title' => 'NIM', 'options' => 'style="width:30px;"'),
                        array('title' => 'Nama Lengkap', 'options' => ''),
                        array('title' => 'Prodi', 'options' => ''),
                        array('title' => 'TA', 'options' => 'style="width:20px;"'),
                        array('title' => 'BKP', 'options' => ''),
                        array('title' => 'Tindakan', 'options' => 'class="no-sort" style="width:100px;"')
                    );
                    ?>
            <?= $this->pohtml->createTable(array('id' => 'table-peserta', 'class' => 'table table-striped table-bordered'), $columns, $tfoot = true); ?>
            <?= $this->pohtml->formEnd(); ?>
        </div>
    </div>
</div>
<?= $this->pohtml->dialogDelete('peserta'); ?>

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
        $table = 'mbkm_peserta';
        $primarykey = 'id';
        $columns = array(
            array('db' => 'kode_prodi', 'dt' => null, 'field' => 'kode_prodi'),
            array('db' => 'mbkm_kategori_id', 'dt' => null, 'field' => 'mbkm_kategori_id'),
            array('db' => 'jenis_mbkm', 'dt' => null, 'field' => 'jenis_mbkm'),
            array(
                'db' => 'id', 'dt' => '0', 'field' => 'id',
                'formatter' => function ($d, $row, $i) {
                    return "<div class='text-center'>
                        <input type='checkbox' id='titleCheckdel' />
                        <input type='hidden' class='deldata' name='item[" . $i . "][deldata]' value='" . $d . "' disabled />
                    </div>";
                }
            ),
            array('db' => $primarykey, 'dt' => '1', 'field' => $primarykey),
            array('db' => 'nim', 'dt' => '2', 'field' => 'nim'),
            array('db' => 'nama', 'dt' => '3', 'field' => 'nama'),
            array(
                'db' => $primarykey, 'dt' => '4', 'field' => $primarykey,
                'formatter' => function ($d, $row, $i) {
                    if($row['kode_prodi'] == 'AB'){
                          $nm_prodi = 'Administrasi Bisnis';
                     }else if($row['kode_prodi'] == 'AK'){
                          $nm_prodi = 'Akuntansi Keuangan Publik';
                     }else if($row['kode_prodi'] == 'AP'){
                          $nm_prodi = 'Adminsitrasi Pemerintahan';
                     }else if($row['kode_prodi'] == 'BD'){
                          $nm_prodi = 'Bisnis Digital';
                     }else if($row['kode_prodi'] == 'MI'){
                          $nm_prodi = 'Manajemen Informatika';
                     }else{
                          $nm_prodi = '-';
                     }
                    return $nm_prodi;
                }
            ),
            array('db' => 'periode', 'dt' => '5', 'field' => 'periode'),
            array(
                'db' => $primarykey, 'dt' => '6', 'field' => $primarykey,
                'formatter' => function ($d, $row, $i) {
                    $kategori = $this->podb->from('mbkm_kategori')->where('mbkm_kategori_id', $row['mbkm_kategori_id'])->fetch();
                    $bkp = $this->podb->from('mbkm_jenis')->where('id', $row['jenis_mbkm'])->fetch();
                    
                    return $bkp['mbkm_jenis_nama'].'<br><small>('.$kategori['mbkm_kategori_nama'].')</small>';
                }
            ),
            array(
                'db' => $primarykey, 'dt' => '7', 'field' => $primarykey,'formatter' => function ($d, $row, $i) {
                    $krsmbkm = $this->podb->from('mbkm_krs')->where('mbkm_krs_nim', $row['nim'])->where('mbkm_krs_periode', $row['periode'])->count();
                    if($krsmbkm == 0){
                        $tombolkrs = " <a href='admin.php?mod=peserta&act=krs&id=" . $row['nim'] ."&periode=".$row['periode']."' class='btn btn-xs btn-warning' data-toggle='tooltip' title='KRS'><i class='fa fa-file-text-o'></i></a>";
                    }else{
                        $tombolkrs = " <a href='admin.php?mod=peserta&act=krsmbkm&id=" . $row['nim'] ."&periode=".$row['periode']."' class='btn btn-xs btn-success' data-toggle='tooltip' title='KRS'><i class='fa fa-file-text-o'></i></a>";
                    }
                    return "<div class='text-center'>
                                <div class='btn-group btn-group-xs'>
                                    $tombolkrs
                                    <a href='admin.php?mod=peserta&act=edit&id=" . $d . "' class='btn btn-xs btn-default' data-toggle='tooltip' title='Detail'><i class='fa fa-pencil'></i></a>
                                    <a class='btn btn-xs btn-danger alertdel' id='".$d."' data-toggle='tooltip' title='{$GLOBALS['_']['action_2']}'><i class='fa fa-times'></i></a>
                                </div>
                            </div>";
                }
            ),
        );
        $joinquery = "FROM mbkm_peserta";
        if($_SESSION['leveluser'] == 3){
            $extraWhere = "kode_prodi='" . $_SESSION['namauser'] . "' AND periode='" . $this->mbkmsetting['mbkm_jadwal_periode'] . "'";
        }else{
            $extraWhere = "periode='" . $this->mbkmsetting['mbkm_jadwal_periode'] . "'";
        }
        
        echo json_encode(SSP::simple($_POST, $this->poconnect, $table, $primarykey, $columns, $joinquery, $extraWhere));
    }


    /**
     * Fungsi ini digunakan untuk menampilkan dan memproses halaman add kategori.
     *
     * This function is used to display and process add category page.
     *
     */
    public function addnew()
	{
		if (!$this->auth($_SESSION['leveluser'], 'peserta', 'create')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$tanggalbuat = date("Y-m-d H:i:s");
			$peserta = array(
				'nim' => $_POST['nim'],
                'nama' => $_POST['nama'],
				'periode' => $_POST['periode'],
                'mbkm_kategori_id' => $_POST['kategori'],
				'jenis_mbkm' => $_POST['bkp'],
				'kode_prodi' => $_POST['kdprodi'],
				'lokasi_kegiatan' => $_POST['lokasi'],
				'user_input' => $_SESSION['iduser'],
				'tgl_input' => $tanggalbuat
			);
			$query_peserta = $this->podb->insertInto('mbkm_peserta')->values($peserta);
			$query_peserta->execute();
			$this->poflash->success('Peserta MBKM berhasil ditambahkan', 'admin.php?mod=peserta');
		}
	?>
<div class="block-content">
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->headTitle('Tambah Peserta MBKM'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=peserta&act=addnew', 'autocomplete' => 'off')); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Periode Akademik <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="number" name="periode" maxlength="5" class="form-control"
                                    value="<?=$this->mbkmsetting['mbkm_jadwal_periode'];?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="row">
                            <label class="col-md-3 label-inline">Nim <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control " id="nim" name="nim"
                                        placeholder="Input Nim Mahasiswa" required>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success" id="btnProses"
                                            onclick="ceknim()">Cek
                                            Nim</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="kdprodi" id='kdprodi'>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Nama Mahasiswa <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="nama" id="nama" class="form-control" required="" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Program Studi <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" name="prodi" id="prodi" class="form-control" required="" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Kategori MBKM <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">

                                <select class="form-control" name="kategori" id="kategori" required>
                                    <option value="" hidden="">Pilih</option>
                                    <?php
                                    $kategori=$this->podb->from('mbkm_kategori')
                                    ->orderBy('mbkm_kategori_id ASC')
                                    ->fetchAll();
                                    foreach ($kategori as $ktg) {
                                    echo '<option value="' . $ktg['mbkm_kategori_id'] . '">' .
                                        $ktg['mbkm_kategori_nama'] . '</option>';
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
                            <label class="col-md-3 label-inline">BKP MBKM <span class="text-danger">*</span></label>
                            <div class="col-md-6">

                                <select class="form-control" name="bkp" id="bkp" required>
                                    <option value="" hidden="">Pilih</option>
                                    <?php
                                    $bkp=$this->podb->from('mbkm_jenis')
                                                    ->where('mbkm_jenis_aktif', 'Y')
                                                    ->orderBy('mbkm_jenis_nama ASC')
                                                    ->fetchAll();
                                    foreach ($bkp as $bk) {
                                    echo '<option value="' . $bk['id'] . '" class="' . $bk['mbkm_kategori'] . '">' .
                                        $bk['mbkm_jenis_nama'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="help-block"><small>Harus memilih kategori MBKM dahulu.</small></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Lokasi Kegiatan <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="lokasi" id="lokasi" class="form-control" required="">
                                <span class="help-block"><small>Contoh: <strong>Desa Makmur</strong> atau <strong>Kantor
                                            Makmur</strong>.</small></span>
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

 public function edit()
	{
		if (!$this->auth($_SESSION['leveluser'], 'peserta', 'update')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			
			$peserta = array(
                'mbkm_kategori_id' => $_POST['kategori'],
				'jenis_mbkm' => $_POST['bkp'],
				'lokasi_kegiatan' => $_POST['lokasi']
			);
			$query_peserta = $this->podb->update('mbkm_peserta')
				->set($peserta)
				->where('id', $this->postring->valid($_POST['id'], 'sql'));
			$query_peserta->execute();
			
			$this->poflash->success('Peserta MBKM berhasil diupdate', 'admin.php?mod=peserta');
		}
		$id = $this->postring->valid($_GET['id'], 'sql');
		$current_peserta = $this->podb->from('mbkm_peserta')
			->where('id', $id)
			->limit(1)
			->fetch();
		if (empty($current_peserta)) {
			echo $this->pohtml->error();
			exit;
		}

        if($current_peserta['kode_prodi'] == 'AB'){
            $nm_prodi = 'Administrasi Bisnis';
         }else if($current_peserta['kode_prodi'] == 'AK'){
              $nm_prodi = 'Akuntansi Keuangan Publik';
         }else if($current_peserta['kode_prodi'] == 'AP'){
              $nm_prodi = 'Adminsitrasi Pemerintahan';
         }else if($current_peserta['kode_prodi'] == 'BD'){
              $nm_prodi = 'Bisnis Digital';
         }else if($current_peserta['kode_prodi'] == 'MI'){
              $nm_prodi = 'Manajemen Informatika';
         }else{
              $nm_prodi = '-';
         }
		?>
<div class="block-content">
    <div class="row">
        <div class="col-md-12">
            <?=$this->pohtml->headTitle('Edit Peserta MBKM');?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=peserta&act=edit&id='.$current_peserta['id'], 'autocomplete' => 'off'));?>
            <?=$this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_peserta['id']));?>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Periode Akademik <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-3">
                                <input type="number" name="periode" maxlength="5" class="form-control"
                                    value="<?=$current_peserta['periode'];?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="row">
                            <label class="col-md-3 label-inline">Nim <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control " id="nim" name="nim"
                                    value="<?=$current_peserta['nim'];?>" readonly="" required>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="kdprodi" id='kdprodi' value="<?=$current_peserta['kode_prodi'];?>">

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Nama Mahasiswa <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="nama" id="nama" class="form-control"
                                    value="<?=$current_peserta['nama'];?>" required="" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Program Studi <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" name="prodi" id="prodi" class="form-control" value="<?=$nm_prodi;?>"
                                    required="" readonly>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Kategori MBKM <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">

                                <select class="form-control" name="kategori" id="kategori" required>
                                    <?php
                                            $current_kategori= $this->podb->from('mbkm_kategori')
                                                ->where('mbkm_kategori_id', $current_peserta['mbkm_kategori_id'])
                                                ->limit(1)
                                                ->fetch();
                                            if (!empty($current_kategori)) {
                                                echo '<option value="' . $current_kategori['mbkm_kategori_id'] . '" hidden>' . strtoupper($current_kategori['mbkm_kategori_nama']) . '</option>';
                                            } else {
                                                echo '<option value="" hidden>Pilih</option>';
                                            }
                                            $kategori=$this->podb->from('mbkm_kategori')
                                            ->orderBy('mbkm_kategori_id ASC')
                                            ->fetchAll();
                                            foreach ($kategori as $ktg) {
                                            echo '<option value="' . $ktg['mbkm_kategori_id'] . '">' .
                                                $ktg['mbkm_kategori_nama'] . '</option>';
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
                            <label class="col-md-3 label-inline">BKP MBKM <span class="text-danger">*</span></label>
                            <div class="col-md-6">

                                <select class="form-control" name="bkp" id="bkp" required>
                                    <?php
                                    
                                    $current_bkp= $this->podb->from('mbkm_jenis')
                                                ->where('id', $current_peserta['jenis_mbkm'])
                                                ->limit(1)
                                                ->fetch();
                                            if (!empty($current_bkp)) {
                                                echo '<option value="' . $current_bkp['id'] . '" hidden>' . strtoupper($current_bkp['mbkm_jenis_nama']) . '</option>';
                                            } else {
                                                echo '<option value="" hidden>Pilih</option>';
                                            }
                                            $bkp=$this->podb->from('mbkm_jenis')
                                                    ->where('mbkm_jenis_aktif', 'Y')
                                                    ->orderBy('mbkm_jenis_nama ASC')
                                                    ->fetchAll();
                                            foreach ($bkp as $bk) {
                                            echo '<option value="' . $bk['id'] . '" class="' . $bk['mbkm_kategori'] . '">' .
                                                $bk['mbkm_jenis_nama'] . '</option>';
                                            }
                                    ?>
                                </select>
                                <span class="help-block"><small>Harus memilih kategori MBKM dahulu.</small></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 label-inline">Lokasi Kegiatan <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="lokasi" id="lokasi" class="form-control"
                                    value="<?=$current_peserta['lokasi_kegiatan'];?>" required="">
                                <span class="help-block"><small>Contoh: <strong>Desa Makmur</strong> atau <strong>Kantor
                                            Makmur</strong>.</small></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-12">
                    <?php
									if ($current_peserta['aktif'] == 'N') {
										$radioitem = array(
											array('name' => 'active', 'id' => 'active', 'value' => 'Y', 'options' => '', 'title' => 'YA'),
											array('name' => 'active', 'id' => 'active', 'value' => 'N', 'options' => 'checked', 'title' => 'TIDAK')
										);
										echo $this->pohtml->inputRadio(array('label' => 'Status Aktif', 'mandatory' => true), $radioitem, $inline = true);
									} else {
										$radioitem = array(
											array('name' => 'active', 'id' => 'active', 'value' => 'Y', 'options' => 'checked', 'title' => 'YA'),
											array('name' => 'active', 'id' => 'active', 'value' => 'N', 'options' => '', 'title' => 'TIDAK')
										);
										echo $this->pohtml->inputRadio(array('label' => 'Status Aktif', 'mandatory' => true), $radioitem, $inline = true);
									}
								?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?=$this->pohtml->formAction();?>
                </div>
            </div>
            <?=$this->pohtml->formEnd();?>
        </div>
    </div>
</div>

<?php
	}

    public function krs()
	{
		if (!$this->auth($_SESSION['leveluser'], 'peserta', 'create')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
                $role = array();
				$items = $_POST['item'];
                $jmlsksk = 0;
				foreach($items as $item){
					if(!empty($item['matakuliah'])){
                        $role[] = array(
                        'matakuliah' => $item['matakuliah'],
						'nama' => $item['nama'],
						'sks' => $item['sks'],
                        );
                         $jmlsksk += $item['sks'];
                    }
				}

                if($jmlsksk <= 20){
                    $itemroles = json_encode($role);
                    $data = array(
                        'mbkm_krs_periode' => $_POST['periode'],
                        'mbkm_krs_nim' => $_POST['id'],
                        'mbkm_krs_semester' => $_POST['smt'],
                        'matakuliah' => $itemroles
                    );
                    $querykrs = $this->podb->insertInto('mbkm_krs')->values($data);
                    $querykrs->execute();
                    $this->poflash->success('Peserta MBKM berhasil diupdate', 'admin.php?mod=peserta');
                }else{
                    $this->poflash->danger('Gagal, Jumlah SKS lebih dari 20', 'admin.php?mod=peserta&act=krs&id='.$_GET['id'].'&periode='.$_GET['periode']);
                }
				
			
			
			
		}
		
		?>
<div class="block-content">
    <div class="row">
        <div class="col-md-12">
            <?=$this->pohtml->headTitle('KRS Reguler');?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=peserta&act=krs&id='.$_GET['id'].'&periode='.$_GET['periode'], 'autocomplete' => 'off'));?>
            <?=$this->pohtml->inputHidden(array('name' => 'id', 'value' => $_GET['id']));?>
            <?=$this->pohtml->inputHidden(array('name' => 'periode', 'value' => $_GET['periode']));?>
            <div class="row">
                <div class="col-md-12 table-responsive" id="table-role">
                    <div class="form-group">
                        <?=$this->pohtml->tableStart(array('id' => 'table-role', 'class' => 'table table-striped table-bordered'));?>
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kode Matakuliah</th>
                                <th class="text-center">Matakuliah</th>
                                <th class="text-center">SKS</th>
                                <th class="text-center">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
								$nom = 1;
                                
                                // $json = file_get_contents($url);
                                // $json = json_decode($json);
                                // var_dump($json)
                                //$get_data = $this->callAPI('GET', $url, false);
                                
                               // $datax = $response['0'];
                                function getURLAPI($url) {
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                    $result = curl_exec($ch);
                                    curl_close($ch);
                                    return json_decode($result, true);
                                }

                                $url ="https://siakad.polteklp3imks.ac.id/api/krsbynim.php?nim=".$_GET['id'];
                                $jsonData = getURLAPI($url);
                                $nodir=0;
                                $jmlsks = 0;
                                foreach ($jsonData['data'] as $dta) {
							?>
                            <?=$this->pohtml->inputHidden(array('name' => 'smt', 'value' => $dta['smt']));?>
                            <input type="hidden" name="item[<?=$nodir;?>][nama]" value="<?= $dta['mtkul'];?>">
                            <input type="hidden" name="item[<?=$nodir;?>][sks]" value="<?= $dta['bobot'];?>">
                            <tr>
                                <td class="text-center"><?=$nom?></td>
                                <td class="text-center"><?= $dta['ssubject']?></td>
                                <td class="text-left"><?= $dta['mtkul']?></td>
                                <td class="text-center"><?= $dta['bobot']?></td>
                                <td class="text-center"><input type="checkbox" name="item[<?=$nodir;?>][matakuliah]"
                                        value="<?=$dta['ssubject']?>" /></td>
                            </tr>

                            <?php 
                             $jmlsks +=  $dta['bobot'];
                             $nom++;
                             $nodir++;
                             }  ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-center">
                                    <strong> TOTAL SKS</strong>
                                </td>
                                <td class="text-center"><?=$jmlsks?></td>
                            </tr>
                        </tfoot>
                        <?=$this->pohtml->tableEnd();?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?=$this->pohtml->formAction();?>
                </div>
            </div>
            <?=$this->pohtml->formEnd();?>
        </div>
    </div>
</div>

<?php
	}

     public function krsmbkm()
	{
		if (!$this->auth($_SESSION['leveluser'], 'peserta', 'update')) {
			echo $this->pohtml->error();
			exit;
		}
		
		?>
<div class="block-content">
    <div class="row">
        <div class="col-md-12">
            <?=$this->pohtml->headTitle('KRS MBKM');?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=peserta&act=krsmbkm&id='.$_GET['id'].'&periode='.$_GET['periode'], 'autocomplete' => 'off'));?>
            <div class="row">
                <div class="col-md-12 table-responsive" id="table-role">
                    <div class="form-group">
                        <?=$this->pohtml->tableStart(array('id' => 'table-role', 'class' => 'table table-striped table-bordered'));?>
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kode Matakuliah</th>
                                <th class="text-center">Matakuliah</th>
                                <th class="text-center">SKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
								$nom = 1;
                                $jmlsks = 0;
                                $krsmbkm = $this->podb->from('mbkm_krs')->where('mbkm_krs_nim',$_GET['id'])->where('mbkm_krs_periode',$_GET['periode'])->fetch();
                                $roles = json_decode($krsmbkm['matakuliah'], true);
                                foreach($roles as $key) {
							?>
                            <tr>
                                <td class="text-center"><?=$nom?></td>
                                <td class="text-center"><?=$key['matakuliah']?></td>
                                <td class="text-left"><?= $key['nama']?></td>
                                <td class="text-center"><?= $key['sks']?></td>
                            </tr>

                            <?php 
                             $jmlsks +=  $key['sks'];
                             $nom++;
                             }  ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-center">
                                    <strong> TOTAL SKS</strong>
                                </td>
                                <td class="text-center"><?=$jmlsks?></td>
                            </tr>
                        </tfoot>
                        <?=$this->pohtml->tableEnd();?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <a class="btn btn-danger hapuskrs" id="<?=$_GET['id'];?>" periode="<?=$_GET['periode'];?>"><i
                                class="fa fa-refresh"></i> Reset KRS</a>
                        <button type="reset" class="btn btn-primary pull-right" onclick="self.history.back()"><i
                                class="fa fa-arrow-left"></i> Kembali</button>
                    </div>
                </div>
            </div>
            <?=$this->pohtml->formEnd();?>
        </div>
    </div>
</div>
<?= $this->pohtml->dialogDeleteKRS('peserta'); ?>
<?php
	}

    public function deletekrs()
    {
        if (!$this->auth($_SESSION['leveluser'], 'peserta', 'delete')) {
            echo $this->pohtml->error();
            exit;
        }
        if (!empty($_POST)) {
            $query = $this->podb->deleteFrom('mbkm_krs')->where('mbkm_krs_nim', $_POST['id'])->where('mbkm_krs_periode', $_POST['periode']);
            $query->execute();

            $this->poflash->success('KRS MBKM has been successfully deleted', 'admin.php?mod=peserta');
        }
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
            $id = $this->postring->valid($_POST['id'], 'sql');
            $query = $this->podb->deleteFrom('mbkm_peserta')->where('id', $id);
            $query->execute();

            $this->poflash->success('Peserta MBKM has been successfully deleted', 'admin.php?mod=peserta');
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
                    $query = $this->podb->deleteFrom('mbkm_peserta')->where('id', $this->postring->valid($item['deldata'], 'sql'));
                    $query->execute();
                }
                $this->poflash->success('Peserta MKBM has been successfully deleted', 'admin.php?mod=peserta');
            } else {
                $this->poflash->error('Error deleted peserta data', 'admin.php?mod=peserta');
            }
        }
    }


}