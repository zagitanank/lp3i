<?php
/*
 *
 * - Zagitanank Front End File
 *
 * - File : program.php
 * - Version : 1.1
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk halaman kategori.
 * This is a php file for handling front end process for program page.
 *
*/

/**
 * Router untuk menampilkan request halaman kategori.
 *
 * Router for display request in program page.
 *
 * $seotitle = string [a-z0-9_-]
*/
$router->match('GET|POST', '/detailprogram/([a-z0-9_-]+)', function($seotitle) use ($core, $templates) {
	$lang = $core->setlang('program', WEB_LANG);
	$program = $core->podb->from('program')
				->select(array('program_description.title', 'program_description.content'))
				->leftJoin('program_description ON program_description.id_program = program.id_program')
				->where('program.seotitle', $seotitle)
				->where('program_description.id_language', WEB_LANG_ID)
				->where('program.active', 'Y')
				->limit(1)
				->fetch();
	if ($program) {
        $query_hits = $core->podb->update('program')
			->set(array('hits' => $program['hits']+1))
			->where('id_program', $program['id_program']);
		$query_hits->execute();
		$info = array(
			'page_title' => $program['title'],
			'page_desc' => $core->postring->cuthighlight('post', $program['content'], '60'),
			'page_key' => $program['title'],
			'social_mod' => $lang['front_program_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'].'/detailprogram/'.$program['seotitle'],
			'social_title' => $program['title'],
			'social_desc' => $core->postring->cuthighlight('post', $program['content'], '60'),
			'social_img' => $core->posetting[1]['value'].'/'.DIR_CON.'/uploads/'.$program['picture']
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('detailprogram', compact('program','lang'));
	} else {
		$info = array(
			'page_title' => $lang['front_program_not_found'],
			'page_desc' => $core->posetting[2]['value'],
			'page_key' => $core->posetting[3]['value'],
			'social_mod' => $lang['front_program_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'],
			'social_title' => $lang['front_program_not_found'],
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


$router->match('GET|POST', '/program/([a-z0-9_-]+)', function($seotitle) use ($core, $templates) {
	$lang = $core->setlang('program', WEB_LANG);
	if ($seotitle == 'all') {
		$program = array(
			'title' => $lang['front_program'],
			'seotitle' => 'all',
			'picture' => ''
		);
	} else {
		$program = $core->podb->from('program')
			->select(array('program_description.title'))
			->leftJoin('program_description ON program_description.id_program = program.id_program')
			->where('program.seotitle', $seotitle)
			->where('program_description.id_language', WEB_LANG_ID)
			->where('program.active', 'Y')
			->limit(1)
			->fetch();
	}
	if ($program) {
		$info = array(
			'page_title' => htmlspecialchars_decode($program['title']),
			'page_desc' => $program['title'].' - '.$core->posetting[2]['value'],
			'page_key' => $program['title'],
			'social_mod' => $lang['front_program_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'].'/program/'.$program['seotitle'],
			'social_title' => htmlspecialchars_decode($program['title']),
			'social_desc' => $program['title'].' - '.$core->posetting[2]['value'],
			'social_img' => $core->posetting[1]['value'].'/'.DIR_CON.'/uploads/'.$program['picture'],
			'page' => '1'
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('program', compact('program','lang'));
	} else {
		$info = array(
			'page_title' => $lang['front_program_not_found'],
			'page_desc' => $core->posetting[2]['value'],
			'page_key' => $core->posetting[3]['value'],
			'social_mod' => $lang['front_program_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'],
			'social_title' => $lang['front_program_not_found'],
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
 * Router untuk menampilkan request halaman program dengan nomor halaman.
 *
 * Router for display request in program page with pagination.
 *
 * $seotitle = string [a-z0-9_-]
 * $page = integer
*/
$router->match('GET|POST', '/program/([a-z0-9_-]+)/page/(\d+)', function($seotitle, $page) use ($core, $templates) {
	$lang = $core->setlang('program', WEB_LANG);
	if ($seotitle == 'all') {
		$program = array(
			'title' => $lang['front_program'],
			'seotitle' => 'all',
			'picture' => ''
		);
	} else {
		$program = $core->podb->from('program')
			->select(array('program_description.title'))
			->leftJoin('program_description ON program_description.id_program = program.id_program')
			->where('program.seotitle', $seotitle)
			->where('program_description.id_language', WEB_LANG_ID)
			->where('program.active', 'Y')
			->limit(1)
			->fetch();
	}
	if ($program) {
		$info = array(
			'page_title' => htmlspecialchars_decode($program['title']),
			'page_desc' => $program['title'].' - '.$core->posetting[2]['value'],
			'page_key' => $program['title'],
			'social_mod' => $lang['front_program_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'].'/program/'.$program['seotitle'],
			'social_title' => htmlspecialchars_decode($program['title']),
			'social_desc' => $program['title'].' - '.$core->posetting[2]['value'],
			'social_img' => $core->posetting[1]['value'].'/'.DIR_CON.'/uploads/'.$program['picture'],
			'page' => $page
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('program', compact('program','lang'));
	} else {
		$info = array(
			'page_title' => $lang['front_program_not_found'],
			'page_desc' => $core->posetting[2]['value'],
			'page_key' => $core->posetting[3]['value'],
			'social_mod' => $lang['front_program_title'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'],
			'social_title' => $lang['front_program_not_found'],
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
