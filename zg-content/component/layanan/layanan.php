<?php
/*
 *
 * - Zagitanank Front End File
 *
 * - File : layanan.php
 * - Version : 1.1
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk halaman kategori.
 * This is a php file for handling front end process for layanan page.
 *
*/

/**
 * Router untuk menampilkan request halaman kategori.
 *
 * Router for display request in layanan page.
 *
 * $seotitle = string [a-z0-9_-]
*/
$router->match('GET|POST', '/detaillayanan/([a-z0-9_-]+)', function($seotitle) use ($core, $templates) {
	$lang = $core->setlang('layanan', WEB_LANG);
	$layanan = $core->podb->from('layanan')
				->select(array('layanan_description.title', 'layanan_description.content'))
				->leftJoin('layanan_description ON layanan_description.id_layanan = layanan.id_layanan')
				->where('layanan.seotitle', $seotitle)
				->where('layanan_description.id_language', WEB_LANG_ID)
				->where('layanan.active', 'Y')
				->limit(1)
				->fetch();
	if ($layanan) {
        $query_hits = $core->podb->update('layanan')
			->set(array('hits' => $layanan['hits']+1))
			->where('id_layanan', $layanan['id_layanan']);
		$query_hits->execute();
		$info = array(
			'page_title' => $layanan['title'],
			'page_desc' => $core->postring->cuthighlight('post', $layanan['content'], '60'),
			'page_key' => $layanan['title'],
			'social_mod' => $lang['front_layanan_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'].'/detaillayanan/'.$layanan['seotitle'],
			'social_title' => $layanan['title'],
			'social_desc' => $core->postring->cuthighlight('post', $layanan['content'], '60'),
			'social_img' => $core->posetting[1]['value'].'/'.DIR_CON.'/uploads/'.$layanan['picture']
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('detaillayanan', compact('layanan','lang'));
	} else {
		$info = array(
			'page_title' => $lang['front_layanan_not_found'],
			'page_desc' => $core->posetting[2]['value'],
			'page_key' => $core->posetting[3]['value'],
			'social_mod' => $lang['front_layanan_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'],
			'social_title' => $lang['front_layanan_not_found'],
			'social_desc' => $core->posetting[2]['value'],
			'social_img' => $core->posetting[1]['value'].'/'.DIR_INC.'/images/favicon.png'
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('404', compact('lang'));
	}
});


$router->match('GET|POST', '/layanan/([a-z0-9_-]+)', function($seotitle) use ($core, $templates) {
	$lang = $core->setlang('layanan', WEB_LANG);
	if ($seotitle == 'all') {
		$layanan = array(
			'title' => $lang['front_layanan'],
			'seotitle' => 'all',
			'picture' => ''
		);
	} else {
		$layanan = $core->podb->from('layanan')
			->select(array('layanan_description.title'))
			->leftJoin('layanan_description ON layanan_description.id_layanan = layanan.id_layanan')
			->where('layanan.seotitle', $seotitle)
			->where('layanan_description.id_language', WEB_LANG_ID)
			->where('layanan.active', 'Y')
			->limit(1)
			->fetch();
	}
	if ($layanan) {
		$info = array(
			'page_title' => htmlspecialchars_decode($layanan['title']),
			'page_desc' => $layanan['title'].' - '.$core->posetting[2]['value'],
			'page_key' => $layanan['title'],
			'social_mod' => $lang['front_layanan_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'].'/layanan/'.$layanan['seotitle'],
			'social_title' => htmlspecialchars_decode($layanan['title']),
			'social_desc' => $layanan['title'].' - '.$core->posetting[2]['value'],
			'social_img' => $core->posetting[1]['value'].'/'.DIR_CON.'/uploads/'.$layanan['picture'],
			'page' => '1'
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('layanan', compact('layanan','lang'));
	} else {
		$info = array(
			'page_title' => $lang['front_layanan_not_found'],
			'page_desc' => $core->posetting[2]['value'],
			'page_key' => $core->posetting[3]['value'],
			'social_mod' => $lang['front_layanan_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'],
			'social_title' => $lang['front_layanan_not_found'],
			'social_desc' => $core->posetting[2]['value'],
			'social_img' => $core->posetting[1]['value'].'/'.DIR_INC.'/images/favicon.png'
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('404', compact('lang'));
	}
});

/**
 * Router untuk menampilkan request halaman layanan dengan nomor halaman.
 *
 * Router for display request in layanan page with pagination.
 *
 * $seotitle = string [a-z0-9_-]
 * $page = integer
*/
$router->match('GET|POST', '/layanan/([a-z0-9_-]+)/page/(\d+)', function($seotitle, $page) use ($core, $templates) {
	$lang = $core->setlang('layanan', WEB_LANG);
	if ($seotitle == 'all') {
		$layanan = array(
			'title' => $lang['front_layanan'],
			'seotitle' => 'all',
			'picture' => ''
		);
	} else {
		$layanan = $core->podb->from('layanan')
			->select(array('layanan_description.title'))
			->leftJoin('layanan_description ON layanan_description.id_layanan = layanan.id_layanan')
			->where('layanan.seotitle', $seotitle)
			->where('layanan_description.id_language', WEB_LANG_ID)
			->where('layanan.active', 'Y')
			->limit(1)
			->fetch();
	}
	if ($layanan) {
		$info = array(
			'page_title' => htmlspecialchars_decode($layanan['title']),
			'page_desc' => $layanan['title'].' - '.$core->posetting[2]['value'],
			'page_key' => $layanan['title'],
			'social_mod' => $lang['front_layanan_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'].'/layanan/'.$layanan['seotitle'],
			'social_title' => htmlspecialchars_decode($layanan['title']),
			'social_desc' => $layanan['title'].' - '.$core->posetting[2]['value'],
			'social_img' => $core->posetting[1]['value'].'/'.DIR_CON.'/uploads/'.$layanan['picture'],
			'page' => $page
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('layanan', compact('layanan','lang'));
	} else {
		$info = array(
			'page_title' => $lang['front_layanan_not_found'],
			'page_desc' => $core->posetting[2]['value'],
			'page_key' => $core->posetting[3]['value'],
			'social_mod' => $lang['front_layanan_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'],
			'social_title' => $lang['front_layanan_not_found'],
			'social_desc' => $core->posetting[2]['value'],
			'social_img' => $core->posetting[1]['value'].'/'.DIR_INC.'/images/favicon.png'
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('404', compact('lang'));
	}
});
