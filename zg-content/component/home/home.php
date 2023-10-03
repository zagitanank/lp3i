<?php
/*
 *
 * - Zagitanank Front End File
 *
 * - File : home.php
 * - Version : 1.1
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk halaman home.
 * This is a php file for handling front end process for home page.
 *
*/

/**
 * Router untuk menampilkan request halaman beranda.
 *
 * Router for display request in home page.
 *
 */
$router->match('GET|POST', '/', function () use ($core, $templates) {
	$lang = $core->setlang('home', WEB_LANG);
	$info = array(
		'page_title' => $core->posetting[0]['value'],

		'page_desc' => $core->posetting[2]['value'],
		'page_key' => $core->posetting[3]['value'],
		'social_mod' => $lang['front_home'],
		'social_name' => $core->posetting[0]['value'],
		'social_url' => $core->posetting[1]['value'],
		'social_title' => $core->posetting[0]['value'],
		'social_desc' => $core->posetting[2]['value'],
		'social_img' => $core->posetting[1]['value'] . '/' . DIR_INC . '/images/favicon.png'
	);
	$adddata = array_merge($info, $lang);
	$templates->addData(
		$adddata
	);
	echo $templates->render('home', compact('lang'));
});

$router->match('GET|POST', '/akun/404', function () use ($core, $templates) {
	$lang = $core->setlang('home', WEB_LANG);
	$info = array(
		'page_title' => 'Error 404',
		'social_img' => $core->posetting[1]['value'] . '/' . DIR_INC . '/images/favicon.png',
		'alertmsg' => ""
	);
	$adddata = array_merge($info, $lang);
	$templates->addData(
		$adddata
	);
	echo $templates->render('404', compact('lang'));
});

/**
 * Router untuk menampilkan request halaman member.
 *
 * Router for display request in member page.
 *
 */
$router->match('GET|POST', '/akun', function () use ($core, $templates) {
	// if ($core->posetting[17]['value'] == 'Y') {
		$lang = $core->setlang('home', WEB_LANG);
		$info = array(
			'page_title' => 'Pilih Status',
	
			'page_desc' => $core->posetting[2]['value'],
			'page_key' => $core->posetting[3]['value'],
			'social_mod' => $lang['front_home'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'],
			'social_title' => $core->posetting[0]['value'],
			'social_desc' => $core->posetting[2]['value'],
			'social_img' => $core->posetting[1]['value'] . '/' . DIR_INC . '/images/favicon.png'
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('home', compact('lang'));
});

$router->match('GET|POST', '/akun/404', function () use ($core, $templates) {
	$lang = $core->setlang('home', WEB_LANG);
	$info = array(
		'page_title' => 'Error 404',
		'social_img' => $core->posetting[1]['value'] . '/' . DIR_INC . '/images/favicon.png',
		'alertmsg' => ""
	);
	$adddata = array_merge($info, $lang);
	$templates->addData(
		$adddata
	);
	echo $templates->render('404', compact('lang'));
});


$router->match('GET|POST', '/mahasiswa', function () use ($core, $templates) {
	if ((empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) or (empty($_SESSION['namalengkap_member'])) ) {
			header('location:' . BASE_URL . '/mahasiswa/login');
	} else {
			if($_SESSION['leveluser_member'] == '2'){
				header('location:' . BASE_URL . '/dosen');
			}
			$lang = $core->setlang('home', WEB_LANG);
			$current_ta = $core->mbkmsetting;
			
				
			$user = $core->podb->from('mahasiswa')
						->where('nim', $_SESSION['namauser_member'])
						->limit(1)
						->fetch();
						
			$info = array(
				'page_title' => 'Mahasiswa MBKM',
				'page_name' => 'home',
				'page_desc' => $core->posetting[2]['value'],
				'page_key' => $core->posetting[3]['value'],
				'social_mod' => $lang['front_home'],
				'social_name' => $core->posetting[0]['value'],
				'social_url' => $core->posetting[1]['value'],
				'social_title' => $core->posetting[0]['value'],
				'social_desc' => $core->posetting[2]['value'],
				'social_img' => $core->posetting[1]['value'] . '/' . DIR_INC . '/images/favicon.png',
				'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
			);
			$adddata = array_merge($info, $lang);
			$templates->addData(
				$adddata
			);
			echo $templates->render('home', compact('lang', 'user'));

	}
});



$router->match('GET|POST', '/mahasiswa/login', function () use ($core, $templates) {
	if ((empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) or (empty($_SESSION['namalengkap_member']))) {
			
				$alertmsg = '';
				$lang = $core->setlang('home', WEB_LANG);
				if (!empty($_POST)) {
					$_POST = $core->poval->sanitize($_POST);
					$core->poval->validation_rules(array(
						'username' => 'required|max_len,50|min_len,3',
						'password' => 'required|max_len,50'
					));
					$core->poval->filter_rules(array(
						'username' => 'trim|sanitize_string',
						'password' => 'trim'
					));
					$validated_data = $core->poval->run($_POST);
					if ($validated_data === false) {
						$alertmsg = '<div class="alert alert-danger">' . $lang['front_member_notif_1'] . '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>';
					} else {
						$current_ta = $core->mbkmsetting;
						$cek_mbkm = $core->podb->from('mbkm_peserta')
												->where('nim', $_POST['username'])
												->where('periode', $current_ta['mbkm_jadwal_periode'])
												->count();
												
						if($cek_mbkm > 0){
							$count_user = $core->podb->from('mahasiswa')
								->where('nim', $_POST['username'])
								->where('pwd', md5($_POST['password']))
								->count();
							if ($count_user > 0) {
								$user = $core->podb->from('mahasiswa')
									->where('nim', $core->postring->valid($_POST['username'], 'xss'))
									->where('pwd', md5($_POST['password']))
									->limit(1)
									->fetch();
								$timeout = new PoTimeout;
								$timeout->rec_session_mahasiswa($user);
								$timeout->timer_member();
								if (isset($_POST['rememberme']) || $_POST['rememberme'] == "1") {
									setcookie("member_cookie[username]", $user['username'], time() + 86400);
									setcookie("member_cookie[password]", $user['password'], time() + 86400);
								}
								header('location:' . BASE_URL . '/mahasiswa');
							} else {
								$alertmsg = '<div class="alert alert-danger dark alert-dismissible fade show" role="alert"><i class="fa fa-exclamation-circle"></i>
													<p>Nim atau Kata Sandi Anda Salah !</p>
													<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
												 </div>';
							}
						}else{
							$alertmsg = '<div class="alert alert-warning">Anda tidak Memprogramkan MBKM di Semster ini !<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>';
						}
					}
				}
			
				$info = array(
					'page_title' => 'Login Mahasiswa',
					'page_name' => 'login',
					'page_desc' => $core->posetting[2]['value'],
					'page_key' => $core->posetting[3]['value'],
					'social_mod' => $lang['front_home'],
					'social_name' => $core->posetting[0]['value'],
					'social_url' => $core->posetting[1]['value'],
					'social_desc' => $core->posetting[2]['value'],
					'social_img' => $core->posetting[1]['value'] . '/' . DIR_INC . '/images/favicon.png',
					'alertmsg' => $alertmsg
				);
				$adddata = array_merge($info, $lang);
				$templates->addData(
					$adddata
				);
				echo $templates->render('login', compact('lang'));
			
		} else {
			header('location:' . BASE_URL . '/mahasiswa');
			
			
		}
});
/**
 * Router untuk menampilkan request halaman logout member.
 *
 * Router for display request in logout member page.
 *
 */
$router->match('GET|POST', '/mahasiswa/logout', function () use ($core, $templates) {
	session_destroy();
	header('location:' . BASE_URL . '/akun');
});


//DOSEN

$router->match('GET|POST', '/dosen', function () use ($core, $templates) {
	if ((empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) or (empty($_SESSION['namalengkap_member']))) {
			header('location:' . BASE_URL . '/dosen/login');
	} else {
		
		if($_SESSION['leveluser_member'] == '5'){
				header('location:' . BASE_URL . '/mahasiswa');
			}
		$lang = $core->setlang('home', WEB_LANG);
		$current_ta = $core->mbkmsetting;

		$user = $core->podb->from('dosen')
				->where('kode_nama', $_SESSION['namauser_member'])
				->limit(1)
				->fetch();
					
		$info = array(
			'page_title' => 'DPL MBKM',
			'page_name' => 'home',
			'page_desc' => $core->posetting[2]['value'],
			'page_key' => $core->posetting[3]['value'],
			'social_mod' => $lang['front_home'],
			'social_name' => $core->posetting[0]['value'],
			'social_url' => $core->posetting[1]['value'],
			'social_title' => $core->posetting[0]['value'],
			'social_desc' => $core->posetting[2]['value'],
			'social_img' => $core->posetting[1]['value'] . '/' . DIR_INC . '/images/favicon.png',
			'foto_user' => $user['file'],
			'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('home', compact('lang', 'user'));
	}
});



$router->match('GET|POST', '/dosen/login', function () use ($core, $templates) {
	if ((empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) or (empty($_SESSION['namalengkap_member']))) {
			
				$alertmsg = '';
				$lang = $core->setlang('home', WEB_LANG);
				if (!empty($_POST)) {
					$_POST = $core->poval->sanitize($_POST);
					$core->poval->validation_rules(array(
						'username' => 'required|max_len,50|min_len,3',
						'password' => 'required|max_len,50'
					));
					$core->poval->filter_rules(array(
						'username' => 'trim|sanitize_string',
						'password' => 'trim'
					));
					$validated_data = $core->poval->run($_POST);
					if ($validated_data === false) {
						$alertmsg = '<div class="alert alert-danger">' . $lang['front_member_notif_1'] . '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>';
					} else {
							$current_ta = $core->mbkmsetting;
							$cek_mbkm = $core->podb->from('mbkm_dpl_kelas')
											   ->where('kode_dosen', $_POST['username'])
											   ->where('periode_krs', $current_ta['mbkm_jadwal_periode'])
											   ->count();

							if($cek_mbkm > 0){				   
								$count_user = $core->podb->from('dosen')
											->where('kode_nama', $_POST['username'])
											->where('pwd', md5($_POST['password']))
											->count();
								if ($count_user > 0) {
									$user = $core->podb->from('dosen')
														->where('kode_nama', $_POST['username'])
														->where('pwd', md5($_POST['password']))
														->limit(1)
														->fetch();
									$timeout = new PoTimeout;
									$timeout->rec_session_dosen($user);
									$timeout->timer_member();
									if (isset($_POST['rememberme']) || $_POST['rememberme'] == "1") {
										setcookie("member_cookie[username]", $user['username'], time() + 86400);
										setcookie("member_cookie[password]", $user['password'], time() + 86400);
									}
									header('location:' . BASE_URL . '/dosen');
								} else {
									$alertmsg = '<div class="alert alert-danger dark alert-dismissible fade show" role="alert"><i class="fa fa-exclamation-circle"></i>
														<p>Kode dosen atau Kata Sandi Anda Salah !</p>
														<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
													</div>';
								}
							}else{
								$alertmsg = '<div class="alert alert-warning">Anda bukan DPL di Semester ini !<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>';
							}
						
					}
				}
			
				$info = array(
					'page_title' => 'Login DPL',
					'page_name' => 'login',
					'page_desc' => $core->posetting[2]['value'],
					'page_key' => $core->posetting[3]['value'],
					'social_mod' => $lang['front_home'],
					'social_name' => $core->posetting[0]['value'],
					'social_url' => $core->posetting[1]['value'],
					'social_desc' => $core->posetting[2]['value'],
					'social_img' => $core->posetting[1]['value'] . '/' . DIR_INC . '/images/favicon.png',
					'alertmsg' => $alertmsg
				);
				$adddata = array_merge($info, $lang);
				$templates->addData(
					$adddata
				);
				echo $templates->render('login', compact('lang'));
			
		} else {
			
			header('location:' . BASE_URL . '/dosen');
		}
});
/**
 * Router untuk menampilkan request halaman logout member.
 *
 * Router for display request in logout member page.
 *
 */
$router->match('GET|POST', '/dosen/logout', function () use ($core, $templates) {
	session_destroy();
	header('location:' . BASE_URL . '/akun');
});