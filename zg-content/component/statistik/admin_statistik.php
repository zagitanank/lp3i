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

class Statistik extends PoCore
{

	/**
	 * Fungsi ini digunakan untuk menampilkan halaman index home.
	 *
	 * This function use for index home page.
	 *
	 * Added chart by https://github.com/n4mlih
	 *
	*/
	public function index()
	{
	$tahundepan = $this->posetting[30]['value']+1;
    $jmlseluruh = $this->podb->from('peserta')->where('block','N')->where('tahun_ajaran', $this->posetting[30]['value'])->count();
	?>
        <script src="../<?=DIR_INC;?>/js/amchart/amcharts.js"></script>
        <script src="../<?=DIR_INC;?>/js/amchart/serial.js"></script>
        <script src="../<?=DIR_INC;?>/js/amchart/light.js"></script>
            <script>
                    var chart = AmCharts.makeChart("chartdiv", {
                        "theme": "light",
                        "type": "serial",
                    	"startDuration": 2,
                        "dataProvider": [
                        <?php
                        $prodi = $this->podb->from('program_studi')->fetchAll();
                        foreach($prodi as $pr){
                            $jmlpendaftaran = $this->podb->from('peserta')->where('pilihan_pertama',$pr['prodiKode'])
                                                                           ->where('block','N')
                                                                           ->where('tahun_ajaran', $this->posetting[30]['value'])
                                                                           ->count();
                            $warna          = $this->randomColor();
                        echo"
                        {
                            'prodi':  '".$pr['prodiNamaSingkat']."',
                            'visits': '".$jmlpendaftaran."',
                            'color':  '#$warna[hex]'
                        },";
                        }
                        ?>
                        ],
                        "valueAxes": [{
                          "position": "left",
                          "axisAlpha": 0,
                          "gridAlpha": 0,
                          "labelsEnabled": true,
                          "minimum": 0,
                          "title": "Jumlah"
                      }],
                        "graphs": [{
                            "balloonText": "[[category]]: <b>[[value]]</b>",
                            "fillColorsField": "color",
                            "fillAlphas": 1,
                            "lineAlpha": 0.1,
                            "type": "column",
                            "valueField": "visits"
                        }],
                        "depth3D": 20,
                    	"angle": 30,
                        "chartCursor": {
                            "categoryBalloonEnabled": false,
                            "cursorAlpha": 0,
                            "zoomable": false
                        },
                        "categoryField": "prodi",
                        "categoryAxis": {
                            "gridPosition": "start",
                            "labelRotation": 90
                        }
                    
                    });
            </script>    
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle('Statistik Camaba '.$this->posetting[30]['value'].'-'.$tahundepan, '
						<div class="btn-title pull-right">
							<a href="admin.php?mod=statistik&act=perbandingan" class="btn btn-success btn-xs"><i class="fa fa-bar-chart"></i> Statistik Perbandingan</a>
						</div>
					');?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<h2>Jumlah Pendaftar <?=$this->posetting[30]['value'];?> - <?=$tahundepan;?> : <strong><?=$jmlseluruh;?></strong></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="stats-desc">
						<div id="chartdiv"></div>
					</div>
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
	public function perbandingan()
	{
	   
       $tahunskrng = date('Y');
       $tahunlalu  = date('Y')-1;
	?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle('Statistik Perbandingan');?>
				</div>
			</div>
            <!--
			<div class="row">
				<div class="col-md-12 text-center">
					<form class="form-inline" method="get" action="admin.php" autocomplete="off">
						<input type="hidden" name="mod" value="home" />
						<input type="hidden" name="act" value="statistics" />
						<div class="form-group" style="border-bottom: none;">
							<input type="text" name="from" class="form-control" id="from_stat" value="<?=(isset($_GET['from']) ? $_GET['from'] : '');?>" placeholder="<?=$GLOBALS['_']['home_from_date'];?>" required />
						</div>
						<div class="form-group" style="border-bottom: none;">
							<input type="text" name="to" class="form-control" id="to_stat" value="<?=(isset($_GET['to']) ? $_GET['to'] : '');?>" placeholder="<?=$GLOBALS['_']['home_to_date'];?>" required />
						</div>
						<div class="form-group" style="border-bottom: none;">
							<button type="submit" class="btn btn-primary"><?=$GLOBALS['_']['action_5'];?></button>
						</div>
					</form>
				</div>
			</div>
            -->
			<div class="row">
				<div class="row">
                <h3 class="text-center text-uppercase">Perbandingan Camaba Tahun <?=$tahunlalu;?> dengan <?=$tahunskrng;?></h3>
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered ">
							<tr>
								<th class="text-center" rowspan="2" style="vertical-align: middle;">No.</th>
								<th class="text-center" rowspan="2" style="vertical-align: middle;">Bulan</th>
							</tr>
                            <tr>
                                <th class="text-center">Buat Akun <?=$tahunlalu;?></th>
                                <th class="text-center">Buat Akun <?=$tahunskrng;?></th>
								<th class="text-center">Bayar Formulir <?=$tahunlalu;?></th>
								<th class="text-center">Bayar Formulir <?=$tahunskrng;?></th>
								<th class="text-center">Daftar Ulang <?=$tahunlalu;?></th>
								<th class="text-center">Daftar Ulang <?=$tahunskrng;?></th>
                            </tr>
							<?php
								$novisitor = 1;
								for($bln=1; $bln <= 12; $bln++){
								    if($bln < 10){
								        $blna = '0'.$bln;
								    }else{
								        $blna = $bln;
								    }
                                    $bulan = $this->getBulan2($blna);
                                    $dataBuatAkunTahunLalu = $this->podb->from('peserta')->where('MONTH(tgl_daftar) = ?',$blna)->where('tahun_ajaran',$tahunlalu)->count();
                                    $dataBuatAkunTahunIni = $this->podb->from('peserta')->where('MONTH(tgl_daftar) = ?',$blna)->where('tahun_ajaran',$tahunskrng)->count();
                                    
                                    $dataBayarFormulirTahunLalu = $this->podb->from('peserta')->where('block','N')->where('MONTH(tgl_daftar) = ?',$blna)->where('tahun_ajaran',$tahunlalu)->count();
                                    $dataBayarFormulirTahunIni = $this->podb->from('peserta')->where('block','N')->where('MONTH(tgl_daftar) = ?',$blna)->where('tahun_ajaran',$tahunskrng)->count();
                                    
                                    $dataDaftarUlangTahunLalu = $this->podb->from('peserta')->where('block','N')->where('bayar_daftarulang','Y')->where('MONTH(tgl_input_seleksi) = ?',$blna)->where('tahun_ajaran',$tahunlalu)->count();
                                    $dataDaftarUlangTahunIni = $this->podb->from('peserta')->where('block','N')->where('bayar_daftarulang','Y')->where('MONTH(tgl_input_seleksi) = ?',$blna)->where('tahun_ajaran',$tahunskrng)->count();
							?>
							<tr>
								<td class="text-center"><?=$novisitor;?></td>
                                <td class="text-center"><?=$bulan;?></td>
                                <td class="text-center"><?=$dataBuatAkunTahunLalu;?></td>
                                <td class="text-center"><?=$dataBuatAkunTahunIni?></td>
                                <td class="text-center"><?=$dataBayarFormulirTahunLalu?></td>
                                <td class="text-center"><?=$dataBayarFormulirTahunIni?></td>
                                <td class="text-center"><?=$dataDaftarUlangTahunLalu?></td>
                                <td class="text-center"><?=$dataDaftarUlangTahunIni?></td>
                                
							</tr>
							<?php 
                            @$totalbuatakuntahunlalu += $dataBuatAkunTahunLalu;
                            @$totalbuatakuntahunini += $dataBuatAkunTahunIni;
                            @$totalbayarformulirtahunlalu += $dataBayarFormulirTahunLalu;
                            @$totalbayarformulirtahunini += $dataBayarFormulirTahunIni;
                            @$totaldaftarulangtahunlalu += $dataDaftarUlangTahunLalu;
                            @$totaldaftarulangtahunini += $dataDaftarUlangTahunIni;
                            $novisitor++;} ?>
                            <tr>
                                <td class="text-center" colspan="2"><strong>Total</strong></td>
                                <td class="text-center"><strong><?=$totalbuatakuntahunlalu?></strong></td>
                                <td class="text-center"><strong><?=$totalbuatakuntahunini?></strong></td>
                                <td class="text-center"><strong><?=$totalbayarformulirtahunlalu?></strong></td>
                                <td class="text-center"><strong><?=$totalbayarformulirtahunini?></strong></td>
                                <td class="text-center"><strong><?=$totaldaftarulangtahunlalu?></strong></td>
                                <td class="text-center"><strong><?=$totaldaftarulangtahunini?></strong></td>
                            </tr>
						</table>
					</div>
				</div>
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
					The page you requested could not be found, either contact your webmaster or try again.<br />
					Use your browsers <b>Back</b> button to navigate to the page you have previously<br />
					come from <b>or you could just press this neat little button :</b>
				</p>
				<a href="admin.php?mod=statistik" class="btn btn-sm btn-primary"><i class="fa fa-home"></i> Take Me Home</a>
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
