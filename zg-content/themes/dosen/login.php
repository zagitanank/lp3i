<?=$this->layout('index');?>
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">

            <div class="login-card login-dark">
                <div>
                    <div><a class="logo" href="./"><img class="img-fluid for-light"
                                src="<?= BASE_URL . '/' . DIR_INC; ?>/images/logosim.png" alt="looginpage"><img
                                class="img-fluid for-dark" src="<?= BASE_URL . '/' . DIR_INC; ?>/images/logosim.png"
                                alt="looginpage"></a>
                    </div>
                    <div class="login-main">
                        <?=htmlspecialchars_decode($this->e($alertmsg));?>
                        <form class="theme-form" action="<?= BASE_URL; ?>/dosen/login" method="post" id="formLogin">
                            <h4>Login Dosen</h4>
                            <p>Akses Login Anda sesuai dengan Akun SISKA!</p>
                            <div class="form-group">
                                <label class="col-form-label">Kode Dosen</label>
                                <input class="form-control" type="text" name="username" required="" placeholder="">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Kata Sandi</label>
                                <div class="form-input position-relative">
                                    <input class="form-control" type="password" name="password" required=""
                                        placeholder="">
                                    <div class="show-hide"><span class="show"> </span></div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <div class="checkbox p-0">
                                    <input name="rememberme" id="rememberme" value="1" type="checkbox">
                                    <label class="text-muted"
                                        for="rememberme"><?=$this->e($front_member_remember);?></label>
                                </div>
                                <div class="text-end mt-3">
                                    <button class="btn btn-primary btn-block w-100 proses" id="btnProses"
                                        type="submit">Masuk</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>