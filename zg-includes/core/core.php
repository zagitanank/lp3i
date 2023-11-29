<?php

/**
 *
 * - zagitanank Core
 *
 * - File : core.php
 * - Version : 1.1
 * - Author : zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file core zagitanank yang memuat semua library penunjang.
 * This is a file core from zagitanank which contains all the supporting libraries.
 *
 */

/**
 * Mendeklarasi Core Path zagitanank
 *
 * Declaration Core Path zagitanank
 *
 * Thanks to Mang Aay
 *
 */
define('CORE_PATH', dirname(__FILE__));

/**
 * Memasukkan library utama zagitanank
 *
 * Include zagitanank library
 *
 */
require_once CORE_PATH . "/config.php";
require_once CORE_PATH . "/cookie.php";
require_once CORE_PATH . "/datetime.php";
require_once CORE_PATH . "/directory.php";
require_once CORE_PATH . "/email.php";
require_once CORE_PATH . "/error.php";
require_once CORE_PATH . "/html.php";
require_once CORE_PATH . "/paging.php";
require_once CORE_PATH . "/request.php";
require_once CORE_PATH . "/sitemap.php";
require_once CORE_PATH . "/string.php";
require_once CORE_PATH . "/timeout.php";

/**
 * Memasukkan library dari vendor pihak ketiga
 *
 * Include vendor library
 *
 */
require_once CORE_PATH . "/vendor/abeautifulsite/SimpleImage.php";
require_once CORE_PATH . "/vendor/bramus/Router.php";
require_once CORE_PATH . "/vendor/browser/Browser.php";
require_once CORE_PATH . "/vendor/datatables/datatables.class.php";
require_once CORE_PATH . "/vendor/dynamicmenu/dashboard_menu.php";
require_once CORE_PATH . "/vendor/dynamicmenu/front_menu.php";
require_once CORE_PATH . "/vendor/fluentpdo/FluentPDO.php";
require_once CORE_PATH . "/vendor/gump/gump.class.php";
require_once CORE_PATH . "/vendor/pclzip/pclziplib.php";
require_once CORE_PATH . "/vendor/phpmailer/PHPMailerAutoload.php";
require_once CORE_PATH . "/vendor/plasticbrain/FlashMessages.php";
require_once CORE_PATH . "/vendor/plates/autoload.php";
require_once CORE_PATH . "/vendor/recaptcha/recaptchalib.php";
require_once CORE_PATH . "/vendor/timeago/timeago.inc.php";
require_once CORE_PATH . "/vendor/verot/class.upload.php";

/**
 * Menginisialisasi semua class dari zagitanank dan vendor
 *
 * Initialize all class from zagitanank and vendor
 *
 */

class PoCore
{

	public $pdo;
	public $podb;
	public $poconnect;
	public $poval;
	public $pohtml;
	public $postring;
	public $poflash;
	public $podatetime;
	public $pomail;
	public $posetting;
	public $potheme;
	public $porequest;
	public $popaging;
	public $mbkmsetting;

	public function __construct()
	{
		/**
		 * Menyamakan perbedaan waktu sistem dan database
		 *
		 * Synchronize different system time and database
		 *
		 */
		date_default_timezone_set(TIMEZONE);
		$timenow = new DateTime();
		$timemins = $timenow->getOffset() / 60;
		$timesgn = ($timemins < 0 ? -1 : 1);
		$timemins = abs($timemins);
		$timehrs = floor($timemins / 60);
		$timemins -= $timehrs * 60;
		$timeoffset = sprintf('%+d:%02d', $timehrs * $timesgn, $timemins);

		/**
		 * Menginisialisasi semua class dari zagitanank dan vendor ke variabel
		 *
		 * Initialize all class from zagitanank and vendor to variabel
		 *
		 */
		$this->pdo = new PDO(DATABASE_DRIVER . ":host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME . "", DATABASE_USER, DATABASE_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$this->pdo->exec("SET time_zone='$timeoffset';");
		$this->podb = new FluentPDO($this->pdo);
		$this->poconnect = array('user' => DATABASE_USER, 'pass' => DATABASE_PASS, 'db' => DATABASE_NAME, 'host' => DATABASE_HOST);
		$this->porequest = new PoRequest();
		$this->poval = new GUMP();
		$this->pohtml = new PoHtml();
		$this->postring = new PoString();
		$this->poflash = new FlashMessages();
		$this->podatetime = new PoDateTime();
		$this->pomail = new PHPMailer();
		$this->popaging = new PoPaging();
		$this->posetting = $this->podb->from('setting')->fetchAll();
		$this->potheme = $this->podb->from('theme')->where('active', 'Y')->limit(1)->fetch();
		$this->mbkmsetting = $this->podb->from('mbkm_jadwal')->where('mbkm_jadwal_aktif', 'Y')->limit(1)->fetch();
	}

	/**
	 * Fungsi ini digunakan untuk auntentikasi user.
	 *
	 * This function is used to user authentication.
	 *
	 */
	public function auth($level, $component, $crud)
	{
		$user_level = $this->podb->from('user_level')
			->where('id_level', $level)
			->limit(1)
			->fetch();
		$itemfusion = '';
		$roles = json_decode($user_level['role'], true);
		foreach ($roles as $key => $role) {
			if ($roles[$key]['component'] == $component) {
				$itemfusion .= $roles[$key][$crud];
			} else {
				unset($roles[$key]);
			}
		}
		if ($itemfusion == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Fungsi ini digunakan untuk memasang bahasa.
	 *
	 * This function is used to set language.
	 *
	 */
	public function setlang($component, $lang)
	{
		if (file_exists("zg-content/lang/" . $component . "/" . $lang . ".php")) {
			if (VQMOD == TRUE) {
				include_once VQMod::modCheck("zg-content/lang/main/" . $lang . ".php");
				include_once VQMod::modCheck("zg-content/lang/" . $component . "/" . $lang . ".php");
				return $_;
			} else {
				include_once "zg-content/lang/main/" . $lang . ".php";
				include_once "zg-content/lang/" . $component . "/" . $lang . ".php";
				return $_;
			}
		} else {
			if (VQMOD == TRUE) {
				include_once VQMod::modCheck("zg-content/lang/main/id.php");
				include_once VQMod::modCheck("zg-content/lang/" . $component . "/id.php");
				return $_;
			} else {
				include_once "zg-content/lang/main/id.php";
				include_once "zg-content/lang/" . $component . "/id.php";
				return $_;
			}
		}
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan random warna.
	 *
	 * This function is used to display random color.
	 *
	 */
	public function randomColor()
	{
		$result = array('rgb' => '', 'hex' => '');
		foreach (array('r', 'b', 'g') as $col) {
			$rand = mt_rand(0, 255);
			$result['rgb'][$col] = $rand;
			$dechex = dechex($rand);
			if (strlen($dechex) < 2) {
				$dechex = '0' . $dechex;
			}
			$result['hex'] .= $dechex;
		}
		return $result;
	}

	###################################################################################
	# FUNGSI CONVERT TAHUN AKADEMIK KE TEXT
	###################################################################################
	function Convert_periode_totext($s)
	{
		$t = substr($s, 0, 4);
		$p = substr($s, 4, 1);
		if ($p == 1) {
			$ta = $t . '-GANJIL';
		} elseif ($p == 2) {
			$ta = $t . '-GENAP';
		} elseif ($p == 3) {
			$ta = $t . '-ANTARA';
		} else {
			$ta = 'SEMUA PERIODE';
		}
		return $ta;
	}

	/**
	 * Fungsi ini digunakan untuk jadwal.
	 *
	 * This function is used to schedule.
	 *
	 */
	public function jadwal_mbkm($tahun)
	{
		$tgl_sekarang = strtotime(date("Y-m-d"));
		$jadwal_current = $this->podb->from('jadwal')
			->where('tahun_ajaran', $tahun)
			->where('status_pendaftaran', 'Y')
			->fetchAll();
		foreach ($jadwal_current as $jadwal) {
			$t1 = strtotime($jadwal['tanggal_mulai']);
			$t2 = strtotime($jadwal['tanggal_selesai']);
			if (($tgl_sekarang >= $t1) && ($tgl_sekarang <= $t2)) {
				$gel = $jadwal['jadwal_gelombang'];
			}
		}
		if (!empty($gel)) {
			return $gel;
		} else {
			return 0;
		}
	}

	/**
	 * Fungsi ini digunakan untuk tanggal indonesia.
	 *
	 * This function is used to indonesia date.
	 *
	 */
	public function tanggal_indo($tgl)
	{
		$tanggal = substr($tgl, 8, 2);
		$bulan = $this->getBulan(substr($tgl, 5, 2));
		$tahun = substr($tgl, 0, 4);
		return $tanggal . '-' . $bulan . '-' . $tahun;
	}

	/**
	 * Fungsi ini digunakan untuk bulan indonesia.
	 *
	 * This function is used to indonesia month.
	 *
	 */
	public function getBulan($bln)
	{
		switch ($bln) {
			case 1:
				return "01";
				break;
			case 2:
				return "02";
				break;
			case 3:
				return "03";
				break;
			case 4:
				return "04";
				break;
			case 5:
				return "05";
				break;
			case 6:
				return "06";
				break;
			case 7:
				return "07";
				break;
			case 8:
				return "08";
				break;
			case 9:
				return "09";
				break;
			case 10:
				return "10";
				break;
			case 11:
				return "11";
				break;
			case 12:
				return "12";
				break;
		}
	}


	/**
	 * Fungsi ini digunakan untuk tanggal indonesia.
	 *
	 * This function is used to indonesia date.
	 *
	 */
	public function tanggal_indo2($tgl)
	{
		$tanggal = substr($tgl, 8, 2);
		$bulan = $this->getBulan2(substr($tgl, 5, 2));
		$tahun = substr($tgl, 0, 4);
		return $tanggal . ' ' . $bulan . ' ' . $tahun;
	}

	/**
	 * Fungsi ini digunakan untuk bulan indonesia.
	 *
	 * This function is used to indonesia month.
	 *
	 */
	public function getBulan2($bln)
	{
		switch ($bln) {
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}

	/**
	 * Fungsi ini digunakan untuk hari indonesia.
	 *
	 * This function is used to indonesia day.
	 *
	 */
	public function getHari($hari)
	{
		switch ($hari) {
			case 'Sun':
				return "Minggu";
				break;
			case 'Mon':
				return "Senin";
				break;
			case 'Tue':
				return "Selasa";
				break;
			case 'Wed':
				return "Rabu";
				break;
			case 'Thu':
				return "Kamis";
				break;
			case 'Fri':
				return "Jumat";
				break;
			case 'Sat':
				return "Sabtu";
				break;
		}
	}

	public function tambah_jam_sql($menit)
	{
		$str = "";
		if ($menit < 60) {
			$str = "00:" . str_pad($menit, 2, "0", STR_PAD_LEFT) . ":00";
		} else if ($menit >= 60) {
			$mod = $menit % 60;
			$bg = floor($menit / 60);
			$str = str_pad($bg, 2, "0", STR_PAD_LEFT) . ":" . str_pad($mod, 2, "0", STR_PAD_LEFT) . ":00";
		}
		return $str;
	}

	public function base64url_encode($s) {
		return str_replace(array('+', '/','='), array('-', '_'), base64_encode($s));
	}

	public function base64url_decode($s) {
		return base64_decode(str_replace(array('-', '_'), array('+', '/','='), $s));
	}

	public function encrypt($string) {
		$key = 'Zagitanank2211';
		$cipher = "AES-256-CBC";
		$ivlen = openssl_cipher_iv_length($cipher);
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext = openssl_encrypt($string, $cipher, $key, OPENSSL_RAW_DATA, $iv);
		$hmac = hash_hmac('sha256', $ciphertext, $key, true);
		return $this->base64url_encode($iv . $hmac . $ciphertext);
	}
	
	public function decrypt($string) {
		$key = 'Zagitanank2211';
		$cipher = "AES-256-CBC";
		$c = $this->base64url_decode($string);
		$ivlen = openssl_cipher_iv_length($cipher);
		$iv = substr($c, 0, $ivlen);
		$hmac = substr($c, $ivlen, $sha2len = 32);
		$ciphertext = substr($c, $ivlen + $sha2len);
		$original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
		$calcmac = hash_hmac('sha256', $ciphertext, $key, true);
		if (hash_equals($hmac, $calcmac)) {
			return $original_plaintext;
		}
		return false;
	}
	

	public function tjs($tgl, $tipe)
	{
		if ($tgl != "0000-00-00 00:00:00") {
			$pc_satu	= explode(" ", $tgl);
			if (count($pc_satu) < 2) {
				$tgl1		= $pc_satu[0];
				$jam1		= "";
			} else {
				$jam1		= $pc_satu[1];
				$tgl1		= $pc_satu[0];
			}

			$pc_dua		= explode("-", $tgl1);
			$tgl		= $pc_dua[2];
			$bln		= $pc_dua[1];
			$thn		= $pc_dua[0];

			$bln_pendek		= array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");
			$bln_panjang	= array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

			$bln_angka		= intval($bln) - 1;

			if ($tipe == "l") {
				$bln_txt = $bln_panjang[$bln_angka];
			} else if ($tipe == "s") {
				$bln_txt = $bln_pendek[$bln_angka];
			}

			return $tgl . " " . $bln_txt . " " . $thn . "  " . $jam1;
		} else {
			return "Tgl Salah";
		}
	}

	public function curlPost($url, $data=NULL, $headers = NULL) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        if(!empty($data)){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
    
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
    
        $response = curl_exec($ch);
    
        if (curl_error($ch)) {
            trigger_error('Curl Error:' . curl_error($ch));
        }
    
        curl_close($ch);
        return $response;
    }
}