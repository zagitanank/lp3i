<?php
/*
 *
 * - Zagitanank Widget File
 *
 * - File : mitra.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk widget mitra.
 * This is a php file for handling front end process for mitra widget.
 *
*/

/**
 * Memanggil class utama PoTemplate (diharuskan).
 *
 * Call main class PoTemplate (require).
 *
*/
use PoTemplate\Engine;
use PoTemplate\Extension\ExtensionInterface;

/**
 * Mendeklarasikan class widget diharuskan dengan mengimplementasikan class ExtensionInterface (diharuskan).
 *
 * Declaration widget class must with implements ExtensionInterface class (require).
 *
*/
class mitra implements ExtensionInterface
{

	/**
	 * Fungsi ini digunakan untuk menginisialisasi class utama (diharuskan).
	 *
	 * This function use to initialize the main class (require).
	 *
	*/
	public function __construct()
	{
		$this->core = new PoCore();
	}

	/**
	 * Fungsi ini digunakan untuk mendaftarkan semua fungsi widget (diharuskan).
	 *
	 * This function use to register all widget function (require).
	 *
	*/
    public function register(Engine $templates)
    {
        $templates->registerFunction('mitra', [$this, 'getObject']);
    }

	/**
	 * Fungsi ini digunakan untuk menangkap semua fungsi widget (diharuskan).
	 *
	 * This function use to catch all widget function (require).
	 *
	*/
    public function getObject()
    {
        return $this;
    }


	/**
	 * Fungsi ini digunakan untuk mengambil daftar mitra.
	 *
	 * This function use to get list of mitra.
	 *
	 * $limit = integer
	 * $order = string
	 * $page = integer from get active page
	*/
	public function getmitra($order)
    {
		$mitra = $this->core->podb->from('mitra')
            ->where('active','Y')
			->orderBy('id_mitra '.$order.'')
			->fetchAll();
		return $mitra;
    }

	/**
	 * Fungsi ini digunakan untuk membuat nomor halaman pada halaman mitra
	 *
	 * This function use to create pagination in mitra page.
	 *
	 * $limit = integer
	 * $page = integer from get active page
	 * $type = 0 or 1
	 * $prev = string previous text
	 * $next = string next text
	*/
	public function getmitraPaging($limit, $page, $type, $prev, $next)
    {
		$totaldata = $this->core->podb->from('mitra')->count();
		$totalpage = $this->core->popaging->totalPage($totaldata, $limit);
		$pagination = $this->core->popaging->navPage($page, $totalpage, BASE_URL, 'mitra', 'page', $type, $prev, $next);
		return $pagination;
	}

	/**
	 * Fungsi ini digunakan untuk mengambil daftar galeri berdasarkan mitra.
	 *
	 * This function use to get list of mitra base on mitra.
	 *
	 * $limit = integer
	 * $order = string
	*/
    public function getHeadlinemitra($limit, $order)
    {
        $mitra = $this->core->podb->from('mitra')
            ->where('active','Y')
            ->orderBy($order)
            ->limit($limit)
            ->fetchAll();
        return $mitra;
    }

}
