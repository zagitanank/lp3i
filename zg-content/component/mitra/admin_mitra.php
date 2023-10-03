<?php
/*
 *
 * - Admin File
 *
 * - File : admin_mitra.php
 * - Version : 1.0
 * - Author : Zagitanank
 *
 *
 * Ini adalah file php yang di gunakan untuk menangani proses admin pada halaman mitra.
 * This is a php file for handling admin process for mitra page.
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

class mitra extends PoCore
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
	 * Fungsi ini digunakan untuk menampilkan halaman index mitra.
	 *
	 * This function use for index mitra page.
	 *
	*/
	public function index()
	{
		if (!$this->auth($_SESSION['leveluser'], 'mitra', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
		?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle('mitra', '
						<div class="btn-title pull-right">
							<a href="admin.php?mod=mitra&act=addnew" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> '.$GLOBALS['_']['addnew'].'</a>
						</div>
					');?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=mitra&act=multidelete', 'autocomplete' => 'off'));?>
						<?=$this->pohtml->inputHidden(array('name' => 'totaldata', 'value' => '0', 'options' => 'id="totaldata"'));?>
						<?php
							$columns = array(
								array('title' => 'Id', 'options' => 'style="width:30px;"'),
								array('title' => 'Title', 'options' => ''),
								array('title' => 'Active', 'options' => 'style="width:30px;"'),
								array('title' => 'Action', 'options' => 'class="no-sort" style="width:50px;"')
							);
						?>
						<?=$this->pohtml->createTable(array('id' => 'table-mitra', 'class' => 'table table-striped table-bordered'), $columns, $tfoot = true);?>
					<?=$this->pohtml->formEnd();?>
				</div>
			</div>
		</div>
		<?=$this->pohtml->dialogDelete('mitra');?>
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
		if (!$this->auth($_SESSION['leveluser'], 'mitra', 'read')) {
			echo $this->pohtml->error();
			exit;
		}
		$table = 'mitra';
		$primarykey = 'id_mitra';
		$columns = array(
			array('db' => $primarykey, 'dt' => '0', 'field' => $primarykey,
				'formatter' => function($d, $row, $i){
					return "<div class='text-center'>
						<input type='checkbox' id='titleCheckdel' />
						<input type='hidden' class='deldata' name='item[".$i."][deldata]' value='".$d."' disabled />
					</div>";
				}
			),
			array('db' => $primarykey, 'dt' => '1', 'field' => $primarykey),
			array('db' => 'title', 'dt' => '2', 'field' => 'title'),
			array('db' => 'active', 'dt' => '3', 'field' => 'active'),
            array('db' => $primarykey, 'dt' => '4', 'field' => $primarykey,
				'formatter' => function($d, $row, $i){
				    return "<div class='text-center'>\n
						<div class='btn-group btn-group-xs'>\n
							<a href='admin.php?mod=mitra&act=edit&id=".$d."' class='btn btn-xs btn-default' id='".$d."' data-toggle='tooltip' title='{$GLOBALS['_']['action_1']}'><i class='fa fa-pencil'></i></a>
                            <a class='btn btn-xs btn-danger alertdel' id='".$d."' data-toggle='tooltip' title='{$GLOBALS['_']['action_2']}'><i class='fa fa-times'></i></a>
						</div>\n
					</div>\n";
				}
			),
		);
		echo json_encode(SSP::simple($_POST, $this->poconnect, $table, $primarykey, $columns));
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman tambah mitra.
	 *
	 * This function is used to display and process add mitra page.
	 *
	*/
	public function addnew()
	{
		if (!$this->auth($_SESSION['leveluser'], 'mitra', 'create')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$mitra = array(
				'title' => $this->postring->valid($_POST['title'], 'xss'),
				'picture' => $this->postring->valid($_POST['picture'], 'xss'),
				'publishdate' => date('Y-m-d'),
			);
			$query = $this->podb->insertInto('mitra')->values($mitra);
			$query->execute();
			$this->poflash->success('mitra has been successfully added', 'admin.php?mod=mitra');
		}
		?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle('Add mitra');?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=mitra&act=addnew', 'autocomplete' => 'off'));?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="title">Title</label>
									<input type="text" name="title" class="form-control" id="title" value="<?=(isset($_POST['title']) ? $_POST['title'] : '');?>" placeholder="Title" />
								</div>
							</div>
                            
						</div>
                        <div class="row">
                            <div class="col-md-6">
								<?=$this->pohtml->inputText(array('type' => 'text', 'label' => $GLOBALS['_']['mitra_picture'].' '.$GLOBALS['_']['mitra_notice'], 'name' => 'picture', 'id' => 'picture', 'mandatory' => true, 'options' => 'required',), $inputgroup = true, $inputgroupopt = array('href' => '../'.DIR_INC.'/js/filemanager/dialog.php?type=1&field_id=picture', 'id' => 'browse-file', 'class' => 'btn-success', 'options' => '', 'title' => $GLOBALS['_']['action_7'].' '.$GLOBALS['_']['mitra_picture']));?>
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
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman edit mitra.
	 *
	 * This function is used to display and process edit mitra.
	 *
	*/
	public function edit()
	{
		if (!$this->auth($_SESSION['leveluser'], 'mitra', 'update')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
		    if ($_SESSION['leveluser'] == '1' OR $_SESSION['leveluser'] == '2') {
				$active = $this->postring->valid($_POST['active'], 'xss');
			} else {
				$active = "N";
			}
			$mitra = array(
				'title' => $this->postring->valid($_POST['title'], 'xss'),
				'picture' => $this->postring->valid($_POST['picture'], 'xss'),
				'publishdate' => date('Y-m-d'),
                'active' => $active
			);
			$query = $this->podb->update('mitra')
				->set($mitra)
				->where('id_mitra', $this->postring->valid($_POST['id'], 'sql'));
			$query->execute();
			$this->poflash->success('mitra has been successfully updated', 'admin.php?mod=mitra');
		}
		$id = $this->postring->valid($_GET['id'], 'sql');
		$current_mitra = $this->podb->from('mitra')
			->where('id_mitra', $id)
			->limit(1)
			->fetch();
		if (empty($current_mitra)) {
			echo $this->pohtml->error();
			exit;
		}
		?>
		<div class="block-content">
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->headTitle('Update mitra');?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?=$this->pohtml->formStart(array('method' => 'post', 'action' => 'route.php?mod=mitra&act=edit', 'autocomplete' => 'off'));?>
						<?=$this->pohtml->inputHidden(array('name' => 'id', 'value' => $current_mitra['id_mitra']));?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="title">Title</label>
									<input type="text" name="title" class="form-control" id="title" value="<?=(isset($_POST['title']) ? $_POST['title'] : $current_mitra['title']);?>" placeholder="Title" />
								</div>
							</div>
							
						</div>
                        <div class="row">
							<div class="col-md-12">
								<div class="form-group" id="image-box">
									<div class="row">
										<?php if ($current_mitra['picture'] == '') { ?>
											<div class="col-md-12"><label><?=$GLOBALS['_']['mitra_picture_2'];?></label></div>
											<div class="col-md-12">
												<a href="data:image/gif;base64,R0lGODdhyACWAOMAAO/v76qqqubm5t3d3bu7u7KystXV1cPDw8zMzAAAAAAAAAAAAAAAAAAAAAAAAAAAACwAAAAAyACWAAAE/hDISau9OOvNu/9gKI5kaZ5oqq5s675wLM90bd94ru987//AoHBILBqPyKRyyWw6n9CodEqtWq/YrHbL7Xq/4LB4TC6bz+i0es1uu9/wuHxOr9vv+Lx+z+/7/4CBgoOEhYaHiImKi4yNjo+QkZKTlJWWl5iZmpucnZ6foKGio6SlpqeoqaqrrK2ur7CxsrO0tba3TAMFBQO4LAUBAQW+K8DCxCoGu73IzSUCwQECAwQBBAIVCMAFCBrRxwDQwQLKvOHV1xbUwQfYEwIHwO3BBBTawu2BA9HGwcMT1b7Vw/Dt3z563xAIrHCQnzsAAf0F6ybhwDdwgAx8OxDQgASN/sKUBWNmwQDIfwBAThRoMYDHCRYJGAhI8eRMf+4OFrgZgCKgaB4PHqg4EoBQbxgBROtlrJu4ofYm0JMQkJk/mOMkTA10Vas1CcakJrXQ1eu/sF4HWhB3NphYlNsmxOWKsWtZtASTdsVb1mhEu3UDX3RLFyVguITzolQKji/GhgXNvhU7OICgsoflJr7Qd2/isgEPGGAruTTjnSZTXw7c1rJpznobf2Y9GYBjxIsJYQbXstfRDJ1luz6t2TDvosSJSpMw4GXG3TtT+hPpEoPJ6R89B7AaUrnolgWwnUQQEKVOAy199mlonPDfr3m/GeUHFjBhAf0SUh28+P12QOIIgDbcPdwgJV+Arf0jnwTwsHOQT/Hs1BcABObjDAcTXhiCOGppKAJI6nnIwQGiKZSViB2YqB+KHtxjjXMsxijjjDTWaOONOOao44489ujjj0AGKeSQRBZp5JFIJqnkkkw26eSTUEYp5ZRUVmnllVhmqeWWXHbp5ZdghinmmGSW6UsEADs=" target="_blank"><?=$GLOBALS['_']['mitra_picture_3'];?></a>
												<p><i><?=$GLOBALS['_']['mitra_picture_4'];?></i></p>
											</div>
										<?php } else { ?>
											<div class="col-md-12"><label><?=$GLOBALS['_']['mitra_picture_5'];?></label></div>
											<div class="col-md-12">
												<a href="../zg-content/uploads/<?=$current_mitra['picture'];?>" target="_blank"><?=$GLOBALS['_']['mitra_picture_6'];?></a>
												<p>
													<i><?=$GLOBALS['_']['mitra_picture_4'];?></i>
													<button type="button" class="btn btn-xs btn-danger pull-right del-image" id="<?=$current_mitra['id_mitra'];?>"><i class="fa fa-trash-o"></i></button>
												</p>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-md-6">
								<?=$this->pohtml->inputText(array('type' => 'text', 'label' => $GLOBALS['_']['mitra_picture'].' '.$GLOBALS['_']['mitra_notice'], 'name' => 'picture', 'id' => 'picture', 'value' => $current_mitra['picture']), $inputgroup = true, $inputgroupopt = array('href' => '../'.DIR_INC.'/js/filemanager/dialog.php?type=1&field_id=picture', 'id' => 'browse-file', 'class' => 'btn-success', 'options' => '', 'title' => $GLOBALS['_']['action_7'].' '.$GLOBALS['_']['mitra_picture']));?>
			                 </div>
						</div>
                        <div class="row">
							<div class="col-md-12">
								<?php
									if ($current_mitra['active'] == 'N') {
										$radioitem = array(
											array('name' => 'active', 'id' => 'active', 'value' => 'Y', 'options' => '', 'title' => 'Y'),
											array('name' => 'active', 'id' => 'active', 'value' => 'N', 'options' => 'checked', 'title' => 'N')
										);
										echo $this->pohtml->inputRadio(array('label' => $GLOBALS['_']['mitra_active'], 'mandatory' => true), $radioitem, $inline = true);
									} else {
										$radioitem = array(
											array('name' => 'active', 'id' => 'active', 'value' => 'Y', 'options' => 'checked', 'title' => 'Y'),
											array('name' => 'active', 'id' => 'active', 'value' => 'N', 'options' => '', 'title' => 'N')
										);
										echo $this->pohtml->inputRadio(array('label' => $GLOBALS['_']['mitra_active'], 'mandatory' => true), $radioitem, $inline = true);
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
		<?php
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus mitra.
	 *
	 * This function is used to display and process delete mitra page.
	 *
	*/
	public function delete()
	{
		if (!$this->auth($_SESSION['leveluser'], 'mitra', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$query = $this->podb->deleteFrom('mitra')->where('id_mitra', $this->postring->valid($_POST['id'], 'sql'));
			$query->execute();
			$this->poflash->success('mitra has been successfully deleted', 'admin.php?mod=mitra');
		}
	}

	/**
	 * Fungsi ini digunakan untuk menampilkan dan memproses halaman hapus multi mitra.
	 *
	 * This function is used to display and process multi delete mitra page.
	 *
	*/
	public function multidelete()
	{
		if (!$this->auth($_SESSION['leveluser'], 'mitra', 'delete')) {
			echo $this->pohtml->error();
			exit;
		}
		if (!empty($_POST)) {
			$totaldata = $this->postring->valid($_POST['totaldata'], 'xss');
			if ($totaldata != "0") {
				$items = $_POST['item'];
				foreach($items as $item){
					$query = $this->podb->deleteFrom('mitra')->where('id_mitra', $this->postring->valid($item['deldata'], 'sql'));
					$query->execute();
				}
				$this->poflash->success('mitra has been successfully deleted', 'admin.php?mod=mitra');
			} else {
				$this->poflash->error('Error deleted mitra data', 'admin.php?mod=mitra');
			}
		}
	}

}