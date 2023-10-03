<?=$this->layout('index');?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Log Book Bimbingan</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL?>/dosen">
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
    <div class="container-fluid m-b-50">


        <div class="row">
            <div class="col-sm-12">
                <div class="row g-sm-3 widget-charts">

                    <div class="col-sm-3">
                        <div class="card small-widget mb-sm-0">
                            <div class="card-body primary"><span class="f-light">Jumlah Logbook</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4><?= $this->pocore()->call->podb->from('mbkm_view_logbook')
                                        ->where('kode_dosen', $_SESSION['namauser_member'])
                                        ->where('logbook_periode_akademik', $this->e($tahun_akademik))->count(); ?>
                                    </h4><span class="font-primary f-12 f-w-500">
                                        <span>Data</span></span>
                                </div>
                                <div class="bg-gradient">
                                    <svg class="stroke-icon svg-fill">
                                        <use
                                            href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/svg/icon-sprite.svg#stroke-calendar">
                                        </use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card small-widget mb-sm-0">
                            <div class="card-body secondary"><span class="f-light">Belum Dinilai Semua Pekan</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4>
                                        <?php
                                            $jmllogbook = $this->pocore()->call->podb->from('mbkm_view_logbook_per_pekan')->where('kode_dosen', $_SESSION['namauser_member'])->where('logbook_periode_akademik', $this->e($tahun_akademik))->count();
                                            $jmlsudahdinilai = $this->pocore()->call->podb->from('mbkm_view_penilaian')->where('logbook_penilaian_kode_dosen', $_SESSION['namauser_member'])->where('logbook_penilaian_periode_krs', $this->e($tahun_akademik))->count();
                                        echo $jmllogbook -$jmlsudahdinilai;
                                        ?>
                                    </h4><span class="font-secondary f-12 f-w-500"><span>Data</span></span>
                                </div>
                                <div class="bg-gradient">
                                    <svg class="stroke-icon svg-fill">
                                        <use
                                            href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/svg/icon-sprite.svg#stroke-faq">
                                        </use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card small-widget mb-sm-0">
                            <div class="card-body success"><span class="f-light">Jumlah Logbook Pekan Ini</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4><?= $this->pocore()->call->podb->from('mbkm_view_logbook_minggu_ini')
                                        ->where('kode_dosen', $_SESSION['namauser_member'])
                                        ->where('logbook_periode_akademik', $this->e($tahun_akademik))->count(); ?>
                                    </h4><span class="font-success f-12 f-w-500">
                                        <span>Data</span></span>
                                </div>
                                <div class="bg-gradient">
                                    <i class="text-success" data-feather="layers"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card small-widget mb-sm-0">
                            <div class="card-body warning"><span class="f-light">Belum Dinilai Pekan ini</span>
                                <div class="d-flex align-items-end gap-1">
                                    <h4>
                                        <?php
                                            $jmllogbookpekanini = $this->pocore()->call->podb->from('mbkm_view_logbook_minggu_ini')->where('kode_dosen', $_SESSION['namauser_member'])->where('logbook_periode_akademik', $this->e($tahun_akademik))->count();
                                            $sdhdinilaipekanini = $this->pocore()->call->podb->from('mbkm_view_penilaian_minggu_ini')->where('logbook_penilaian_kode_dosen', $_SESSION['namauser_member'])->where('logbook_penilaian_periode_krs', $this->e($tahun_akademik))->count();
                                        echo $jmllogbookpekanini-$sdhdinilaipekanini;
                                        ?>
                                    </h4><span class="font-warning f-12 f-w-500"><span>Data</span></span>
                                </div>
                                <div class="bg-gradient">
                                    <i class="text-warning" data-feather="file-minus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card m-t-10">
                    <div class="card-body">
                        <div class="dt-ext">
                            <table data-display-length='-1' class="display" id="show-hidden-row">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nim</th>
                                        <th>Nama Lengkap</th>
                                        <th>Kelas</th>
                                        <th>BKP</th>
                                        <th>Jml. Logbook</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                        $query_logbook = $this->pocore()->call->podb->from('mbkm_dpl_kelas')
                                        ->select('mbkm_dpl_kelas.periode_krs,mbkm_dpl_kelas_peserta.id_kelas_dpl,mbkm_dpl_kelas_peserta.nim,mbkm_dpl_kelas_peserta.jenis_mbkm,mahasiswa.nama')
                                        ->leftJoin('mbkm_dpl_kelas_peserta ON mbkm_dpl_kelas.id=mbkm_dpl_kelas_peserta.id_kelas_dpl')
                                        ->leftJoin('mahasiswa ON mahasiswa.nim=mbkm_dpl_kelas_peserta.nim')
                                        ->where('kode_dosen', $_SESSION['namauser_member'])
                                        ->where('mbkm_dpl_kelas.periode_krs', $this->e($tahun_akademik))
                                        ->orderBy('dpl_kelas_nama DESC')
                                        ->fetchAll();
                        $nom= 1;
                        foreach($query_logbook as $ql){
                            $mbkm_bkp = $this->pocore()->call->podb->from('mbkm_jenis')->where('id', $ql['jenis_mbkm'])->limit(1)->fetch(); 
                            $mbkm_kat = $this->pocore()->call->podb->from('mbkm_kategori')->where('mbkm_kategori_id', $mbkm_bkp['mbkm_kategori'])->limit(1)->fetch(); 
                            $jml_log = $this->pocore()->call->podb->from('mbkm_logbook')->where('logbook_nim', $ql['nim'])->where('logbook_periode_akademik', $ql['periode_krs'])->count(); 
                        ?>
                                    <tr>
                                        <td><?=$nom;?></td>
                                        <td><?=$ql['nim'];?></td>
                                        <td><a
                                                href="<?= BASE_URL?>/dosen/logbook/detail/<?=$this->pocore()->call->encrypt($ql['nim']);?>"><strong
                                                    class="font-primary"><?= strtoupper($ql['nama']);?></strong></a>
                                        </td>
                                        <td><?=$ql['dpl_kelas_nama'];?></td>
                                        <td>
                                            <?=$mbkm_bkp['mbkm_jenis_nama'];?><br> <small
                                                class="f-light"><?=ucwords(strtolower($mbkm_kat['mbkm_kategori_nama']));?></small>
                                        </td>
                                        <td>
                                            <?php
                                            if($jml_log == 0){
                                            ?>
                                            <span class="badge badge-danger"><?=$jml_log;?> Data</span>
                                            <?php }else{ ?>
                                            <span class="badge badge-primary"><?=$jml_log;?> Data</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($jml_log > 0){
                                            ?>
                                            <a href="<?= BASE_URL?>/dosen/logbook/detail/<?=$this->pocore()->call->encrypt($ql['nim']);?>"
                                                class="btn btn-pill btn-outline-primary-2x btn-sm">Log Book <i
                                                    class="fa fa-arrow-right"></i>
                                            </a>
                                            <?php
                                            $jmllogbookMhs = $this->pocore()->call->podb->from('mbkm_view_logbook_per_pekan')->where('logbook_nim', $ql['nim'])->where('kode_dosen', $_SESSION['namauser_member'])->where('logbook_periode_akademik', $this->e($tahun_akademik))->count();
                                            $jmlsudahdinilaiMhs = $this->pocore()->call->podb->from('mbkm_view_penilaian')->where('logbook_penilaian_nim', $ql['nim'])->where('logbook_penilaian_kode_dosen', $_SESSION['namauser_member'])->where('logbook_penilaian_periode_krs', $this->e($tahun_akademik))->count();
                                            $totalbelum = $jmllogbookMhs -$jmlsudahdinilaiMhs;

                                            if($totalbelum > 0){
                                                echo '<br><small class="txt-danger f-w-600">Ada yang belum dinilai</small>';
                                            }
                                            ?>
                                            <?php }else{ ?>
                                            <i class="text-danger" data-feather="x"></i>
                                            <?php } ?>
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


<script>
var warnaRadial = '';
var nilaiPersen = ';'
</script>