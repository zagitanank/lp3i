<?php
/*
 *
 * - Zagitanank Widget File
 *
 * - File : testimoni.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk widget testimoni.
 * This is a php file for handling front end process for testimoni widget.
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
class testimoni implements ExtensionInterface
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
        $templates->registerFunction('testimoni', [$this, 'getObject']);
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
	 * Fungsi ini digunakan untuk mengambil daftar testimoni.
	 *
	 * This function use to get list of testimoni.
	 *
	 * $limit = integer
	 * $order = string
	 * $page = integer from get active page
	*/
	public function gettestimoni($order)
    {
		$testimoni = $this->core->podb->from('testimoni')
            ->where('active','Y')
			->orderBy('id_testimoni '.$order.'')
			->fetchAll();
		return $testimoni;
    }

	/**
	 * Fungsi ini digunakan untuk membuat nomor halaman pada halaman testimoni
	 *
	 * This function use to create pagination in testimoni page.
	 *
	 * $limit = integer
	 * $page = integer from get active page
	 * $type = 0 or 1
	 * $prev = string previous text
	 * $next = string next text
	*/
	public function gettestimoniPaging($limit, $page, $type, $prev, $next)
    {
		$totaldata = $this->core->podb->from('testimoni')->count();
		$totalpage = $this->core->popaging->totalPage($totaldata, $limit);
		$pagination = $this->core->popaging->navPage($page, $totalpage, BASE_URL, 'testimoni', 'page', $type, $prev, $next);
		return $pagination;
	}

	/**
	 * Fungsi ini digunakan untuk mengambil daftar galeri berdasarkan testimoni.
	 *
	 * This function use to get list of testimoni base on testimoni.
	 *
	 * $limit = integer
	 * $order = string
	*/
    public function getHeadlinetestimoni($limit, $order)
    {
        $testimoni = $this->core->podb->from('testimoni')
            ->where('active','Y')
            ->orderBy($order)
            ->limit($limit)
            ->fetchAll();
        return $testimoni;
    }

}
