<?php
/*
 *
 * - Zagitanank Front End File
 *
 * - File : document.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk halaman kontak.
 * This is a php file for handling front end process for document page.
 *
*/

/**
 * Router untuk memproses request $_POST[] komentar.
 *
 * Router for process request $_POST[] comment.
 *
*/
$router->match('GET|POST', '/document', function() use ($core, $templates) {
	$lang = $core->setlang('document', WEB_LANG);
	$info = array(
		'page_title' => $lang['front_document_title'],
		'page_desc' => $core->posetting[2]['value'],
		'page_key' => $core->posetting[3]['value'],
		'social_mod' => $lang['front_document_title'],
		'social_name' => $core->posetting[0]['value'],
		'social_url' => $core->posetting[1]['value'].'/document',
		'social_title' => $core->posetting[0]['value'],
		'social_desc' => $core->posetting[2]['value'],
		'social_img' => $core->posetting[1]['value'].'/'.DIR_INC.'/images/favicon.png',
		'page' => '1'
	);
	$adddata = array_merge($info, $lang);
	$templates->addData(
		$adddata
	);
	echo $templates->render('document', compact('lang'));
});