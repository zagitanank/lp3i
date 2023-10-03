<?php
/*
 *
 * - Zagitanank Front End File
 *
 * - File : user.php
 * - Version : 1.1
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk halaman camaba.
 * This is a php file for handling front end process for camaba page.
 *
*/


/**
 * Router untuk menampilkan request halaman formulir.
 *
 * Router for display request in formulir page.
 *
 */
$router->match(
	'GET|POST',
	'/mahasiswa/profile',
	function () use ($core, $templates) {
		if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
			header('location:' . BASE_URL . '/mahasiswa/login');
		} else {
			if($_SESSION['leveluser_member'] != '5'){
				header('location:' . BASE_URL . '/dosen/profile');
			}
			$alertmsg = '';
			$lang = $core->setlang('user', WEB_LANG);

			$user = $core->podb->from('mahasiswa')
					->where('nim', $_SESSION['namauser_member'])
					->where('pwd', $_SESSION['passuser_member'])
					->limit(1)
					->fetch();

			$current_ta = $core->mbkmsetting;
			$info = array(
				'page_title' => 'Mahasiswa MBKM',
				'alertmsg' => $alertmsg,
				'page_name' => 'profile',
				'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
			);
			$adddata = array_merge($info, $lang);
			$templates->addData(
				$adddata
			);
			echo $templates->render('profile', compact('lang', 'user'));
		}
	}
);

$router->match('GET|POST','/mahasiswa/logbook',function () use ($core, $templates) {
		if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
			header('location:' . BASE_URL . '/mahasiswa/login');
		} else {
			if($_SESSION['leveluser_member'] != 5){
				header('location:' . BASE_URL . '/dosen/logbook');
			}
			$alertmsg = '';
			$lang = $core->setlang('user', WEB_LANG);
			
			$user = $core->podb->from('mahasiswa')
					->where('nim', $_SESSION['namauser_member'])
					->where('pwd', $_SESSION['passuser_member'])
					->limit(1)
					->fetch();

			$current_ta = $core->mbkmsetting;
			$info = array(
				'page_title' => 'SIM MBKM',
				'alertmsg' => $alertmsg,
				'page_name' => 'logbook',
				'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
			);
			$adddata = array_merge($info, $lang);
			$templates->addData(
				$adddata
			);
			echo $templates->render('logbook', compact('lang', 'user'));
		}
	}
);


$router->match('GET|POST','/mahasiswa/logbook/add',function () use ($core, $templates) {
	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
		header('location:' . BASE_URL . '/mahasiswa/login');
	} else {
		if($_SESSION['leveluser_member'] != 5){
			header('location:' . BASE_URL . '/dosen/logbook');
		}
		$alertmsg = '';
		$lang = $core->setlang('user', WEB_LANG);
		$current_ta = $core->mbkmsetting;
		
			$user = $core->podb->from('mahasiswa')
				->where('nim', $_SESSION['namauser_member'])
				->where('pwd', $_SESSION['passuser_member'])
				->limit(1)
				->fetch();

			
				if (!empty($_POST)) {

					$dpl = $core->podb->from('mbkm_dpl_kelas_peserta')
									  ->select('id_kelas_dpl')
									  ->where('nim', $_SESSION['namauser_member'])
									  ->where('periode_krs', $current_ta['mbkm_jadwal_periode'])
									  ->limit(1)
									  ->fetch();


						if(!empty($_FILES)){
							

							$lengthrand = 40;
							$randomStringKode_1 = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $lengthrand);
							$randomStringKode_2 = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $lengthrand);
							$randomStringKode_3 = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $lengthrand);

								$upload 	  = new PoUpload($_FILES['img_one']);
								$upload_two   = new PoUpload($_FILES['img_two']);
								$upload_three = new PoUpload($_FILES['img_three']);
								if ($upload->uploaded || $upload_two->uploaded || $upload_three->uploaded) {
									$upload->file_new_name_body = $randomStringKode_1;
									$upload->process(DIR_CON.'/logbook/');

									$upload_two->file_new_name_body = $randomStringKode_2;
									$upload_two->process(DIR_CON.'/logbook/');

									$upload_three->file_new_name_body = $randomStringKode_3;
									$upload_three->process(DIR_CON.'/logbook/');
									
									if ($upload->processed || $upload_two->processed || $upload_three->processed) {
										$datapic = array(
											'logbook_deskripsi_kegiatan_foto_1' => $upload->file_dst_name,
											'logbook_deskripsi_kegiatan_foto_2' => $upload_two->file_dst_name,
											'logbook_deskripsi_kegiatan_foto_3' => $upload_three->file_dst_name
										);
									} else {
										$datapic = array(
											'logbook_deskripsi_kegiatan_foto_1' => '',
											'logbook_deskripsi_kegiatan_foto_2' => '',
											'logbook_deskripsi_kegiatan_foto_3' => ''
										);
									}
								}
						} else {
							$datapic = array(
								'logbook_deskripsi_kegiatan_foto_1' => '',
								'logbook_deskripsi_kegiatan_foto_2' => '',
								'logbook_deskripsi_kegiatan_foto_3' => ''
							);
						}

						$data = array(
							'logbook_periode_akademik' => $current_ta['mbkm_jadwal_periode'],
							'logbook_mahasiswa_id' => $_SESSION['iduser_member'],
							'logbook_nim' => $_SESSION['namauser_member'],
							'logbook_dpl_kelas_id' => $dpl['id_kelas_dpl'],
							'logbook_tanggal_kegiatan' => $_POST['tanggal_kegiatan'],
							'logbook_jam_kerja_awal' => $_POST['jam_awal'],
							'logbook_jam_kerja_akhir' => $_POST['jam_akhir'],
							'logbook_deskripsi_kegiatan_1' => $_POST['deskripsi_1'],
							'logbook_deskripsi_kegiatan_2' => $_POST['deskripsi_2'],
							'logbook_deskripsi_kegiatan_3' => $_POST['deskripsi_3'],
							'logbook_tanggal_created' => date('Y-m-d H:i:s'),
						);

						$datafinal = array_merge($data, $datapic);
						$query_post = $core->podb->insertInto('mbkm_logbook')->values($datafinal);
						$query_post->execute();


					unset($_POST);
					
					header('location:'.BASE_URL.'/mahasiswa/logbook');
				
			}

		
		
		$info = array(
			'page_title' => 'SIM MBKM',
			'alertmsg' => $alertmsg,
			'page_name' => 'logbook',
			'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('logbookadd', compact('lang', 'user'));
	}
}

);



$router->match('GET|POST','/mahasiswa/logbook/edit/(.*)',function ($id) use ($core, $templates) {
	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
		header('location:' . BASE_URL . '/mahasiswa/login');
	} else {
		if($_SESSION['leveluser_member'] != 5){
				header('location:' . BASE_URL . '/dosen/logbook');
			}
		$alertmsg = '';
		$lang = $core->setlang('user', WEB_LANG);
		$current_ta = $core->mbkmsetting;
		
		

			if(!empty($_FILES)){

				$current_foto = $core->podb->from('mbkm_logbook')
									->where('logbook_id', $core->decrypt($id))
									->limit(1)
									->fetch();

				if(!empty($_FILES['img_one']['tmp_name'])){

					if (!empty($current_foto['logbook_deskripsi_kegiatan_foto_1'])){
						unlink(DIR_CON.'/logbook'.'/'.$current_foto['logbook_deskripsi_kegiatan_foto_1']);
					}
					$lengthrand = 40;
					$randomStringKode = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $lengthrand);
					$upload = new PoUpload($_FILES['img_one']);
					if ($upload->uploaded) {
						$upload->file_new_name_body = $randomStringKode;
						$upload->process(DIR_CON.'/logbook'.'/');
						if ($upload->processed) {
							$gambar = array(
								'logbook_deskripsi_kegiatan_foto_1' => $upload->file_dst_name
							);
							$query_gambar = $core->podb->update('mbkm_logbook')
								->set($gambar)
								->where('logbook_id',$core->decrypt($id));
							$query_gambar->execute();
							
							$upload->clean();
						}
					}

				}

				if(!empty($_FILES['img_two']['tmp_name'])){

					if (!empty($current_foto['logbook_deskripsi_kegiatan_foto_2'])){
						unlink(DIR_CON.'/logbook'.'/'.$current_foto['logbook_deskripsi_kegiatan_foto_2']);
					}
					$lengthrand = 40;
					$randomStringKode = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $lengthrand);
					
					$upload_two   = new PoUpload($_FILES['img_two']);
					if ($upload_two->uploaded) {
						$upload_two->file_new_name_body = $randomStringKode;
						$upload_two->process(DIR_CON.'/logbook'.'/');
						if ($upload_two->processed) {
							$gambar = array(
								'logbook_deskripsi_kegiatan_foto_2' => $upload_two->file_dst_name
							);
							$query_gambar = $core->podb->update('mbkm_logbook')
								->set($gambar)
								->where('logbook_id', $core->decrypt($id));
							$query_gambar->execute();
							$upload_two->clean();
						}
					}

				}


				if(!empty($_FILES['img_three']['tmp_name'])){

					if (!empty($current_foto['logbook_deskripsi_kegiatan_foto_3'])){
						unlink(DIR_CON.'/logbook'.'/'.$current_foto['logbook_deskripsi_kegiatan_foto_3']);
					}
					$lengthrand = 40;
					$randomStringKode = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $lengthrand);
					$upload_three = new PoUpload($_FILES['img_three']);
					if ($upload_three->uploaded) {
						$upload_three->file_new_name_body = $randomStringKode;
						$upload_three->process(DIR_CON.'/logbook'.'/');
						if ($upload_three->processed) {
							$gambar = array(
								'logbook_deskripsi_kegiatan_foto_3' => $upload_three->file_dst_name
							);
							$query_gambar = $core->podb->update('mbkm_logbook')
								->set($gambar)
								->where('logbook_id', $core->decrypt($id));
							$query_gambar->execute();
							$upload_three->clean();
						}
					}

				}

			}
			
				if (!empty($_POST)) {

					$dpl = $core->podb->from('mbkm_dpl_kelas_peserta')
									  ->select('id_kelas_dpl')
									  ->where('nim', $_SESSION['namauser_member'])
									  ->where('periode_krs', $current_ta['mbkm_jadwal_periode'])
									  ->limit(1)
									  ->fetch();

						$data = array(
							'logbook_dpl_kelas_id' => $dpl['id_kelas_dpl'],
							'logbook_tanggal_kegiatan' => $_POST['tanggal_kegiatan'],
							'logbook_jam_kerja_awal' => $_POST['jam_awal'],
							'logbook_jam_kerja_akhir' => $_POST['jam_akhir'],
							'logbook_deskripsi_kegiatan_1' => $_POST['deskripsi_1'],
							'logbook_deskripsi_kegiatan_2' => $_POST['deskripsi_2'],
							'logbook_deskripsi_kegiatan_3' => $_POST['deskripsi_3'],
							'logbook_tanggal_update' => date('Y-m-d H:i:s')
						);

						$query_post = $core->podb->update('mbkm_logbook')->set($data)->where('logbook_id', $core->decrypt($id));
						$query_post->execute();

						// if($query_post->execute()){
						// 	$alertmsg = '<div class="alert alert-success">Berhasil... Data Anda telah tersimpan. <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>';
						// 	// $alertmsg = '<div class="card-body live-dark">
						// 	// 		<div class="alert alert-success -dark light alert-dismissible fade show text-dark border-left-wrapper" role="alert"><i data-feather="help-circle"></i>
						// 	// 		<p>Berhasil... Data Anda telah diupdate.</p>
						// 	// 		<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
						// 	// 		</div>
						// 	// 	</div>';
						// }else{
						// 	$alertmsg = '<div class="alert alert-danger">Gagal... menyimpan data. <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>';
						// 	// $alertmsg = '<div class="card-body live-dark">
						// 	// 		<div class="alert alert-danger-dark light alert-dismissible fade show text-dark border-left-wrapper" role="alert"><i data-feather="help-circle"></i>
						// 	// 		<p>Gagal terupdate... Silahkan melengkapi semua data.</p>
						// 	// 		<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
						// 	// 		</div>
						// 	// 	</div>';
						// }
						
						$alertmsg = '<div class="alert alert-success -dark light alert-dismissible fade show text-dark border-left-wrapper" role="alert"><i data-feather="help-circle"></i>
						<p>Berhasil... Data Anda telah diupdate.</p>
						<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>';
					unset($_POST);
					
					header('location:'.BASE_URL.'/mahasiswa/logbook/edit/'.$id);
				
			}

		
		$user = $core->podb->from('mbkm_logbook')
				->where('logbook_id', $core->decrypt($id))
				->limit(1)
				->fetch();
		
		$info = array(
			'page_title' => 'SIM MBKM',
			'alertmsg' => $alertmsg,
			'page_name' => 'logbook',
			'tahun_akademik' => $current_ta['mbkm_jadwal_periode'],
			'id' => $id
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('logbookedit', compact('lang', 'user'));
	}
}
);


$router->match('GET|POST', '/mahasiswa/logbook/delete', function() use ($core, $templates) {
    	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
			header('location:' . BASE_URL . '/mahasiswa/login');
		} else {
			if($_SESSION['leveluser_member'] != 5){
				header('location:' . BASE_URL . '/dosen/logbook');
			}
            if (!empty($_POST)) {
    			$query_logbook = $core->podb->deleteFrom('mbkm_logbook')->where('logbook_id', $core->decrypt($_POST['id']));
    			$query_logbook->execute();
    			header('location:'.BASE_URL.'/mahasiswa/logbook');
            
            } else {
				header('location:'.BASE_URL.'/404.php');
			}
		}
});



$router->match('GET|POST','/mahasiswa/penilaian-mingguan',function () use ($core, $templates) {
	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
		header('location:' . BASE_URL . '/mahasiswa/login');
	} else {
		if($_SESSION['leveluser_member'] != 5){
			header('location:' . BASE_URL . '/dosen');
		}
		$alertmsg = '';
		$lang = $core->setlang('user', WEB_LANG);
		$current_ta = $core->mbkmsetting;

		
		$info = array(
				'page_title' => 'SIM MBKM',
				'alertmsg' => $alertmsg,
				'page_name' => 'penilaian',
				'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('penilaian-mingguan', compact('lang', 'user'));
	}
}
);


$router->match('GET|POST','/mahasiswa/laporanakhir',function () use ($core, $templates) {
	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
		header('location:' . BASE_URL . '/mahasiswa/login');
	} else {
		if($_SESSION['leveluser_member'] != 5){
			header('location:' . BASE_URL . '/dosen');
		}
		$alertmsg = '';
		$lang = $core->setlang('user', WEB_LANG);
		$current_ta = $core->mbkmsetting;

		
		$info = array(
				'page_title' => 'SIM MBKM',
				'alertmsg' => $alertmsg,
				'page_name' => 'logbook',
				'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('laporanakhir', compact('lang', 'user'));
	}
}
);


$router->match('GET|POST','/mahasiswa/kelas',function () use ($core, $templates) {
	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
		header('location:' . BASE_URL . '/mahasiswa/login');
	} else {
		if($_SESSION['leveluser_member'] != '5'){
			header('location:' . BASE_URL . '/dosen');
		}
		$alertmsg = '';
		$lang = $core->setlang('user', WEB_LANG);
		$current_ta = $core->mbkmsetting;
				
		$kelas = $core->podb->from('mbkm_dpl_kelas_peserta')
				->select('mbkm_dpl_kelas_peserta.nim,mbkm_dpl_kelas.*')
				->leftJoin('mbkm_dpl_kelas ON mbkm_dpl_kelas.id=mbkm_dpl_kelas_peserta.id_kelas_dpl')
				->where('mbkm_dpl_kelas.periode_krs', $current_ta['mbkm_jadwal_periode'])
				->where('mbkm_dpl_kelas_peserta.nim', $_SESSION['namauser_member'])
				->limit(1)
				->fetch();
				$info = array(
					'page_title' => 'SIM MBKM',
					'alertmsg' => $alertmsg,
					'page_name' => 'kelas',
					'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
				);
				$adddata = array_merge($info, $lang);
				$templates->addData(
					$adddata
				);
				echo $templates->render('kelas', compact('lang', 'kelas'));

		
	}
}
);


$router->match('GET|POST','/dosen/kelas',function () use ($core, $templates) {
	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
		header('location:' . BASE_URL . '/dosen/login');
	} else {
		if($_SESSION['leveluser_member'] != '2'){
			header('location:' . BASE_URL . '/mahasiswa');
		}
		$alertmsg = '';
		$lang = $core->setlang('user', WEB_LANG);

		$user = $core->podb->from('dosen')
				->where('kode_nama', $_SESSION['namauser_member'])
				->limit(1)
				->fetch();
				$current_ta = $core->mbkmsetting;
				$info = array(
					'page_title' => 'SIM MBKM',
					'alertmsg' => $alertmsg,
					'page_name' => 'kelas',
					'foto_user' => $user['file'],
					'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
				);
				$adddata = array_merge($info, $lang);
				$templates->addData(
					$adddata
				);
				echo $templates->render('kelas', compact('lang', 'user'));

		
	}
}
);

$router->match('GET|POST','/dosen/kelas/peserta/(.*)',function ($id) use ($core, $templates) {
	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
		header('location:' . BASE_URL . '/dosen/login');
	} else {
		if($_SESSION['leveluser_member'] != '2'){
			header('location:' . BASE_URL . '/mahasiswa');
		}
		$alertmsg = '';
		$lang = $core->setlang('user', WEB_LANG);
		$current_ta = $core->mbkmsetting;
		
		$user = $core->podb->from('mbkm_dpl_kelas')
				->where('id', $core->decrypt($id))
				->limit(1)
				->fetch();
		
		$info = array(
			'page_title' => 'SIM MBKM',
			'page_name' => 'kelas',
			'tahun_akademik' => $current_ta['mbkm_jadwal_periode'],
			'id' => $id
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('kelasdetail', compact('lang', 'user'));
	}
}
);

$router->match('GET|POST','/dosen/logbook',function () use ($core, $templates) {
		if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
			header('location:' . BASE_URL . '/dosen/login');
		} else {
			if($_SESSION['leveluser_member'] != '2'){
				header('location:' . BASE_URL . '/mahasiswa/logbook');
			}
			$alertmsg = '';
			$lang = $core->setlang('user', WEB_LANG);
			
			$user = $core->podb->from('dosen')
					->where('kode_nama', $_SESSION['namauser_member'])
					->where('pwd', $_SESSION['passuser_member'])
					->limit(1)
					->fetch();

			$current_ta = $core->mbkmsetting;
			$info = array(
				'page_title' => 'SIM MBKM',
				'alertmsg' => $alertmsg,
				'page_name' => 'logbook',
				'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
			);
			$adddata = array_merge($info, $lang);
			$templates->addData(
				$adddata
			);
			echo $templates->render('logbook', compact('lang', 'user'));
		}
	}
);



$router->match('GET|POST','/dosen/logbook/detail/(.*)',function ($nim) use ($core, $templates) {
	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
		header('location:' . BASE_URL . '/dosen/login');
	} else {
		if($_SESSION['leveluser_member'] != '2'){
				header('location:' . BASE_URL . '/mahasiswa/logbook');
			}
		$alertmsg = '';
		$lang = $core->setlang('user', WEB_LANG);
		$current_ta = $core->mbkmsetting;
		

		
		// $user = $core->podb->from('mbkm_dpl_kelas')
		// 		->where('id', $core->decrypt($id))
		// 		->limit(1)
		// 		->fetch();
		
		$info = array(
			'page_title' => 'SIM MBKM',
			'alertmsg' => $alertmsg,
			'page_name' => 'logbook',
			'tahun_akademik' => $current_ta['mbkm_jadwal_periode'],
			'nim' => $core->decrypt($nim)
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('logbookdetail', compact('lang'));
	}
}
);


$router->match('GET|POST','/dosen/logbook/nilai/(.*)/([a-z0-9_-]+)/([a-z0-9_-]+)',function ($nim,$pekan,$minggu) use ($core, $templates) {
	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
		header('location:' . BASE_URL . '/dosen/login');
	} else {
		if($_SESSION['leveluser_member'] != '2'){
				header('location:' . BASE_URL . '/mahasiswa/logbook');
			}
		$alertmsg = '';
		$lang = $core->setlang('user', WEB_LANG);
		$current_ta = $core->mbkmsetting;

		if (!empty($_POST)) {
				if($_SESSION['leveluser_member'] != '2'){
					header('location:' . BASE_URL . '/404');
				} else {
					
					if($_POST['jenis'] == 'edit'){

						$delete_post = $core->podb->delete('mbkm_logbook_penilaian')->where('logbook_penilaian_pekan', $pekan)->where('logbook_penilaian_periode_krs', $current_ta['mbkm_jadwal_periode'])->where('logbook_penilaian_nim', $core->decrypt($nim));
						$delete_post->execute();
					}
					
					$query_data = $core->podb->from('mbkm_rubrik_pertanyaan')
                                             ->where('`rubrik_pertanyaan_aktif`', 'Y')
                                             ->orderBy('rubrik_pertanyaan_nomor ASC')
                                             ->fetchAll();
						foreach($query_data as $ql){
							$pi = "pertanyaan_".$ql['rubrik_pertanyaan_id'];
							$pp = "$_POST[$pi]";
							$dj = "jawaban_".$ql['rubrik_pertanyaan_id'];
							$jj = "$_POST[$dj]";
							if(!empty($jj)){
								$data = array(
								'rubrik_pertanyaan_id' => $pp,
								'rubrik_jawaban_id' => $jj,
								'logbook_penilaian_pekan' => $pekan,
								'logbook_penilaian_kode_dosen' => $_SESSION['namauser_member'],
								'logbook_penilaian_nim' => $core->decrypt($nim),
								'logbook_penilaian_periode_krs' => $current_ta['mbkm_jadwal_periode'],
								'mbkm_dpl_kelas' => $_POST['kelas'],
								'logbook_penilaian_created_date' => date('Y-m-d')
								);
								$query_post = $core->podb->insertInto('mbkm_logbook_penilaian')->values($data);
								$query_post->execute();
							}
						}

						$query_update = $core->podb->from('mbkm_view_logbook')
                                             ->where('`pekan`',  $pekan)
											 ->where('`logbook_nim`',  $core->decrypt($nim))
											 ->where('`logbook_periode_akademik`',  $current_ta['mbkm_jadwal_periode'])
                                             ->fetchAll();
						foreach($query_update as $qu){
							$datastatus = array(
								'logbook_status' => 'T'
							);
							$ubahstatus = $core->podb->update('mbkm_logbook')->set($datastatus)->where('logbook_id',$qu['logbook_id']);
							$ubahstatus->execute();
						}
					unset($_POST);
					header('location:'.BASE_URL.'/dosen/logbook/nilai/'.$nim.'/'.$pekan.'/'.$minggu);
				}
		}

		$info = array(
		'page_title' => 'SIM MBKM',
		'alertmsg' => $alertmsg,
		'page_name' => 'logbook',
		'tahun_akademik' => $current_ta['mbkm_jadwal_periode'],
		'pekan' =>$pekan,
		'nim' => $core->decrypt($nim),
		'minggu' => $minggu
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('logbooknilai', compact('lang'));
	}
});


$router->match('GET|POST','/dosen/laporanakhir',function () use ($core, $templates) {
	if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
		header('location:' . BASE_URL . '/dosen/login');
	} else {
		if($_SESSION['leveluser_member'] != '2'){
				header('location:' . BASE_URL . '/mahasiswa/laporanakhir');
			}
		$alertmsg = '';
		$lang = $core->setlang('user', WEB_LANG);
		$current_ta = $core->mbkmsetting;

		
		$info = array(
				'page_title' => 'SIM MBKM',
				'alertmsg' => $alertmsg,
				'page_name' => 'logbook',
				'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
		);
		$adddata = array_merge($info, $lang);
		$templates->addData(
			$adddata
		);
		echo $templates->render('laporanakhir', compact('lang', 'user'));
	}
}
);

$router->match('GET|POST', '/dosen/profile',
	function () use ($core, $templates) {
		if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
			header('location:' . BASE_URL . '/dosen/login');
		} else {
			if($_SESSION['leveluser_member'] != '2'){
				header('location:' . BASE_URL . '/mahasiswa/profile');
			}
			$alertmsg = '';
			$lang = $core->setlang('user', WEB_LANG);

			$user = $core->podb->from('dosen')
					->where('kode_nama', $_SESSION['namauser_member'])
					->where('pwd', $_SESSION['passuser_member'])
					->limit(1)
					->fetch();

			$current_ta = $core->mbkmsetting;
			$info = array(
				'page_title' => 'SIM MBKM',
				'alertmsg' => $alertmsg,
				'page_name' => 'profile',
				'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
			);
			$adddata = array_merge($info, $lang);
			$templates->addData(
				$adddata
			);
			echo $templates->render('profile', compact('lang', 'user'));
		}
	}
);

// $router->match('GET|POST','/dosen/logbook/nilai',function () use ($core, $templates) {
// if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member']))
// {
// header('location:' . BASE_URL . '/dosen/login');
// } else {
// $alertmsg = '';
// $lang = $core->setlang('user', WEB_LANG);
// // $alertmsg = '<div class="alert alert-success">' . $lang['front_member_notif_11'] . '... Data Anda telah tersimpan,
    // Terima kasih telah melakukan Pengisian Formulir Pendaftaran<a class="close" data-dismiss="alert" href="#"
    //     aria-hidden="true">&times;</a></div>';
// $current_ta = $core->mbkmsetting;

// if (!empty($_POST)) {

// $dpl = $core->podb->from('mbkm_dpl_kelas_peserta')
// ->select('id_kelas_dpl')
// ->where('nim', $_SESSION['namauser_member'])
// ->where('periode_krs', $current_ta['mbkm_jadwal_periode'])
// ->limit(1)
// ->fetch();


// if(!empty($_FILES)){


// $lengthrand = 40;
// $randomStringKode_1 = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $lengthrand);
// $randomStringKode_2 = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $lengthrand);
// $randomStringKode_3 = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $lengthrand);

// $upload = new PoUpload($_FILES['img_one']);
// $upload_two = new PoUpload($_FILES['img_two']);
// $upload_three = new PoUpload($_FILES['img_three']);
// if ($upload->uploaded || $upload_two->uploaded || $upload_three->uploaded) {
// $upload->file_new_name_body = $randomStringKode_1;
// $upload->process(DIR_CON.'/logbook/');

// $upload_two->file_new_name_body = $randomStringKode_2;
// $upload_two->process(DIR_CON.'/logbook/');

// $upload_three->file_new_name_body = $randomStringKode_3;
// $upload_three->process(DIR_CON.'/logbook/');

// if ($upload->processed || $upload_two->processed || $upload_three->processed) {
// $datapic = array(
// 'logbook_deskripsi_kegiatan_foto_1' => $upload->file_dst_name,
// 'logbook_deskripsi_kegiatan_foto_2' => $upload_two->file_dst_name,
// 'logbook_deskripsi_kegiatan_foto_3' => $upload_three->file_dst_name
// );
// } else {
// $datapic = array(
// 'logbook_deskripsi_kegiatan_foto_1' => '',
// 'logbook_deskripsi_kegiatan_foto_2' => '',
// 'logbook_deskripsi_kegiatan_foto_3' => ''
// );
// }
// }
// } else {
// $datapic = array(
// 'logbook_deskripsi_kegiatan_foto_1' => '',
// 'logbook_deskripsi_kegiatan_foto_2' => '',
// 'logbook_deskripsi_kegiatan_foto_3' => ''
// );
// }

// $data = array(
// 'logbook_periode_akademik' => $current_ta['mbkm_jadwal_periode'],
// 'logbook_mahasiswa_id' => $_SESSION['iduser_member'],
// 'logbook_nim' => $_SESSION['namauser_member'],
// 'logbook_dpl_kelas_id' => $dpl['id_kelas_dpl'],
// 'logbook_tanggal_kegiatan' => $_POST['tanggal_kegiatan'],
// 'logbook_jam_kerja_awal' => $_POST['jam_awal'],
// 'logbook_jam_kerja_akhir' => $_POST['jam_akhir'],
// 'logbook_deskripsi_kegiatan_1' => $_POST['deskripsi_1'],
// 'logbook_deskripsi_kegiatan_2' => $_POST['deskripsi_2'],
// 'logbook_deskripsi_kegiatan_3' => $_POST['deskripsi_3'],
// 'logbook_tanggal_created' => date('Y-m-d H:i:s'),
// );

// $datafinal = array_merge($data, $datapic);
// $query_post = $core->podb->insertInto('mbkm_logbook')->values($datafinal);
// $query_post->execute();


// unset($_POST);

// header('location:'.BASE_URL.'/mahasiswa/logbook');

// }
// $info = array(
// 'page_title' => 'SIM MBKM',
// 'alertmsg' => $alertmsg,
// 'page_name' => 'logbook',
// 'tahun_akademik' => $current_ta['mbkm_jadwal_periode']
// );
// $adddata = array_merge($info, $lang);
// $templates->addData(
// $adddata
// );
// echo $templates->render('logbookadd', compact('lang', 'user'));
// }
// }

// );