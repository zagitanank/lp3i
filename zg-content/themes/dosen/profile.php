<?= $this->layout('index'); ?>
<?php
$current_prodi = $this->pocore()->call->podb->from('prodi')->where('kode_prodi', $user['kode_prodi'])->limit(1)->fetch();
$jenjang = explode('-',$current_prodi['status']);
$nohp = $this->e($user['hp']);
$email = $user['email'];
?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Profile</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Account</li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="user-profile">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input class="form-control" value="<?= $_SESSION['namalengkap_member'] ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kode Dosen</label>
                                    <input class="form-control" value="<?= $_SESSION['namauser_member'] ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prodi Homebase</label>
                                    <input class="form-control"
                                        value="<?=$jenjang['0']?> <?=$current_prodi['nama_prodi']?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email-Address</label>
                                    <input class="form-control" value="<?= $email ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No. Ponsel</label>
                                    <input class="form-control" value="<?= $nohp ?>" disabled>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>