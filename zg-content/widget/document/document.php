<?php
/*
 *
 * - Zagitanank document File
 *
 * - File : document.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk document document.
 * This is a php file for handling front end process for document document.
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
 * Mendeklarasikan class document diharuskan dengan mengimplementasikan class ExtensionInterface (diharuskan).
 *
 * Declaration document class must with implements ExtensionInterface class (require).
 *
*/
class Document implements ExtensionInterface
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
	 * Fungsi ini digunakan untuk mendaftarkan semua fungsi document (diharuskan).
	 *
	 * This function use to register all document function (require).
	 *
	*/
    public function register(Engine $templates)
    {
        $templates->registerFunction('document', [$this, 'getObject']);
    }

	/**
	 * Fungsi ini digunakan untuk menangkap semua fungsi document (diharuskan).
	 *
	 * This function use to catch all document function (require).
	 *
	*/
    public function getObject()
    {
        return $this;
    }

	/**
	 * Fungsi ini digunakan untuk mengambil daftar semua document.
	 *
	 * This function use to get all list of document.
	 *
	 * $order = string
	 * $limit = integer
     * $lang = string
	*/
	public function getDocument($order, $lang)
    {
		$document = $this->core->podb->from('document')
			->select(array('document_description.title'))
			->leftJoin('document_description ON document_description.id_document = document.id_document')
			->where('document_description.id_language', $lang)
            ->where('document.active', 'Y')
			->orderBy('document.id_document '.$order.'')
			->fetchAll();
        return $document;
    }

	/**
	 * Fungsi ini digunakan untuk mengambil daftar kategori berdasarkan id_post.
	 *
	 * This function use to get list of category base on id_post.
	 *
	 * $id_document = integer
	 * $lang = WEB_LANG_ID
	 * $link = boolean
	*/
    public function getDocCategory($id_document, $lang)
    {
		$doc_cats = $this->core->podb->from('document_category')
			->where('id_document', $id_document)
			->fetchAll();
		$category = '';
		foreach($doc_cats as $doc_cat){
			$categorys = $this->core->podb->from('category_document')
				->select('category_document_description.title')
				->leftJoin('category_document_description ON category_document_description.id_category_document = category_document.id_category_document')
				->where('category_document.id_category_document', $doc_cat['id_category_document'])
				->where('category_document_description.id_language', $lang)
				->where('category_document.active', 'Y')
				->limit(1)
				->fetch();
		$category .= $categorys['title'];
		}
        return $category;
    }

	/**
	 * Fungsi ini digunakan untuk membuat nomor halaman pada halaman category
	 *
	 * This function use to create pagination in category page.
	 *
	 * $limit = integer
	 * $page = integer from get active page
	 * $type = 0 or 1
	 * $prev = string previous text
	 * $next = string next text
	*/
	public function getCategoryPaging($limit, $page, $type, $prev, $next)
    {
		$totaldata = $this->core->podb->from('document_category')->where('active', 'Y')->count();
		$totalpage = $this->core->popaging->totalPage($totaldata, $limit);
		$pagination = $this->core->popaging->navPage($page, $totalpage, BASE_URL, 'cdocument', 'page', $type, $prev, $next);
		return $pagination;
	}

    
    /**
	 * Fungsi ini digunakan untuk menghitung daftar document berdasarkan category.
	 *
	 * This function use to count list of document base on category.
	 *
	 * $category = array of category
	*/
    public function Countdocument($category)
    {
		//$offset = $this->core->popaging->searchPosition($limit, $page);
        
		$count = $this->core->podb->from('document')
			->where('id_cdocument', $category)
			->count();
		return $count;
        
    }
    
	/**
	 * Fungsi ini digunakan untuk membuat nomor halaman pada halaman document
	 *
	 * This function use to create pagination in document page.
	 *
	 * $limit = integer
	 * $category = array of category
	 * $page = integer from get active page
	 * $type = 0 or 1
	 * $prev = string previous text
	 * $next = string next text
	*/
	public function getdocumentPaging($limit, $category, $page, $type, $prev, $next)
    {
		$totaldata = $this->core->podb->from('document')->where('id_cdocument', $category['id_cdocument'])->count();
		$totalpage = $this->core->popaging->totalPage($totaldata, $limit);
		$pagination = $this->core->popaging->navPage($page, $totalpage, BASE_URL, 'document/'.$category['seotitle'], 'page', $type, $prev, $next);
		return $pagination;
	}

}
