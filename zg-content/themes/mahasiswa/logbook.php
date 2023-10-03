<?=$this->layout('index');?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>
                        Log Book</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Assesment</li>
                        <li class="breadcrumb-item active">Log Book</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">

                <div class="live-dark">
                    <div class="alert alert-light-dark light alert-dismissible fade show text-dark border-left-wrapper"
                        role="alert"><i class="icon-info-alt"></i>
                        <p>Log book teratas, merupakan data terkahir diinput!</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <a class="btn btn-success" href="<?= BASE_URL?>/mahasiswa/logbook/add"><i
                                class="fa fa-plus"></i>Tambah Log Book</a>
                        <!-- <h4 class="mb-3">Immediately Show Hidden Details</h4><span>Responsive has the ability to display the details that it has hidden in a variety of different ways. Its default is to allow the end user to toggle the the display by clicking on a row and showing the information in a DataTables child row. At times it can be useful not to require end user interaction to display the hidden data in a responsive manner, which can be done with the childRowImd-flexte display type.</span> -->
                    </div>
                    <div class="card-body">
                        <div class="dt-ext">
                            <table class="display" id="show-hidden-row">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Jam Kegiatan</th>
                                        <th>Status</th>
                                        <th>Tanggal Input</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                        $query_logbook = $this->pocore()->call->podb->from('mbkm_logbook')
                                        ->where('logbook_nim', $_SESSION['namauser_member'])
                                        ->where('logbook_periode_akademik', $this->e($tahun_akademik))
                                        ->orderBy('logbook_id DESC')
                                        ->fetchAll();
                        $nom= 1;
                        foreach($query_logbook as $ql){
                          $pisahinput = explode(' ', $ql['logbook_tanggal_created']);
                        ?>
                                    <tr>
                                        <td><?=$nom;?></td>
                                        <td><?=$this->pocore()->call->tanggal_indo2($ql['logbook_tanggal_kegiatan']);?>
                                        </td>
                                        <td><?=$ql['logbook_jam_kerja_awal'];?>-<?=$ql['logbook_jam_kerja_akhir'];?>
                                        </td>
                                        <td>
                                            <?php if($ql['logbook_status'] == 'T'){ ?>
                                            <span class="badge badge-success">Ditinjau DPL</span>
                                            <?php }elseif($ql['logbook_status'] == 'R'){ ?>
                                            <span class="badge badge-warning">Direvisi DPL</span>
                                            <?php }else{ ?>
                                            <span class="badge badge-danger">Belum Ditinjau DPL</span>
                                            <?php } ?>
                                        </td>
                                        <td><?=$this->pocore()->call->tanggal_indo2($pisahinput[0]);?></td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a
                                                        href="<?= BASE_URL?>/mahasiswa/logbook/edit/<?=$this->pocore()->call->encrypt($ql['logbook_id']);?>"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i
                                                            class="icon-pencil-alt"></i></a></li>
                                                <li class="delete"><a class="alertdel"
                                                        id="<?=$this->pocore()->call->encrypt($ql['logbook_id'])?>"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Hapus"><i class="icon-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php $nom++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

<div id="alertdel" class="modal fade" tabindex="-1" aria-labelledby="tooltipmodal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="<?=BASE_URL;?>/mahasiswa/logbook/delete" autocomplete="off">
                <div class="modal-header">
                    <h4 id="modal-title"><i class="fa fa-exclamation-triangle text-danger"></i>
                        <?=$this->e($dialogdel_1);?></h4>

                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <input type="hidden" id="delid" name="id" />
                        <?=$this->e($dialogdel_2);?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>
                        <?=$this->e($dialogdel_3);?></button>
                    <button type="button" class="btn btn-sm btn-default" data-bs-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-sign-out"></i> <?=$this->e($dialogdel_4);?></button>
                </div>
            </form>
        </div>
    </div>
</div>