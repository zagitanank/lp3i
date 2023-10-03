<?php
/*
 *
 * - Zagitanank Front End File
 *
 * - File : registrasi.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk halaman kontak.
 * This is a php file for handling front end process for registrasi page.
 *
*/

/**
 * Router untuk memproses request $_POST[] komentar.
 *
 * Router for process request $_POST[] comment.
 *
*/
$router->match('GET|POST', '/registrasi', function() use ($core, $templates) {
	$alertmsg = '';
	$lang = $core->setlang('registrasi', WEB_LANG);
	if (!empty($_POST)) {
		$core->poval->validation_rules(array(
			'registrasi_name' => 'required|max_len,100|min_len,3',
			'registrasi_email' => 'required|valid_email',
			'registrasi_subject' => 'required|max_len,255|min_len,6',
			'registrasi_message' => 'required|min_len,10'
		));
		$core->poval->filter_rules(array(
			'registrasi_name' => 'trim|sanitize_string',
			'registrasi_email' => 'trim|sanitize_string',
			'registrasi_subject' => 'trim|sanitize_email',
			'registrasi_message' => 'trim|sanitize_string'
		));
		$validated_data = $core->poval->run($_POST);
		if ($validated_data === false) {
			$alertmsg = '<div id="registrasi-form-result">
				<div class="alert alert-warning" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					'.$lang['front_registrasi_error'].'
				</div>
			</div>';
		} else {
			$data = array(
				'name' => $_POST['registrasi_name'],
				'email' => $_POST['registrasi_email'],
				'subject' => $_POST['registrasi_subject'],
				'message' => $_POST['registrasi_message']
			);
			$query = $core->podb->insertInto('registrasi')->values($data);
			$query->execute();
			unset($_POST);
			$alertmsg = '<div id="registrasi-form-result">
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					'.$lang['front_registrasi_success'].'
				</div>
			</div>';
		}
	}
	$info = array(
		'page_title' => $lang['front_registrasi'],
		'page_desc' => $core->posetting[2]['value'],
		'page_key' => $core->posetting[3]['value'],
		'social_mod' => $lang['front_registrasi'],
		'social_name' => $core->posetting[0]['value'],
		'social_url' => $core->posetting[1]['value'],
		'social_title' => $core->posetting[0]['value'],
		'social_desc' => $core->posetting[2]['value'],
		'social_img' => $core->posetting[1]['value'].'/'.DIR_INC.'/images/favicon.png',
		'alertmsg' => $alertmsg
	);
	$adddata = array_merge($info, $lang);
	$templates->addData(
		$adddata
	);
	echo $templates->render('registrasi', compact('lang'));
});
