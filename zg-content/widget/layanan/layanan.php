<?php
/*
 *
 * - Zagitanank Widget File
 *
 * - File : layanan.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk widget galeri.
 * This is a php file for handling front end process for layanan widget.
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
class layanan implements ExtensionInterface
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
        $templates->registerFunction('layanan', [$this, 'getObject']);
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
	 * Fungsi ini digunakan untuk mengambil daftar layanan.
	 *
	 * This function use to get list of layanan.
	 *
	 * $limit = integer
	 * $order = string ASC or DESC
	 * $lang = WEB_LANG_ID
	*/
	public function getRecentlayanan($limit, $order, $lang)
    {
		$layanan = $this->core->podb->from('layanan')
			->select(array('layanan_description.title', 'layanan_description.content'))
			->leftJoin('layanan_description ON layanan_description.id_layanan = layanan.id_layanan')
			->where('layanan_description.id_language', $lang)
			->where('layanan.active', 'Y')
			->where('layanan.publishdate < ?', date('Y-m-d H:i:s'))
			->orderBy('layanan.id_layanan '.$order.'')
			->limit($limit)
			->fetchAll();
        return $layanan;
    }
    
    /**
	 * Fungsi ini digunakan untuk mengambil data author.
	 *
	 * This function use to get author data.
	 *
	 * $id_user = integer
	*/
	public function getAuthor($id_user)
    {
		$author = $this->core->podb->from('users')
			->select(array('username', 'nama_lengkap', 'email', 'no_telp', 'bio', 'picture'))
			->where('id_user', $id_user)
			->limit(1)
			->fetch();
        return $author;
    }

	/**
	 * Fungsi ini digunakan untuk mengambil nama author.
	 *
	 * This function use to get author name.
	 *
	 * $id_user = integer
	*/
	public function getAuthorName($id_user)
    {
		$author = $this->core->podb->from('users')
			->select(array('nama_lengkap', 'email', 'no_telp', 'bio', 'picture'))
			->where('id_user', $id_user)
			->limit(1)
			->fetch();
        return $author['nama_lengkap'];
    }
    
    /**
	 * Fungsi ini digunakan untuk menampilkan jumlah byte ke string.
	 *
	 * This function is used to display byte total to string.
	 *
	*/
	public function bytes_to_string($size, $precision = 0)
	{
		$sizes = array('YB', 'ZB', 'EB', 'PB', 'TB', 'GB', 'MB', 'KB', 'bytes');
		$total = count($sizes);
		while($total-- && $size > 1024) $size /= 1024;
		$return = round($size, $precision).' '.$sizes[$total];
		return $return;
	}
    
    public function DownloadFile($file) { // $file = include path
        if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }

    }

	/**
	 * Fungsi ini digunakan untuk mengambil daftar layanan.
	 *
	 * This function use to get list of layanan.
	 *
	 * $limit = integer
	 * $order = string
	 * $page = integer from get active page
	*/
	public function getlayanan($limit, $order='id_layanan DESC', $page)
    {
		$offset = $this->core->popaging->searchPosition($limit, $page);
		$layanan = $this->core->podb->from('layanan')
			->orderBy($order)
			->limit($offset.','.$limit)
			->fetchAll();
		return $layanan;
    }

	/**
	 * Fungsi ini digunakan untuk membuat nomor halaman pada halaman layanan
	 *
	 * This function use to create pagination in layanan page.
	 *
	 * $limit = integer
	 * $page = integer from get active page
	 * $type = 0 or 1
	 * $prev = string previous text
	 * $next = string next text
	*/
	public function getlayananPaging($limit, $page, $type, $prev, $next)
    {
		$totaldata = $this->core->podb->from('layanan')->count();
		$totalpage = $this->core->popaging->totalPage($totaldata, $limit);
		$pagination = $this->core->popaging->navPage($page, $totalpage, BASE_URL, 'layanan', 'page', $type, $prev, $next);
		return $pagination;
	}

	/**
	 * Fungsi ini digunakan untuk mengambil daftar galeri berdasarkan layanan.
	 *
	 * This function use to get list of layanan base on album.
	 *
	 * $limit = integer
	 * $order = string
	*/
    public function getHeadlinelayanan($limit, $order)
    {
        $layanan = $this->core->podb->from('layanan')
            ->where('headline','Y')
            ->orderBy($order)
            ->limit($limit)
            ->fetchAll();
        return $layanan;
    }

}
