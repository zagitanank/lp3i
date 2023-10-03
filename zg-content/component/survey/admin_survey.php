<?php
/*
 *
 * - Zagitanank Admin File
 *
 * - File : admin_contact.php
 * - Version : 1.0
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses admin pada halaman kontak.
 * This is a php file for handling admin process for contact page.
 *
*/

/**
 * Fungsi ini digunakan untuk mencegah file ini diakses langsung tanpa melalui router.
 *
 * This function use for prevent this file accessed directly without going through a router.
 *
*/
if (!defined('CONF_STRUCTURE')) {
	header('location:index.html');
	exit;
}

/**
 * Fungsi ini digunakan untuk mencegah file ini diakses langsung tanpa login akses terlebih dahulu.
 *
 * This function use for prevent this file accessed directly without access login first.
 *
*/
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser']) AND $_SESSION['login'] == 0) {
	header('location:index.php');
	exit;
}

class survey extends PoCore
{

	/**
	 * Fungsi ini digunakan untuk menginisialisasi class utama.
	 *
	 * This function use to initialize the main class.
	 *
	*/
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan halaman index kontak.
	 *
	 * This function use for index survey page.
	 *
	*/
	public function index()
	{
		if (!$this->auth($_SESSION['leveluser'], 'survey', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
		?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle("Responden Survey");?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=survey&act=multidelete', 'autocomplete' => 'off'));?>
						<?=$this->pohtml->inputHidden(array('name' => 'totaldata', 'value' => '0', 'options' => 'id="totaldata"'));?>
						<?php
							$columns = array(
								array('title' => 'Id', 'options' => 'style="width:30px;"'),
								array('title' => 'Nama Lengkap', 'options' => ''),
								array('title' => "Email", 'options' => ''),
								array('title' => 'No.Ponsel/WA', 'options' => ''),
								array('title' => 'Pekerjaan', 'options' => ''),
                                array('title' => 'Saran', 'options' => ''),
								array('title' => 'Aksi', 'options' => 'class="no-sort" style="width:120px;"')
							);
						?>
						<?=$this->pohtml->createTable(array('id' => 'table-survey', 'class' => 'table table-striped table-bordered'), $columns, $tfoot = true);?>
					<?=$this->pohtml->formEnd();?>
				</div>
			</div>
		</div>
		<?=$this->pohtml->dialogDelete('survey');?>
		<div id="viewdata" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 id="modal-title"><?=$GLOBALS['_']['survey_dialog_title_1'];?> Saran</h4>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> <?=$GLOBALS['_']['action_10'];?></button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan data json pada tabel.
	 *
	 * This function use for display json data in table.
	 *
	*/
	public function datatable()
	{
		if (!$this->auth($_SESSION['leveluser'], 'survey', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
		$table = 'survey_responden';
		$primarykey = 'survey_responden_id';
		$columns = array(
			array('db' => $primarykey, 'dt' => '0', 'field' => $primarykey,
				'formatter' => function($d, $row, $i){
					return "<div class='text-center'>\n
						<input type='checkbox' id='titleCheckdel' />\n
						<input type='hidden' class='deldata' name='item[".$i."][deldata]' value='".$d."' disabled />\n
					</div>\n";
				}
			),
			array('db' => $primarykey, 'dt' => '1', 'field' => $primarykey),
			array('db' => 'survey_responden_nama', 'dt' => '2', 'field' => 'survey_responden_nama'),
			array('db' => 'survey_responden_email', 'dt' => '3', 'field' => 'survey_responden_email'),
			array('db' => 'survey_responden_hp', 'dt' => '4', 'field' => 'survey_responden_hp'),
            array('db' => 'survey_responden_pekerjaan', 'dt' => '5', 'field' => 'survey_responden_pekerjaan',
				'formatter' => function($d, $row, $i){
				        if($row['survey_responden_pekerjaan'] == 'pns'){
                            $pekerjaan = 'Pegawai Negeri Sipil';
                        }elseif($row['survey_responden_pekerjaan'] == 'swasta'){
                            $pekerjaan = 'Pegawai Swasta';
                        }elseif($row['survey_responden_pekerjaan'] == 'tnipolri'){
                            $pekerjaan = 'TNI/Polri';
                        }else{
                            $pekerjaan = ucfirst($row['survey_responden_pekerjaan']);
                        }
                        
					return $pekerjaan;
                    
				}
			),
            array('db' => $primarykey, 'dt' => '6', 'field' => $primarykey,
				'formatter' => function($d, $row, $i){
					return "<div class='text-center'>\n
						<div class='btn-group btn-group-xs'>\n
							<a class='btn btn-xs btn-warning viewdata' id='".$d."' data-toggle='tooltip' title='{$GLOBALS['_']['survey_view']}'><i class='fa fa-eye'></i></a>
						</div>\n
					</div>\n";
				}
			),
			array('db' => $primarykey, 'dt' => '7', 'field' => $primarykey,
				'formatter' => function($d, $row, $i){
					
					return "<div class='text-center'>\n
						<div class='btn-group btn-group-xs'>\n
							<a class='btn btn-xs btn-danger alertdel' id='".$d."' data-toggle='tooltip' title='{$GLOBALS['_']['action_2']}'><i class='fa fa-times'></i></a>
						</div>\n
					</div>\n";
				}
			)
		);
		echo json_encode(SSP::simple($_POST, $this->poconnect, $table, $primarykey, $columns));
	}

	/**
	 * Fungsi ini digunakan untuk mengganti status kontak.
	 *
	 * This function use for change survey status.
	 *
	*/
	public function statistik()
	{
		if (!$this->auth($_SESSION['leveluser'], 'survey', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
        ?>
        <div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle('Statistik Survey');?>
				</div>
			</div>
		<script src="../<?=DIR_INC;?>/js/amchart/amcharts.js"></script>
        <script src="../<?=DIR_INC;?>/js/amchart/pie.js"></script>
        <script src="../<?=DIR_INC;?>/js/amchart/light.js"></script>
        
        <?php
            $pertanyaan = $this->podb->from('survey')->fetchAll();
            foreach($pertanyaan as $pr){
        ?>
        <style>
        .amcharts-pie-slice:hover {
            transform: scale(1.1);
            filter: url(#shadow);
        }
        .piechartdiv{
            width: 100%;
            height: 430px;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        #chartdiv<?=$pr['survey_id'];?> {
            width: 100%;
            height: 500px;
        }	
        </style>
        <script>
        
                        var chart = AmCharts.makeChart("chartdiv<?=$pr['survey_id'];?>", {
                            "type": "pie",
                            "theme": "light",
                            "legend": {
                                "position": "top",
                                "marginRight": 0,
                                "autoMargins": true
                            },
                            "startDuration": 0,
                            "labelRadius": -35,
                            "labelText": "",
                            "dataProvider": [
                                {
                                    "parameter": "Sangat Bagus",
                                    "nilai": <?=$pr['survey_jawaban_1'];?>
                                },
                                {
                                    "parameter": "Bagus",
                                    "nilai": <?=$pr['survey_jawaban_2'];?>
                                },
                                {
                                    "parameter": "Biasa",
                                    "nilai": <?=$pr['survey_jawaban_3'];?>
                                },
                                {
                                    "parameter": "Kurang",
                                    "nilai": <?=$pr['survey_jawaban_4'];?>
                                },
                            ],
                            "valueField": "nilai",
                            "titleField": "parameter"
                        });

                        chart.addListener("init", handleInit);

                        chart.addListener("rollOverSlice", function(e) {
                            handleRollOver(e);
                        });
/*
                        function handleInit() {
                            chart.legend.addListener("rollOverItem", handleRollOver);
                        }
*/
                        function handleRollOver(e) {
                            var wedge = e.dataItem.wedge.node;
                            wedge.parentNode.appendChild(wedge);
                        }
            </script>
		
			<div class="row">
				<div class="col-md-12 text-center">
					<h2><?=$pr['survey_pertanyaan'];?></strong></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="stats-desc">
						<div id="chartdiv<?=$pr['survey_id'];?>" class="piechartdiv"></div>
					</div>
				</div>
			</div>
		<?php } ?>	
		</div>
  <?php
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan kontak per id.
	 *
	 * This function use for display survey contain id.
	 *
	*/
	public function viewdata()
	{
		if (!$this->auth($_SESSION['leveluser'], 'survey', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$current_survey = $this->podb->from('survey_responden')
				->where('survey_responden_id', $this->postring->valid($_POST['id'], 'sql'))
				->limit(1)
				->fetch();
			echo $current_survey['survey_responden_saran'];
		}
	}

	/**
	 * Fungsi ini digunakan untuk mengirim balasan email.
	 *
	 * This function use for send email reply.
	 *
	*/
	public function reply()
	{
		if (!$this->auth($_SESSION['leveluser'], 'survey', 'create')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			if ($this->posetting[23]['value'] != 'SMTP') {
				$from = $this->posetting[5]['value'];
				$poemail = new PoEmail;
				$send = $poemail
					->setOption(
						array(
							messageType => 'html'
						)
					)
					->to($this->postring->valid($_POST['email'], 'xss'))
					->subject($this->postring->valid($_POST['subject'], 'xss'))
					->message($this->postring->valid($_POST['message'], 'xss'))
					->from($from)
					->mail();
				if ($send) {
					$this->poflash->success($GLOBALS['_']['survey_message_1'], 'admin.php?mod=survey');
				} else {
					$this->poflash->error($GLOBALS['_']['survey_message_3'], 'admin.php?mod=survey');
				}
			} else {
				$this->pomail->isSMTP();
				$this->pomail->SMTPDebug = 0;
				$this->pomail->Debugoutput = 'html';
				$this->pomail->Host = $this->posetting[24]['value'];
				$this->pomail->Port = $this->posetting[27]['value'];
				$this->pomail->SMTPAuth = true;
				$this->pomail->SMTPSecure = 'ssl';
				$this->pomail->IsHTML(true);
				$this->pomail->Username = $this->posetting[25]['value'];;
				$this->pomail->Password = $this->posetting[26]['value'];
				$this->pomail->setFrom($this->posetting[5]['value'], $this->posetting[0]['value']);
				$this->pomail->addAddress($this->postring->valid($_POST['email'], 'xss'), $this->postring->valid($_POST['name'], 'xss'));
				$this->pomail->Subject = $this->postring->valid($_POST['subject'], 'xss');
				$this->pomail->msgHTML($this->postring->valid($_POST['message'], 'xss'));
				if ($this->pomail->send()) {
					$this->poflash->success($GLOBALS['_']['survey_message_1'], 'admin.php?mod=survey');
				} else {
					$this->poflash->error($GLOBALS['_']['survey_message_3'], 'admin.php?mod=survey');
				}
			}
		}
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus kontak.
	 *
	 * This function is used to display and process delete survey page.
	 *
	*/
	public function delete()
	{
		if (!$this->auth($_SESSION['leveluser'], 'survey', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$query = $this->podb->deleteFrom('survey')->where('id_survey', $this->postring->valid($_POST['id'], 'sql'));
			$query->execute();
			$this->poflash->success($GLOBALS['_']['survey_message_2'], 'admin.php?mod=survey');
		}
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus multi kontak.
	 *
	 * This function is used to display and process multi delete survey page.
	 *
	*/
	public function multidelete()
	{
		if (!$this->auth($_SESSION['leveluser'], 'survey', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$totaldata = $this->postring->valid($_POST['totaldata'], 'xss');
			if ($totaldata != "0") {
				$items = $_POST['item'];
				foreach($items as $item){
					$query = $this->podb->deleteFrom('survey')->where('id_survey', $this->postring->valid($item['deldata'], 'sql'));
					$query->execute();
				}
				$this->poflash->success($GLOBALS['_']['survey_message_2'], 'admin.php?mod=survey');
			} else {
				$this->poflash->error($GLOBALS['_']['survey_message_4'], 'admin.php?mod=survey');
			}
		}
	}

}
