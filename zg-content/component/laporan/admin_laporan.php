<?php
/*
 *
 * - Zagitanank Admin File
 *
 * - File : admin_home.php
 * - Version : 1.3
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses admin pada halaman home.
 * This is a php file for handling admin process for home page.
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
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']) AND $_SESSION['login'] == 0) {
	header('location:index.php');
	exit;
}

class Laporan extends PoCore
{

	/**
	 * Fungsi ini digunakan untuk menampilkan halaman index home.
	 *
	 * This function use for index home page.
	 *
	 *
	*/
	public function index()
	{
	?>
    <div class="block-content" style="height:500px;">
        <div class="row">
            <div class="col-md-12">
                <?=$this->pohtml->headTitle('Laporan');?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form role="form" method="post" action="route.php?mod=excel" autocomplete="off" target="_blank">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="mulai">Tahun Ajaran <span class="text-danger">*</span></label>
                                <select class="form-control" name="tahunajaran" required>
                                    <?php
                    									$tahunajaran = $this->podb->from('peserta')
                    										->select('tahun_ajaran')
                    										->groupBy('tahun_ajaran')
                    										->fetchAll();
                                                        foreach($tahunajaran as $ta){
                    										echo "<option value='".$ta['tahun_ajaran']."'>".$ta['tahun_ajaran']."</option>";
                    									}
                        			?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="laporan" class="col-md-4 label-inline">Jenis Laporan </label>
                                <select class="form-control" name="laporan" id="laporan" required>
                                    <option value="" hidden="">Pilih</option>
                                    <option value="1">Rekap Pembayaran Registrasi Akun</option>
                                    <option value="2">Laporan Data Lulus Seleksi</option>
                                    <option value="3">Laporan Data Pendaftar Verifikasi Berkas</option>
                                    <option value="4">Daftar Perkembangan Calon Mahasiswa Baru</option>
                                    <option value="5">Jadwal Wawancara</option>
                                    <option value="6">Bayar Daftar Ulang</option>
                                    <option value="7">Belum Bayar Daftar Ulang</option>
                                    <option value="8">Belum Bayar Registrasi Formulir</option>
                                    <option value="8">Rekap Refferall</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="prodi" class="col-md-3 label-inline">Prodi</label>
                                <select class="form-control" name="prodi" id="prodi" required>
                                    <option value="all">Semua</option>
                                    <?php
                                        $prodi = $this->podb->from('program_studi')
                    										->orderBy('jenjang_studi_id')
                    										->fetchAll();
                                        foreach($prodi as $pr){
      										echo "<option value='".$pr['prodiKode']."'>".$pr['prodiNamaSingkat']."</option>";
   									    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <?=$this->pohtml->inputText(array('type' => 'text', 'label' => 'Tanggal Mulai', 'name' => 'mulai', 'id' => 'mulai', 'value' => '', 'mandatory' => false, 'options' => ''));?>
                        </div>
                        <div class="col-md-2">
                            <?=$this->pohtml->inputText(array('type' => 'text', 'label' => 'Tanggal Selesai', 'name' => 'selesai', 'id' => 'selesai', 'value' => '', 'mandatory' => false, 'options' => ''));?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?=$this->pohtml->formAction();?>
                    </div>
                    <?=$this->pohtml->formEnd();?>
            </div>
        </div>
    </div>
    <?php
	}
	/**
	 * Fungsi ini digunakan untuk menampilkan halaman error home.
	 *
	 * This function use for error home page.
	 *
	*/
	public function error()
	{
	?>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="page-header">Page Not Found <small class="text-danger">Error 404</small></h1>
                <p>
                    The page you requested could not be found, either contact your webmaster or try again.
                    <br /> Use your browsers <b>Back</b> button to navigate to the page you have previously
                    <br /> come from <b>or you could just press this neat little button :</b>
                </p>
                <a href="admin.php?mod=home" class="btn btn-sm btn-primary"><i class="fa fa-home"></i> Take Me Home</a>
            </div>
        </div>
        <?php
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan halaman logout.
	 *
	 * This function use for logout page.
	 *
	*/
	public function logout()
	{
		session_destroy();
		header('location:index.php');
	}

}