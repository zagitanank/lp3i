<?php
/*
 *
 * - PopojiCMS Front End File
 *
 * - File : testimoni.php
 * - Version : 1.0
 * - Author : Jenuar Dalapang
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk halaman testimoni.
 * This is a php file for handling front end process for testimoni page.
 *
*/

/**
 * Router untuk menampilkan request halaman testimoni.
 *
 * Router for display request in testimoni page.
*/
$router->match('GET|POST', '/testimoni', function() use ($core, $templates) {
	$lang = $core->setlang('home', WEB_LANG);
	$info = array(
		'page_title' => 'testimoni',
		'page_desc' => $core->posetting[2]['value'],
		'page_key' => $core->posetting[3]['value'],
		'social_mod' => 'testimoni',
		'social_name' => $core->posetting[0]['value'],
		'social_url' => $core->posetting[1]['value'].'/testimoni',
		'social_title' => $core->posetting[0]['value'],
		'social_desc' => $core->posetting[2]['value'],
		'social_img' => $core->posetting[1]['value'].'/'.DIR_INC.'/images/favicon.png',
		'page' => '1'
	);
	$adddata = array_merge($info, $lang);
	$templates->addData(
		$adddata
	);
	echo $templates->render('testimoni', compact('lang'));
});

/**
 * Router untuk menampilkan request halaman testimoni dengan nomor halaman.
 *
 * Router for display request in testimoni page with pagination.
 *
 * $page = integer
*/
$router->match('GET|POST', '/testimoni/page/(\d+)', function($page) use ($core, $templates) {
	$lang = $core->setlang('home', WEB_LANG);
	$info = array(
		'page_title' => 'testimoni',
		'page_desc' => $core->posetting[2]['value'],
		'page_key' => $core->posetting[3]['value'],
		'social_mod' => 'testimoni',
		'social_name' => $core->posetting[0]['value'],
		'social_url' => $core->posetting[1]['value'].'/testimoni',
		'social_title' => $core->posetting[0]['value'],
		'social_desc' => $core->posetting[2]['value'],
		'social_img' => $core->posetting[1]['value'].'/'.DIR_INC.'/images/favicon.png',
		'page' => $page
	);
	$adddata = array_merge($info, $lang);
	$templates->addData(
		$adddata
	);
	echo $templates->render('testimoni', compact('lang'));
});