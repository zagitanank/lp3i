<?php
/*
 *
 * - Zagitanank Widget File
 *
 * - File : team.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk widget team.
 * This is a php file for handling front end process for team widget.
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
class team implements ExtensionInterface
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
        $templates->registerFunction('team', [$this, 'getObject']);
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
	 * Fungsi ini digunakan untuk mengambil daftar team.
	 *
	 * This function use to get list of team.
	 *
	 * $limit = integer
	 * $order = string
	 * $page = integer from get active page
	*/
	public function getTeam($order)
    {
		$team = $this->core->podb->from('team')
            ->where('active','Y')
			->orderBy('id_team '.$order.'')
			->fetchAll();
		return $team;
    }

	/**
	 * Fungsi ini digunakan untuk membuat nomor halaman pada halaman team
	 *
	 * This function use to create pagination in team page.
	 *
	 * $limit = integer
	 * $page = integer from get active page
	 * $type = 0 or 1
	 * $prev = string previous text
	 * $next = string next text
	*/
	public function getteamPaging($limit, $page, $type, $prev, $next)
    {
		$totaldata = $this->core->podb->from('team')->count();
		$totalpage = $this->core->popaging->totalPage($totaldata, $limit);
		$pagination = $this->core->popaging->navPage($page, $totalpage, BASE_URL, 'team', 'page', $type, $prev, $next);
		return $pagination;
	}

	/**
	 * Fungsi ini digunakan untuk mengambil daftar galeri berdasarkan team.
	 *
	 * This function use to get list of team base on team.
	 *
	 * $limit = integer
	 * $order = string
	*/
    public function getHeadlineteam($limit, $order)
    {
        $team = $this->core->podb->from('team')
            ->where('active','Y')
            ->orderBy($order)
            ->limit($limit)
            ->fetchAll();
        return $team;
    }

}
