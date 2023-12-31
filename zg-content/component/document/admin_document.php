<?php
/*
 *
 * - Zagitanank Admin File
 *
 * - File : admin_document.php
 * - Version : 1.1
 * - Author : Zagitanank
 * - License : MIT License
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses admin pada halaman.
 * This is a php file for handling admin process for document.
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

class document extends PoCore
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
	 * Fungsi ini digunakan untuk menampilkan halaman index halaman.
	 *
	 * This function use for index document.
	 *
	*/
	public function index()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
		?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle($GLOBALS['_']['component_name'],
                    '<div class="btn-title pull-right">
							<a href="admin.php?mod=document&act=addnew" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> '.$GLOBALS['_']['addnew'].'</a>
							<a href="admin.php?mod=document&act=category" class="btn btn-success btn-sm"><i class="fa fa-book"></i> '.$GLOBALS['_']['document_category'].'</a>
						</div>'
                    );?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=document&act=multidelete', 'autocomplete' => 'off'));?>
						<?=$this->pohtml->inputHidden(array('name' => 'totaldata', 'value' => '0', 'options' => 'id="totaldata"'));?>
						<?php
							$columns = array(
								array('title' => 'Id', 'options' => 'style="width:30px;"'),
								array('title' => $GLOBALS['_']['document_title'], 'options' => ''),
								array('title' => $GLOBALS['_']['document_date'], 'options' => 'class="no-sort" style="width:100px;"'),
								array('title' => $GLOBALS['_']['document_active'], 'options' => 'class="no-sort" style="width:30px;"'),
								array('title' => $GLOBALS['_']['document_action'], 'options' => 'class="no-sort" style="width:50px;"')
							);
						?>
						<?=$this->pohtml->createTable(array('id' => 'table-document', 'class' => 'table table-striped table-bordered'), $columns, $tfoot = true);?>
					<?=$this->pohtml->formEnd();?>
				</div>
			</div>
		</div>
		<?=$this->pohtml->dialogDelete('document');?>
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
		if (!$this->auth($_SESSION['leveluser'], 'document', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
		$table = 'document';
		$primarykey = 'id_document';
		$columns = array(
			array('db' => 'p.'.$primarykey, 'dt' => '0', 'field' => $primarykey,
				'formatter' => function($d, $row, $i){
					return "<div class='text-center'>\n
						<input type='checkbox' id='titleCheckdel' />\n
						<input type='hidden' class='deldata' name='item[".$i."][deldata]' value='".$d."' disabled />\n
					</div>\n";
				}
			),
			array('db' => 'p.'.$primarykey, 'dt' => '1', 'field' => $primarykey),
			array('db' => 'pd.title', 'dt' => '2', 'field' => 'title'),
            array('db' => 'p.publishdate', 'dt' => '3', 'field' => 'publishdate'),
			array('db' => 'p.active', 'dt' => '4', 'field' => 'active'),
			array('db' => 'p.'.$primarykey, 'dt' => '5', 'field' => $primarykey,
				'formatter' => function($d, $row, $i){
					return "<div class='text-center'>\n
						<div class='btn-group btn-group-xs'>\n
							<a href='admin.php?mod=document&act=edit&id=".$d."' class='btn btn-xs btn-default' id='".$d."' data-toggle='tooltip' title='{$GLOBALS['_']['action_1']}'><i class='fa fa-pencil'></i></a>
							<a class='btn btn-xs btn-danger alertdel' id='".$d."' data-toggle='tooltip' title='{$GLOBALS['_']['action_2']}'><i class='fa fa-times'></i></a>
						</div>\n
					</div>\n";
				}
			)
		);
		$joinquery = "FROM document AS p JOIN document_description AS pd ON (pd.id_document = p.id_document)";
		$extrawhere = "pd.id_language = '1'";
		echo json_encode(SSP::simple($_POST, $this->poconnect, $table, $primarykey, $columns, $joinquery, $extrawhere));
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman add halaman.
	 *
	 * This function is used to display and process add document.
	 *
	*/
	public function addnew()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'create')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			if ($_SESSION['leveluser'] == '1' OR $_SESSION['leveluser'] == '2') {
				$active = "Y";
			} else {
				$active = "N";
			}
            
            $publishdate = date('Y-m-d H:i:s');
			$document = array(
				'picture' => $_POST['picture'],
				'publishdate' => $publishdate,
                'editor' => $_SESSION['iduser'],
				'active' => $active
			);
			$query_document = $this->podb->insertInto('document')->values($document);
			$query_document->execute();
			
			$last_document = $this->podb->from('document')
				->orderBy('id_document DESC')
				->limit(1)
				->fetch();
			$id_categorys = $_POST['id_category'];
			if (!empty($id_categorys)) {
					$category = array(
						'id_document' => $last_document['id_document'],
						'id_category_document' => $id_categorys,
					);
					$query_category = $this->podb->insertInto('document_category')->values($category);
					$query_category->execute();
			}
			foreach ($_POST['document'] as $id_language => $value) {
				$document_description = array(
					'id_document' => $last_document['id_document'],
					'id_language' => $id_language,
					'title' => $this->postring->valid($value['title'], 'xss')
				);
				$query_document_description = $this->podb->insertInto('document_description')->values($document_description);
				$query_document_description->execute();
			}
			$this->poflash->success($GLOBALS['_']['document_message_1'], 'admin.php?mod=document');
		}
		?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle($GLOBALS['_']['document_addnew']);?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=document&act=addnew', 'autocomplete' => 'off'));?>
						<div class="row">
                            
							<div class="col-md-12">
								<?php
									$notab = 1;
									$noctab = 1;
									$langs = $this->podb->from('language')->where('active', 'Y')->orderBy('id_language ASC')->fetchAll();
								?>
								<ul class="nav nav-tabs">
									<?php foreach($langs as $lang) { ?>
									<li <?php echo ($notab == '1' ? 'class="active"' : ''); ?>><a href="#tab-content-<?=$lang['id_language'];?>" data-toggle="tab"><img src="../<?=DIR_INC;?>/images/flag/<?=$lang['code'];?>.png" /> <?=$lang['title'];?></a></li>
									<?php $notab++;} ?>
								</ul>
								<div class="tab-content">
									<?php foreach($langs as $lang) { ?>
									<div class="tab-pane <?php echo ($noctab == '1' ? 'active' : ''); ?>" id="tab-content-<?=$lang['id_language'];?>">
										<?=$this->pohtml->inputText(array('type' => 'text', 'label' => $GLOBALS['_']['document_title'], 'name' => 'document['.$lang['id_language'].'][title]', 'id' => 'title-'.$lang['id_language'], 'mandatory' => true, 'options' => 'required'));?>
									</div>
									<?php $noctab++;} ?>
								</div>
							</div>
						</div>
                        
						<div class="row">
                            <div class="col-md-6">
								<div class="input-group">
									<?php
										$kateg = $this->podb->from('category_document')
                            				->select('category_document_description.title')
                            				->leftJoin('category_document_description ON category_document_description.id_category_document = category_document.id_category_document')
                            				->where('category_document.active', 'Y')
                                            ->where('category_document_description.id_language', '1')
											->orderBy('category_document.id_category_document DESC')
                                            ->fetchAll();
										echo $this->pohtml->inputSelectNoOpt(array('id' => 'id_category', 'label' => $GLOBALS['_']['document_category'], 'name' => 'id_category', 'mandatory' => true, 'options' => 'required'));
										echo '<option value="" hidden>Pilih </option>';
                                        foreach($kateg as $ktg){
											echo '<option value="'.$ktg['id_category_document'].'">'.$ktg['title'].'</option>';
										}
										echo $this->pohtml->inputSelectNoOptEnd();
									?>
									<span class="input-group-btn" style="padding-top:25px !important;">
										<a href="admin.php?mod=document&act=addnewcategory" class="btn btn-success"><?=$GLOBALS['_']['addnew'];?></a>
									</span>
								</div>
							</div>
							<div class="col-md-6">
								<?=$this->pohtml->inputText(array('type' => 'text', 'label' => $GLOBALS['_']['document_file'], 'name' => 'picture', 'id' => 'picture'), $inputgroup = true, $inputgroupopt = array('href' => '../'.DIR_INC.'/js/filemanager/dialog.php?type=0&field_id=picture', 'id' => 'browse-file', 'class' => 'btn-success', 'options' => '', 'title' => $GLOBALS['_']['action_7'].' '.$GLOBALS['_']['document_file']));?>
							</div>
						</div>
                        
						<div class="row">
							<div class="col-md-12">
								<?=$this->pohtml->formAction();?>
							</div>
						</div>
					<?=$this->pohtml->formEnd();?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman edit halaman.
	 *
	 * This function is used to display and process edit document.
	 *
	*/
	public function edit()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'update')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			if ($_SESSION['leveluser'] == '1' OR $_SESSION['leveluser'] == '2') {
				$active = $this->postring->valid($_POST['active'], 'xss');
			} else {
				$active = "N";
			}
            $publishdate = date('Y-m-d H:i:s');
			$document = array(
				'picture' => $_POST['picture'],
				'publishdate' => $publishdate,
                'editor' => $_SESSION['iduser'],
				'active' => $active
			);
			$query_document = $this->podb->update('document')
				->set($document)
				->where('id_document', $this->postring->valid($_POST['id'], 'sql'));
			$query_document->execute();
            
			$query_del_cats = $this->podb->deleteFrom('document_category')->where('id_document', $this->postring->valid($_POST['id'], 'sql'));
			$query_del_cats->execute();
			$id_categorys = $_POST['id_category'];
			if (!empty($id_categorys)) {
					$category = array(
						'id_document' => $this->postring->valid($_POST['id'], 'sql'),
						'id_category_document' => $id_categorys,
					);
					$query_category = $this->podb->insertInto('document_category')->values($category);
					$query_category->execute();
			}
			foreach ($_POST['document'] as $id_language => $value) {
				$othlang_document = $this->podb->from('document_description')
					->where('id_document', $this->postring->valid($_POST['id'], 'sql'))
					->where('id_language', $id_language)
					->count();
				if ($othlang_document > 0) {
					$document_description = array(
						'title' => $this->postring->valid($value['title'], 'xss')
					);
					$query_document_description = $this->podb->update('document_description')
						->set($document_description)
						->where('id_document_description', $this->postring->valid($value['id'], 'sql'));
				} else {
					$document_description = array(
						'id_document' => $this->postring->valid($_POST['id'], 'sql'),
						'id_language' => $id_language,
						'title' => $this->postring->valid($value['title'], 'xss')
					);
					$query_document_description = $this->podb->insertInto('document_description')->values($document_description);
				}
				$query_document_description->execute();
			}
			$this->poflash->success($GLOBALS['_']['document_message_2'], 'admin.php?mod=document');
		}
		$id = $this->postring->valid($_GET['id'], 'sql');
		if ($_SESSION['leveluser'] != '1' || $_SESSION['leveluser'] != '2') {
			$current_document = $this->podb->from('document')
				->select('document_description.title')
				->leftJoin('document_description ON document_description.id_document = document.id_document')
				->where('document.id_document', $id)
				->limit(1)
				->fetch();
		} else {
			$current_document = $this->podb->from('document')
				->select('document_description.title')
				->leftJoin('document_description ON document_description.id_document = document.id_document')
				->where('document.id_document', $id)
				->where('document.editor', $_SESSION['iduser'])
				->limit(1)
				->fetch();
		}
		if (empty($current_document)) {
			echo $this->pohtml->error();
			exit;
		}
		?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle($GLOBALS['_']['document_edit']);?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=document&act=edit&id='.$current_document['id_document'], 'autocomplete' => 'off'));?>
						<?=$this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_document['id_document'], 'options' => 'id="id_document"'));?>
						
                        <div class="row">
							<div class="col-md-12">
								<?php
									$notab = 1;
									$noctab = 1;
									$langs = $this->podb->from('language')->where('active', 'Y')->orderBy('id_language ASC')->fetchAll();
								?>
								<ul class="nav nav-tabs">
									<?php foreach($langs as $lang) { ?>
									<li <?php echo ($notab == '1' ? 'class="active"' : ''); ?>><a href="#tab-content-<?=$lang['id_language'];?>" data-toggle="tab"><img src="../<?=DIR_INC;?>/images/flag/<?=$lang['code'];?>.png" /> <?=$lang['title'];?></a></li>
									<?php $notab++;} ?>
								</ul>
								<div class="tab-content">
									<?php foreach($langs as $lang) { ?>
									<div class="tab-pane <?php echo ($noctab == '1' ? 'active' : ''); ?>" id="tab-content-<?=$lang['id_language'];?>">
										<?php
										$paglang = $this->podb->from('document_description')
											->where('document_description.id_document', $current_document['id_document'])
											->where('document_description.id_language', $lang['id_language'])
											->fetch();
										?>
                                        <?=$this->pohtml->inputHidden(array('name' => 'document['.$lang['id_language'].'][id]', 'value' => $paglang['id_document_description']));?>
										<?=$this->pohtml->inputText(array('type' => 'text', 'label' => $GLOBALS['_']['document_title'], 'name' => 'document['.$lang['id_language'].'][title]', 'id' => 'title-'.$lang['id_language'], 'value' => $paglang['title'], 'mandatory' => true, 'options' => 'required'));?>
									    	
                                    </div>
									<?php $noctab++;} ?>
								</div>
							</div>
						</div>
                        
						<div class="row">
                            <div class="col-md-6">
								<div class="input-group">
									<?php
                                        $seldtcats = $this->podb->from('document_category')
    									            ->where('document_category.id_document',$current_document['id_document'])
                                                    ->fetch();   
                                        $selcats = $this->podb->from('document_category')
    										->select('category_document_description.title ')
    										->leftJoin('category_document_description ON category_document_description.id_category_document = document_category.id_category_document')
    										->where('document_category.id_category_document',$seldtcats['id_category_document'])
    										->fetch();
                                        
										$kateg = $this->podb->from('category_document')
                            				->select('category_document_description.title')
                            				->leftJoin('category_document_description ON category_document_description.id_category_document = category_document.id_category_document')
                            				->where('category_document.active', 'Y')
                                            ->where('category_document_description.id_language', '1')
											->orderBy('category_document.id_category_document DESC')
                                            ->fetchAll();
										echo $this->pohtml->inputSelectNoOpt(array('id' => 'id_category', 'label' => $GLOBALS['_']['document_category'], 'name' => 'id_category', 'mandatory' => true, 'options' => 'required'));
										    echo '<option value="'.$selcats['id_category_document'].'">'.$GLOBALS['_']['document_select'].' - '.$selcats['title'].'</option>';
										foreach($kateg as $ktg){
											echo '<option value="'.$ktg['id_category_document'].'">'.$ktg['title'].'</option>';
										}
										echo $this->pohtml->inputSelectNoOptEnd();
									?>
									<span class="input-group-btn" style="padding-top:25px !important;">
										<a href="admin.php?mod=document&act=addnewcategory" class="btn btn-success"><?=$GLOBALS['_']['addnew'];?></a>
									</span>
								</div>
							</div>
                            <div class="col-md-6">
								<?=$this->pohtml->inputText(array('type' => 'text', 'label' => $GLOBALS['_']['document_file'], 'name' => 'picture', 'id' => 'picture', 'value' => $current_document['picture']), $inputgroup = true, $inputgroupopt = array('href' => '../'.DIR_INC.'/js/filemanager/dialog.php?type=0&field_id=picture', 'id' => 'browse-file', 'class' => 'btn-success', 'options' => '', 'title' => $GLOBALS['_']['action_7'].' '.$GLOBALS['_']['document_file']));?>
							</div>
						</div>
                        
                        <div class="row">
							<div class="col-md-12">
								<div class="form-group" id="image-box">
									<div class="row">
										<?php if ($current_document['picture'] == '') { ?>
											<div class="col-md-12"><label><?=$GLOBALS['_']['document_picture_2'];?></label></div>
											<div class="col-md-12">
												<a href="data:image/gif;base64,R0lGODdhyACWAOMAAO/v76qqqubm5t3d3bu7u7KystXV1cPDw8zMzAAAAAAAAAAAAAAAAAAAAAAAAAAAACwAAAAAyACWAAAE/hDISau9OOvNu/9gKI5kaZ5oqq5s675wLM90bd94ru987//AoHBILBqPyKRyyWw6n9CodEqtWq/YrHbL7Xq/4LB4TC6bz+i0es1uu9/wuHxOr9vv+Lx+z+/7/4CBgoOEhYaHiImKi4yNjo+QkZKTlJWWl5iZmpucnZ6foKGio6SlpqeoqaqrrK2ur7CxsrO0tba3TAMFBQO4LAUBAQW+K8DCxCoGu73IzSUCwQECAwQBBAIVCMAFCBrRxwDQwQLKvOHV1xbUwQfYEwIHwO3BBBTawu2BA9HGwcMT1b7Vw/Dt3z563xAIrHCQnzsAAf0F6ybhwDdwgAx8OxDQgASN/sKUBWNmwQDIfwBAThRoMYDHCRYJGAhI8eRMf+4OFrgZgCKgaB4PHqg4EoBQbxgBROtlrJu4ofYm0JMQkJk/mOMkTA10Vas1CcakJrXQ1eu/sF4HWhB3NphYlNsmxOWKsWtZtASTdsVb1mhEu3UDX3RLFyVguITzolQKji/GhgXNvhU7OICgsoflJr7Qd2/isgEPGGAruTTjnSZTXw7c1rJpznobf2Y9GYBjxIsJYQbXstfRDJ1luz6t2TDvosSJSpMw4GXG3TtT+hPpEoPJ6R89B7AaUrnolgWwnUQQEKVOAy199mlonPDfr3m/GeUHFjBhAf0SUh28+P12QOIIgDbcPdwgJV+Arf0jnwTwsHOQT/Hs1BcABObjDAcTXhiCOGppKAJI6nnIwQGiKZSViB2YqB+KHtxjjXMsxijjjDTWaOONOOao44489ujjj0AGKeSQRBZp5JFIJqnkkkw26eSTUEYp5ZRUVmnllVhmqeWWXHbp5ZdghinmmGSW6UsEADs=" target="_blank"><?=$GLOBALS['_']['document_picture_3'];?></a>
												<p><i><?=$GLOBALS['_']['document_picture_4'];?></i></p>
											</div>
										<?php } else { ?>
											<div class="col-md-12"><label><?=$GLOBALS['_']['document_picture_5'];?></label></div>
											<div class="col-md-12">
												<a href="../zg-content/uploads/<?=$current_document['picture'];?>" target="_blank"><?=$GLOBALS['_']['document_picture_6'];?></a>
												<p>
													<i><?=$GLOBALS['_']['document_picture_4'];?></i>
													<button type="button" class="btn btn-xs btn-danger pull-right del-image" id="<?=$current_document['id_document'];?>"><i class="fa fa-trash-o"></i></button>
												</p>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-md-12">
								<?php
									if ($current_document['active'] == 'N') {
										$radioitem = array(
											array('name' => 'active', 'id' => 'active', 'value' => 'Y', 'options' => '', 'title' => 'Y'),
											array('name' => 'active', 'id' => 'active', 'value' => 'N', 'options' => 'checked', 'title' => 'N')
										);
										echo $this->pohtml->inputRadio(array('label' => $GLOBALS['_']['document_active'], 'mandatory' => true), $radioitem, $inline = true);
									} else {
										$radioitem = array(
											array('name' => 'active', 'id' => 'active', 'value' => 'Y', 'options' => 'checked', 'title' => 'Y'),
											array('name' => 'active', 'id' => 'active', 'value' => 'N', 'options' => '', 'title' => 'N')
										);
										echo $this->pohtml->inputRadio(array('label' => $GLOBALS['_']['document_active'], 'mandatory' => true), $radioitem, $inline = true);
									}
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?=$this->pohtml->formAction();?>
							</div>
						</div>
					<?=$this->pohtml->formEnd();?>
				</div>
			</div>
		</div>
		<div id="alertdelimg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<form method="post" action="route.php?mod=document&act=edit&id='.<?=$current_document['id_document'];?>" autocomplete="off">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i> <?=$GLOBALS['_']['dialogdel_1'];?></h3>
						</div>
						<div class="modal-body">
							<?=$GLOBALS['_']['dialogdel_2'];?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-sm btn-danger btn-del-image" id=""><i class="fa fa-trash-o"></i> <?=$GLOBALS['_']['dialogdel_3'];?></button>
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-sign-out"></i> <?=$GLOBALS['_']['dialogdel_4'];?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus halaman.
	 *
	 * This function is used to display and process delete document.
	 *
	*/
	public function delete()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			if ($_SESSION['leveluser'] != '1' || $_SESSION['leveluser'] != '2') {
				$query_desc = $this->podb->deleteFrom('document_description')->where('id_document', $this->postring->valid($_POST['id'], 'sql'));
				$query_desc->execute();
				$query_cats = $this->podb->deleteFrom('document_category')->where('id_document', $this->postring->valid($_POST['id'], 'sql'));
				$query_cats->execute();
				$query_pag = $this->podb->deleteFrom('document')->where('id_document', $this->postring->valid($_POST['id'], 'sql'));
				$query_pag->execute();
				$this->poflash->success($GLOBALS['_']['document_message_3'], 'admin.php?mod=document');
			} else {
				$current_document = $this->podb->from('document')
					->where('id_document', $this->postring->valid($_POST['id'], 'sql'))
					->where('editor', $_SESSION['iduser'])
					->limit(1)
					->fetch();
				if (empty($current_document)) {
					$this->poflash->error($GLOBALS['_']['document_message_6'], 'admin.php?mod=post');
				} else {
					$query_desc = $this->podb->deleteFrom('document_description')->where('id_document', $this->postring->valid($_POST['id'], 'sql'));
					$query_desc->execute();
					$query_cats = $this->podb->deleteFrom('document_category')->where('id_document', $this->postring->valid($_POST['id'], 'sql'));
					$query_cats->execute();
					$query_pag = $this->podb->deleteFrom('document')->where('id_document', $this->postring->valid($_POST['id'], 'sql'));
					$query_pag->execute();
					$this->poflash->success($GLOBALS['_']['document_message_3'], 'admin.php?mod=document');
				}
			}
		}
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus multi halaman.
	 *
	 * This function is used to display and process multi delete document.
	 *
	*/
	public function multidelete()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$totaldata = $this->postring->valid($_POST['totaldata'], 'xss');
			if ($totaldata != "0") {
				$items = $_POST['item'];
				foreach($items as $item){
					if ($_SESSION['leveluser'] != '1' || $_SESSION['leveluser'] != '2') {
						$query_desc = $this->podb->deleteFrom('document_description')->where('id_document', $this->postring->valid($item['deldata'], 'sql'));
						$query_desc->execute();
						$query_cats = $this->podb->deleteFrom('document_category')->where('id_document', $this->postring->valid($item['deldata'], 'sql'));
						$query_cats->execute();
						$query_pag = $this->podb->deleteFrom('document')->where('id_document', $this->postring->valid($item['deldata'], 'sql'));
						$query_pag->execute();
					} else {
						$current_document = $this->podb->from('document')
							->where('id_document', $this->postring->valid($item['deldata'], 'sql'))
							->where('editor', $_SESSION['iduser'])
							->limit(1)
							->fetch();
						if (!empty($current_document)) {
							$query_desc = $this->podb->deleteFrom('document_description')->where('id_document', $this->postring->valid($item['deldata'], 'sql'));
							$query_desc->execute();
							$query_cats = $this->podb->deleteFrom('document_category')->where('id_document', $this->postring->valid($item['deldata'], 'sql'));
							$query_cats->execute();
							$query_pag = $this->podb->deleteFrom('document')->where('id_document', $this->postring->valid($item['deldata'], 'sql'));
							$query_pag->execute();
						}
					}
				}
				$this->poflash->success($GLOBALS['_']['document_message_3'], 'admin.php?mod=document');
			} else {
				$this->poflash->error($GLOBALS['_']['document_message_6'], 'admin.php?mod=document');
			}
		}
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus gambar terpilih.
	 *
	 * This function is used to display and process delete selected image.
	 *
	*/
	public function delimage()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$document = array(
				'picture' => ''
			);
			$query_document = $this->podb->update('document')
				->set($document)
				->where('id_document', $this->postring->valid($_POST['id'], 'sql'));
			$query_document->execute();
		}
	}
    
    
    /**
	 * Fungsi ini digunakan untuk menampilkan halaman index category.
	 *
	 * This function use for index category page.
	 *
	*/
	public function category()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
		?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle($GLOBALS['_']['component_name_category'], '
						<div class="btn-title pull-right">
							<a href="admin.php?mod=document&act=addnewcategory" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> '.$GLOBALS['_']['addnew'].'</a>
							<a href="admin.php?mod=document" class="btn btn-success btn-sm"><i class="fa fa-book"></i> '.$GLOBALS['_']['document_back'].'</a>
						</div>
					');?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=document&act=multideletecategory', 'autocomplete' => 'off'));?>
						<?=$this->pohtml->inputHidden(array('name' => 'totaldata', 'value' => '0', 'options' => 'id="totaldata"'));?>
						<?php
							$columns = array(
								array('title' => 'Id', 'options' => 'style="width:30px;"'),
								array('title' => $GLOBALS['_']['document_title'], 'options' => ''),
								array('title' => $GLOBALS['_']['document_active'], 'options' => 'class="no-sort" style="width:50px;"'),
								array('title' => $GLOBALS['_']['document_action'], 'options' => 'class="no-sort" style="width:50px;"')
							);
						?>
						<?=$this->pohtml->createTable(array('id' => 'table-category', 'class' => 'table table-striped table-bordered'), $columns, $tfoot = true);?>
					<?=$this->pohtml->formEnd();?>
				</div>
			</div>
		</div>
		<?=$this->pohtml->dialogDelete('document', 'deletecategory');?>
		<?php
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan data json pada tabel.
	 *
	 * This function use for display json data in table.
	 *
	*/
	public function datatable2()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
		$table = 'document_category';
		$primarykey = 'id_category_document';
		$columns = array(
			array('db' => 'c.'.$primarykey, 'dt' => '0', 'field' => $primarykey,
				'formatter' => function($d, $row, $i){
					return "<div class='text-center'>\n
						<input type='checkbox' id='titleCheckdel' />\n
						<input type='hidden' class='deldata' name='item[".$i."][deldata]' value='".$d."' disabled />\n
					</div>\n";
				}
			),
			array('db' => 'c.'.$primarykey, 'dt' => '1', 'field' => $primarykey),
			array('db' => 'cd.title', 'dt' => '2', 'field' => 'title'),
			array('db' => 'c.active', 'dt' => '3', 'field' => 'active',
				'formatter' => function($d, $row, $i){
					return "<div class='text-center'>".$d."</div>\n";
				}
			),
			array('db' => 'c.'.$primarykey, 'dt' => '4', 'field' => $primarykey,
				'formatter' => function($d, $row, $i){
					return "<div class='text-center'>\n
						<div class='btn-group btn-group-xs'>\n
							<a href='admin.php?mod=document&act=editcategory&id=".$d."' class='btn btn-xs btn-default' id='".$d."' data-toggle='tooltip' title='{$GLOBALS['_']['action_1']}'><i class='fa fa-pencil'></i></a>
							<a class='btn btn-xs btn-danger alertdel' id='".$d."' data-toggle='tooltip' title='{$GLOBALS['_']['action_2']}'><i class='fa fa-times'></i></a>
						</div>\n
					</div>\n";
				}
			)
		);
		$joinquery = "FROM category_document AS c JOIN category_document_description AS cd ON (cd.id_category_document = c.id_category_document)";
		$extrawhere = "cd.id_language = '1'";
		echo json_encode(SSP::simple($_POST, $this->poconnect, $table, $primarykey, $columns, $joinquery, $extrawhere));
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman tambah category.
	 *
	 * This function is used to display and process add category page.
	 *
	*/
	public function addnewcategory()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'create')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			if ($_SESSION['leveluser'] == '1' OR $_SESSION['leveluser'] == '2') {
				$active = "Y";
			} else {
				$active = "N";
			}
			$category = array(
				'seotitle' => $this->postring->seo_title($this->postring->valid($_POST['category'][1]['title'], 'xss')),
				'active' => $active
			);
			$query_category = $this->podb->insertInto('category_document')->values($category);
			$query_category->execute();
			$last_category = $this->podb->from('category_document')
				->orderBy('id_category_document DESC')
				->limit(1)
				->fetch();
			foreach ($_POST['category'] as $id_language => $value) {
				$category_description = array(
					'id_category_document' => $last_category['id_category_document'],
					'id_language' => $id_language,
					'title' => $this->postring->valid($value['title'], 'xss')
				);
				$query_category_description = $this->podb->insertInto('category_document_description')->values($category_description);
				$query_category_description->execute();
			}
			$this->poflash->success($GLOBALS['_']['document_category_message_1'], 'admin.php?mod=document&act=category');
		}
		?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle($GLOBALS['_']['document_category_addnew']);?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=document&act=addnewcategory', 'autocomplete' => 'off'));?>
						
						<div class="row">
							<div class="col-md-12">
								<?php
									$notab = 1;
									$noctab = 1;
									$langs = $this->podb->from('language')->where('active', 'Y')->orderBy('id_language ASC')->fetchAll();
								?>
								<ul class="nav nav-tabs">
									<?php foreach($langs as $lang) { ?>
									<li <?php echo ($notab == '1' ? 'class="active"' : ''); ?>><a href="#tab-content-<?=$lang['id_language'];?>" data-toggle="tab"><img src="../<?=DIR_INC;?>/images/flag/<?=$lang['code'];?>.png" /> <?=$lang['title'];?></a></li>
									<?php $notab++;} ?>
								</ul>
								<div class="tab-content">
									<?php foreach($langs as $lang) { ?>
									<div class="tab-pane <?php echo ($noctab == '1' ? 'active' : ''); ?>" id="tab-content-<?=$lang['id_language'];?>">
										<?=$this->pohtml->inputText(array('type' => 'text', 'label' => $GLOBALS['_']['document_title'], 'name' => 'category['.$lang['id_language'].'][title]', 'id' => 'title-'.$lang['id_language'], 'mandatory' => true, 'options' => 'required'));?>
									</div>
									<?php $noctab++;} ?>
								</div>
								<?=$this->pohtml->formAction();?>
							</div>
						</div>
					<?=$this->pohtml->formEnd();?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman edit category.
	 *
	 * This function is used to display and process edit category.
	 *
	*/
	public function editcategory()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'update')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			if ($_SESSION['leveluser'] == '1' OR $_SESSION['leveluser'] == '2') {
				$active = $this->postring->valid($_POST['active'], 'xss');
			} else {
				$active = "N";
			}
			$category = array(
				'seotitle' => $this->postring->seo_title($this->postring->valid($_POST['category'][1]['title'], 'xss')),
				'active' => $active
			);
			$query_category = $this->podb->update('category_document')
				->set($category)
				->where('id_category_document', $this->postring->valid($_POST['id'], 'sql'));
			$query_category->execute();
			foreach ($_POST['category'] as $id_language => $value) {
				$othlang_category = $this->podb->from('category_document_description')
					->where('id_category_document', $this->postring->valid($_POST['id'], 'sql'))
					->where('id_language', $id_language)
					->count();
				if ($othlang_category > 0) {
					$category_description = array(
						'title' => $this->postring->valid($value['title'], 'xss')
					);
					$query_category_description = $this->podb->update('category_document_description')
						->set($category_description)
						->where('id_category_description', $this->postring->valid($value['id'], 'sql'));
				} else {
					$category_description = array(
						'id_category_document' => $this->postring->valid($_POST['id'], 'sql'),
						'id_language' => $id_language,
						'title' => $this->postring->valid($value['title'], 'xss')
					);
					$query_category_description = $this->podb->insertInto('category_document_description')->values($category_description);
				}
				$query_category_description->execute();
			}
			$this->poflash->success($GLOBALS['_']['document_category_message_2'], 'admin.php?mod=document&act=category');
		}
		$id = $this->postring->valid($_GET['id'], 'sql');
		$current_category = $this->podb->from('category_document')
			->select('category_document_description.title')
			->leftJoin('category_document_description ON category_document_description.id_category_document = category_document.id_category_document')
			->where('category_document.id_category_document', $id)
			->limit(1)
			->fetch();
		if (empty($current_category)) {
			echo $this->pohtml->error();
			exit;
		}
		?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle($GLOBALS['_']['document_category_edit']);?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=document&act=editcategory&id='.$current_category['id_category_document'], 'autocomplete' => 'off'));?>
						
						<div class="row">
							<div class="col-md-12">
								<?php
									$notab = 1;
									$noctab = 1;
									$langs = $this->podb->from('language')->where('active', 'Y')->orderBy('id_language ASC')->fetchAll();
								?>
								<ul class="nav nav-tabs">
									<?php foreach($langs as $lang) { ?>
									<li <?php echo ($notab == '1' ? 'class="active"' : ''); ?>><a href="#tab-content-<?=$lang['id_language'];?>" data-toggle="tab"><img src="../<?=DIR_INC;?>/images/flag/<?=$lang['code'];?>.png" /> <?=$lang['title'];?></a></li>
									<?php $notab++;} ?>
								</ul>
								<div class="tab-content">
									<?php foreach($langs as $lang) { ?>
									<div class="tab-pane <?php echo ($noctab == '1' ? 'active' : ''); ?>" id="tab-content-<?=$lang['id_language'];?>">
										<?php
										$catlang = $this->podb->from('category_document_description')
											->where('category_document_description.id_category_document', $current_category['id_category_document'])
											->where('category_document_description.id_language', $lang['id_language'])
											->fetch();
										?>
                                        <?=$this->pohtml->inputText(array('type' => 'text', 'label' => $GLOBALS['_']['document_title'], 'name' => 'category['.$lang['id_language'].'][title]', 'id' => 'title-'.$lang['id_language'], 'value' => $catlang['title'], 'mandatory' => true, 'options' => 'required'));?>
									</div>
									<?php $noctab++;} ?>
								</div>
								<?=$this->pohtml->formAction();?>
							</div>
						</div>
					<?=$this->pohtml->formEnd();?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus category.
	 *
	 * This function is used to display and process delete category page.
	 *
	*/
	public function deletecategory()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$query_desc = $this->podb->deleteFrom('category_document_description')->where('id_category_document', $this->postring->valid($_POST['id'], 'sql'));
			$query_desc->execute();
			$query_cat = $this->podb->deleteFrom('category_document')->where('id_category_document', $this->postring->valid($_POST['id'], 'sql'));
			$query_cat->execute();
			$this->poflash->success($GLOBALS['_']['document_category_message_3'], 'admin.php?mod=document&act=category');
		}
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus multi category.
	 *
	 * This function is used to display and process multi delete category page.
	 *
	*/
	public function multideletecategory()
	{
		if (!$this->auth($_SESSION['leveluser'], 'document', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$totaldata = $this->postring->valid($_POST['totaldata'], 'xss');
			if ($totaldata != "0") {
				$items = $_POST['item'];
				foreach($items as $item){
					$query_desc = $this->podb->deleteFrom('category_document_description')->where('id_category_document', $this->postring->valid($item['deldata'], 'sql'));
					$query_desc->execute();
					$query_cat = $this->podb->deleteFrom('category_document')->where('id_category_document', $this->postring->valid($item['deldata'], 'sql'));
					$query_cat->execute();
				}
				$this->poflash->success($GLOBALS['_']['document_category_message_3'], 'admin.php?mod=document&act=category');
			} else {
				$this->poflash->error($GLOBALS['_']['document_category_message_6'], 'admin.php?mod=document&act=category');
			}
		}
	}

}
