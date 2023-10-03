<?=$this->layout('index');?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Kelas</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL?>/dosen">
                                <svg class="stroke-icon">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Kelas</li>
                        <li class="breadcrumb-item active">Kelas DPL </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dt-ext">
                            <table class="display" id="show-hidden-row">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>MBKM</th>
                                        <th>BKP</th>
                                        <th>Nama Kelas</th>
                                        <th>Jumlah Mahasiswa</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                        $query_data = $this->pocore()->call->podb->from('mbkm_dpl_kelas')
                                        ->select('`mbkm_dpl_kelas`.*, mbkm_jenis.mbkm_kategori, mbkm_jenis.mbkm_jenis_nama')
                                        ->innerJoin('mbkm_jenis ON mbkm_jenis.id=mbkm_dpl_kelas.jenis_mbkm')
                                        ->where('`kode_dosen`', $_SESSION['namauser_member'])
                                        ->where('`periode_krs`', $this->e($tahun_akademik))
                                        ->orderBy('mbkm_dpl_kelas.id DESC')
                                        ->fetchAll();
                        $nom= 1;
                        foreach($query_data as $ql){
                          if ($ql['mbkm_kategori'] == 1) {
                            $kategori = 'MBKM Kementerian';
                          } elseif ($ql['mbkm_kategori'] == 2) {
                              $kategori = 'MBKM Unifa';
                          }
                          $jml =  $this->pocore()->call->podb->from('mbkm_dpl_kelas_peserta')
                                  ->where('id_kelas_dpl', $ql['id'])
                                  ->count();
                        ?>
                                    <tr>
                                        <td><?=$nom;?></td>
                                        <td><?=ucfirst($kategori)?></td>
                                        <td><?=$ql['mbkm_jenis_nama'];?></td>
                                        <td><?=$ql['dpl_kelas_nama']?></td>
                                        <td><?=$jml;?></td>
                                        <td>
                                            <a href="<?= BASE_URL?>/dosen/kelas/peserta/<?=$this->pocore()->call->encrypt($ql['id']);?>"
                                                class="btn btn-pill btn-outline-primary-2x btn-sm">Peserta <i
                                                    class="fa fa-arrow-right"></i>
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