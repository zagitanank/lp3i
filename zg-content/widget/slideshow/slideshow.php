<?php
/*
 *
 * - Zagitanank Widget File
 *
 * - File : slide.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk widget slide.
 * This is a php file for handling front end process for slide widget.
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
class slideshow implements ExtensionInterface
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
        $templates->registerFunction('slideshow', [$this, 'getObject']);
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
	 * Fungsi ini digunakan untuk mengambil daftar slide.
	 *
	 * This function use to get list of slide.
	 *
	 * $limit = integer
	 * $order = string
	 * $page = integer from get active page
	*/
	public function getSlide($order)
    {
		$slide = $this->core->podb->from('slideshow')
            ->where('active','Y')
			->orderBy('id_slide '.$order.'')
			->fetchAll();
		return $slide;
    }

	/**
	 * Fungsi ini digunakan untuk membuat nomor halaman pada halaman slide
	 *
	 * This function use to create pagination in slide page.
	 *
	 * $limit = integer
	 * $page = integer from get active page
	 * $type = 0 or 1
	 * $prev = string previous text
	 * $next = string next text
	*/
	public function getSlidePaging($limit, $page, $type, $prev, $next)
    {
		$totaldata = $this->core->podb->from('slideshow')->count();
		$totalpage = $this->core->popaging->totalPage($totaldata, $limit);
		$pagination = $this->core->popaging->navPage($page, $totalpage, BASE_URL, 'slideshow', 'page', $type, $prev, $next);
		return $pagination;
	}

	/**
	 * Fungsi ini digunakan untuk mengambil daftar galeri berdasarkan slide.
	 *
	 * This function use to get list of slide base on slideshow.
	 *
	 * $limit = integer
	 * $order = string
	*/
    public function getHeadlineSlide($limit, $order)
    {
        $slide = $this->core->podb->from('slideshow')
            ->where('active','Y')
            ->orderBy($order)
            ->limit($limit)
            ->fetchAll();
        return $slide;
    }

}
