<?php
/*
 *
 * - Zagitanank Front End File
 *
 * - File : pages.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk halaman pages.
 * This is a php file for handling front end process for pages page.
 *
*/

/**
 * Router untuk menampilkan request halaman pages.
 *
 * Router for display request in pages page.
 *
 * $seotitle = string [a-z0-9_-]
*/
$router->match('GET|POST', '/camaba/tpa/mengerjakan/', function() use ($core, $templates) {
    if (empty($_SESSION['namauser_member']) AND empty($_SESSION['passuser_member']) AND empty($_SESSION['login_member'])) {
		header('location:'.BASE_URL.'/camaba/login');
    } else {
            $alertmsg = '';
			$lang = $core->setlang('tpa', WEB_LANG);
			
			
			$user = $core->podb->from('peserta')
				->where('id_peserta', $_SESSION['iduser_member'])
				->where('block', 'N')
				->limit(1)
				->fetch();
                
            $info = array(
				'page_title' => 'Camaba Area',
                'page_desc' => $core->posetting[2]['value'],
        		'page_key' => $core->posetting[3]['value'],
        		'social_mod' => $lang['front_home'],
        		'social_name' => $core->posetting[0]['value'],
        		'social_url' => $core->posetting[1]['value'],
        		'social_desc' => $core->posetting[2]['value'],
                'page_situs' => $core->posetting[1]['value'],
				'page_name' => 'Tes TPA',
		        'status_seleksi' => $user['status_seleksi'],
                'tahun_pmb' => $core->posetting[30]['value'],
		        'koderegis' => $user['kode_registrasi']
			);
			$adddata = array_merge($info, $lang);
			$templates->addData(
				$adddata
			);
            
			echo $templates->render('mengerjakan', compact('lang','user'));
    }
});

$router->match('GET|POST', '/camaba/tpa/simpansatu', function() use ($core, $templates) {
	if ($core->posetting[17]['value'] == 'Y') {
		if (empty($_SESSION['namauser_member']) AND empty($_SESSION['passuser_member']) AND empty($_SESSION['login_member'])) {
			header('location:'.BASE_URL.'/camaba/login');
		} else {
                $p			= json_decode(file_get_contents('php://input'));
                $update_ 	= "";
                for ($i = 1; $i < $p->jml_soal; $i++) {
                    $_tjawab 	 = "opsi_".$i;
            		$_tidsoal 	 = "id_soal_".$i;
            		$jawaban_ 	 = empty($p->$_tjawab) ? "" : $p->$_tjawab;
            		$update_	.= "".$p->$_tidsoal.":".$jawaban_.",";
                }
            	$update_		= substr($update_, 0, -1);
                $datapengerjaan = array('list_jawaban' => $update_);
                $updatequery    = $core->podb->update('tpa_mengerjakan')
					                   ->set($datapengerjaan)
					                   ->where('id_peserta', $_SESSION['iduser_member']);
				$updatequery->execute();
                
                $d_ret_urn 	= $core->podb->from('tpa_mengerjakan')
                    		       ->where('id_peserta', $_SESSION['iduser_member'])
                                   ->fetch();
                
                $ret_urn 	= explode(",", $d_ret_urn['list_jawaban']);
                $hasil 		= array();
                foreach ($ret_urn as $key => $value) {
                    $pc_ret_urn = explode(":", $value);
                    $idx 		= $pc_ret_urn['0'];
            		$val 		= $pc_ret_urn['1'];
            		$hasil[]    = $val;
                }
            
                $d['data'] = $hasil;
                $d['status'] = "ok";
                header('Content-Type: application/json');
	            echo json_encode($d);
		}
	} else {
		header('location:'.BASE_URL.'/404.php');
	}
});

$router->match('GET|POST', '/camaba/tpa/jam', function() use ($core, $templates) {
	if ($core->posetting[17]['value'] == 'Y') {
		if (empty($_SESSION['namauser_member']) AND empty($_SESSION['passuser_member']) AND empty($_SESSION['login_member'])) {
			header('location:'.BASE_URL.'/camaba/login');
		} else {
			$now = new DateTime(); 
                 $dt  = $now->format("M j, Y H:i:s O"); 
                 echo json_encode($dt);
        }
    }
    
}); 

$router->match('GET|POST', '/camaba/tpa/selesai_tpa', function() use ($core, $templates) {
	if ($core->posetting[17]['value'] == 'Y') {
		if (empty($_SESSION['namauser_member']) AND empty($_SESSION['passuser_member']) AND empty($_SESSION['login_member'])) {
			header('location:'.BASE_URL.'/camaba/login');
		} else {
			$q_nilai = $core->podb->from('tpa_mengerjakan')
                    		 ->where('id_peserta', $_SESSION['iduser_member'])
                    		 ->where('status', 'N')
                             ->limit(1)
                             ->fetch();
                if (empty($q_nilai)) {
        			header('location:'.BASE_URL.'/camaba/tpa/mengerjakan');
        		} else {
        			header('location:'.BASE_URL.'/camaba/registrasi/wawancara');
        		}
        }
    }
    
}); 

$router->match('GET|POST', '/camaba/tpa/simpan_akhir', function() use ($core, $templates) {
	if ($core->posetting[17]['value'] == 'Y') {
		if (empty($_SESSION['namauser_member']) AND empty($_SESSION['passuser_member']) AND empty($_SESSION['login_member'])) {
			header('location:'.BASE_URL.'/camaba/login');
		} else {
			$p			= json_decode(file_get_contents('php://input'));
            	$jumlah_soal = $p->jml_soal;
            	$jumlah_benar = 0;
            	//$jumlah_bobot = 0;
            	$update_ = "";
            	//nilai bobot 
            	$array_bobot 	= array();
            	$array_nilai	= array();
            	for ($i = 1; $i < $p->jml_soal; $i++) {
            	   $_tjawab 	= "opsi_".$i;
            	   $_tidsoal 	= "id_soal_".$i;
            	   $jawaban_ 	= empty($p->$_tjawab) ? "" : $p->$_tjawab;
            	   $cek_jwb 	= $core->podb->from('tpa_soal')
                        		       ->where('id', $p->$_tidsoal)
                                       ->fetch();
            	   //untuknilai bobot
            	   $bobotnya 	= $cek_jwb['bobot'];
            	   $array_bobot[$bobotnya] = empty($array_bobot[$bobotnya]) ? 1 : $array_bobot[$bobotnya] + 1;
            				
            	   $q_update_jwb = "";
            	   if ($cek_jwb['jawaban'] == $jawaban_) {
            			//jika jawaban benar
            			$jumlah_benar++;
            			$array_nilai[$bobotnya] = empty($array_nilai[$bobotnya]) ? 1 : $array_nilai[$bobotnya] + 1;
            			$q_update_jwb = array('jml_benar' => 'jml_benar + 1');
            	   } else {
            			//jika jawaban salah
            			$array_nilai[$bobotnya] = empty($array_nilai[$bobotnya]) ? 0 : $array_nilai[$bobotnya] + 0;
            			$q_update_jwb = array('jml_salah' => 'jml_salah + 1');
            	   }
                    $queryupdate = $core->podb->update('tpa_soal')
    					           ->set($q_update_jwb)
    					           ->where('id', $p->$_tidsoal);
    				$queryupdate->execute();
                    //mysql_query($q_update_jwb);
            
                    $update_	.= "".$p->$_tidsoal.":".$jawaban_.",";
                }
                //perhitungan nilai bobot
                ksort($array_bobot);
                ksort($array_nilai);
                $nilai_bobot_benar = 0;
                $nilai_bobot_total = 0;
                foreach ($array_bobot as $key => $value) {
                    $nilai_bobot_benar = $nilai_bobot_benar + ($key * $array_nilai[$key]);
                    $nilai_bobot_total = $nilai_bobot_total + ($key * $array_bobot[$key]);
                }
                $update_	 = substr($update_, 0, -1);
                $nilai       = ($jumlah_benar/($jumlah_soal-1)) * 100;
            	$nilai_bobot = ($nilai_bobot_benar/$nilai_bobot_total)*100;
                $dataupdate  = array('jml_benar' => $jumlah_benar, 'nilai_bobot' => $nilai_bobot, 'nilai' => $nilai, 'list_jawaban' => $update_, 'status' => 'N');
                $queryupdateselesai = $core->podb->update('tpa_mengerjakan')
    					                   ->set($dataupdate)
    					                   ->where('id_peserta', $_SESSION['iduser_member']);
   				$queryupdateselesai->execute();
                $a['status'] = "ok";
                header('Content-Type: application/json');
                echo json_encode($a);
                exit;
        }
    }
    
});