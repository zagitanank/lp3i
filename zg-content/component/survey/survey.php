<?php
/*
 *
 * - Zagitanank Front End File
 *
 * - File : contact.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses di bagian depan untuk halaman kontak.
 * This is a php file for handling front end process for contact page.
 *
*/

/**
 * Router untuk memproses request $_POST[] komentar.
 *
 * Router for process request $_POST[] comment.
 *
*/
$router->match('GET|POST', '/survey', function() use ($core, $templates) {
	$alertmsg = '';
	$lang = $core->setlang('survey', WEB_LANG);
	if (!empty($_POST)) {
		$core->poval->validation_rules(array(
			'survey_name' => 'required|max_len,100|min_len,3',
			'survey_email' => 'required|valid_email',
			'survey_phone' => 'required|max_len,15|min_len,9',
			'survey_message' => 'required|min_len,0'
		));
		$core->poval->filter_rules(array(
			'survey_name' => 'trim|sanitize_string',
			'survey_email' => 'trim|sanitize_email',
			'survey_phone' => 'trim|sanitize_string',
			'survey_message' => 'trim|sanitize_string'
		));
		$validated_data = $core->poval->run($_POST);
		if ($validated_data === false) {
			$alertmsg = '<div class="alert alert-danger fade in alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                                <strong>Error!</strong> '.$lang['front_survey_error'].'
                            </div>';
		} else {
			$data = array(
				'survey_responden_nama' => $_POST['survey_name'],
				'survey_responden_email' => $_POST['survey_email'],
				'survey_responden_hp' => $_POST['survey_phone'],
				'survey_responden_pekerjaan' => $_POST['survey_pekerjaan'],
				'survey_responden_saran' => $_POST['survey_message'],
				'survey_responden_input' => date('Y-m-d H:i:s')
			);
			$query = $core->podb->insertInto('survey_responden')->values($data);
			$query->execute();
            
            
            for($i=1; $i <= 10; $i++){
                $dataid = $_POST['q_'.$i];
                
                $dataSrv =  $core->podb->from('survey')
                           ->where('survey_id', $i)
                  		   ->fetch();
                
                if($dataid == '1'){
                    $dataSurvey = array(
        				'survey_jawaban_1' => $dataSrv['survey_jawaban_1']+1
        			);
                }elseif($dataid == '2'){
                    $dataSurvey = array(
        				'survey_jawaban_2' => $dataSrv['survey_jawaban_2']+1
        			);
                }elseif($dataid == '3'){
                    $dataSurvey = array(
        				'survey_jawaban_3' => $dataSrv['survey_jawaban_3']+1
        			);
                }else{
                    $dataSurvey = array(
        				'survey_jawaban_4' => $dataSrv['survey_jawaban_4']+1
        			);
                }
                
                
                $query_survey = $core->podb->update('survey')
                            				->set($dataSurvey)
                            				->where('survey_id', $i);
    			$query_survey->execute();
            }
            
			unset($_POST);
			$alertmsg = '<div class="alert alert-success fade in alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                                <strong>Success!</strong> '.$lang['front_survey_success'].'
                            </div>';
		}
	}
	$info = array(
		'page_title' => $lang['front_survey'],
		'page_desc' => $core->posetting[2]['value'],
		'page_key' => $core->posetting[3]['value'],
		'social_mod' => $lang['front_survey'],
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
	echo $templates->render('survey', compact('lang'));
});
