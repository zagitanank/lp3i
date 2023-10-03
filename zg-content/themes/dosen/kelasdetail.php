<?=$this->layout('index');?>
<?php 
$mbkm_bkp = $this->pocore()->call->podb->from('mbkm_jenis')->where('id', $user['jenis_mbkm'])->limit(1)->fetch(); 
$mbkm_kat = $this->pocore()->call->podb->from('mbkm_kategori')->where('mbkm_kategori_id', $mbkm_bkp['mbkm_kategori'])->limit(1)->fetch(); 
?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Peserta Kelas</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL?>/dosen">
                                <svg class="stroke-icon">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Kelas</li>
                        <li class="breadcrumb-item">Kelas DPL</li>
                        <li class="breadcrumb-item active">Peserta</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="pb-2">
                    <a href="<?= BASE_URL?>/dosen/kelas" class="btn btn-pill btn-outline-secondary-2x btn-sm"><i
                            class="fa fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header pb-0 card-no-border">
                            <div class="appointment-table table-responsive">
                                <table class="table table-border-end">
                                    <tbody>
                                        <tr>
                                            <td class="w-25"><span class="f-w-500 f-light">NAMA KELAS</span></td>
                                            <td class="text-end">
                                                <p class="m-0 font-primary f-w-500">
                                                    <?=strtoupper($user['dpl_kelas_nama']);?>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span
                                                    class="f-w-500 f-light"><?=strtoupper($mbkm_kat['mbkm_kategori_nama']);?></span>
                                            </td>
                                            <td class="text-end">
                                                <p class="m-0 font-primary f-w-500">
                                                    BKP <?=strtoupper($mbkm_bkp['mbkm_jenis_nama']);?>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body pt-0 main-our-product">
                            <div class="row g-3">
                                <?php
                                $query_data = $this->pocore()->call->podb->from('mbkm_dpl_kelas_peserta')
                                        ->select('mahasiswa.file,mahasiswa.nama,mahasiswa.nim')
                                        ->leftJoin('mahasiswa ON mahasiswa.nim=mbkm_dpl_kelas_peserta.nim')
                                        ->where('`id_kelas_dpl`', $user['id'])
                                        ->fetchAll();
                                foreach($query_data as $ql){
                                ?>
                                <div class="col-xxl-3 col-sm-4">
                                    <div class="our-product-wrapper h-100 widget-hover">
                                        <div class="our-product-img">
                                            <?php 
                                            if(empty($ql['file'])){
                                            ?>
                                            <img src="<?=BASE_URL?>/<?=DIR_INC?>/images/noimage.jpg"
                                                style="max-height:250px" alt="watch">
                                            <?php }else{ ?>
                                            <img src="<?=URL_SIAKA?>/mahasiswa/<?=$ql['file']?>.jpg"
                                                style="max-height:250px" alt="watch">
                                            <?php } ?>

                                        </div>
                                        <div class=" our-product-content">
                                            <h6 class="f-14 f-w-500 pt-2 pb-1 txt-primary"><?= strtoupper($ql['nama'])?>
                                            </h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="f-14 f-w-500 "><?=$ql['nim']?></h6>
                                                <div class="add-quantity btn border text-gray f-12 f-w-500"><i
                                                        class="fa fa-minus remove-minus count-decrease"></i><span
                                                        class="add-btn">Detail</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>