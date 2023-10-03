<?php
/*
 *
 * - Zagitanank statistik File
 *
 * - File : statistik.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk statistik statistik.
 * This is a php file for handling front end process for statistik statistik.
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
 * Mendeklarasikan class statistik diharuskan dengan mengimplementasikan class ExtensionInterface (diharuskan).
 *
 * Declaration statistik class must with implements ExtensionInterface class (require).
 *
*/
class Statistik implements ExtensionInterface
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
	 * Fungsi ini digunakan untuk mendaftarkan semua fungsi statistik (diharuskan).
	 *
	 * This function use to register all statistik function (require).
	 *
	*/
    public function register(Engine $templates)
    {
        $templates->registerFunction('statistik', [$this, 'getObject']);
    }

	/**
	 * Fungsi ini digunakan untuk menangkap semua fungsi statistik (diharuskan).
	 *
	 * This function use to catch all statistik function (require).
	 *
	*/
    public function getObject()
    {
        return $this;
    }

	/**
	 * Fungsi ini digunakan untuk mengambil daftar semua statistik.
	 *
	 * This function use to get all list of statistik.
	 *
	 * $order = string
	 * $limit = integer
	*/
	public function getStatistik($order, $lang)
    {
		$statistik = $this->core->podb->from('statistik')
			->select(array('statistik_description.title'))
			->leftJoin('statistik_description ON statistik_description.id_statistik = statistik.id_statistik')
			->where('statistik_description.id_language', $lang)
			->where('statistik.active', 'Y')
			->orderBy('statistik.id_statistik '.$order.'')
			->fetchAll();
        return $statistik;
    }
    

}
