<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META SECTION -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta http-equiv="Copyright" content="<?= CONF_STRUCTURE; ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="Member Area <?= CONF_STRUCTURE; ?>" />
    <meta name="generator" content="<?= CONF_STRUCTURE; ?> <?= CONF_VER; ?>.<?= CONF_BUILD; ?>" />
    <meta name="author" content="Zagitanank" />
    <meta name="language" content="Indonesia" />
    <meta name="revisit-after" content="7" />
    <meta name="webcrawlers" content="all" />
    <meta name="rating" content="general" />
    <meta name="spiders" content="all" />
    <title><?= $this->e($page_title); ?></title>

    <link rel="shortcut icon" href="<?= BASE_URL . '/' . DIR_INC; ?>/images/favicon.png" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/icofont.css">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/style.css">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/responsive.css">
</head>

<body>

    <div class="page-wrapper compact-wrapper" id="pageWrapper"
        style="background: linear-gradient(60deg, rgba(84, 58, 183, 1) 0%, rgba(0, 172, 193, 1) 100%);">
        <!-- Page Body Start-->
        <div class="container-fluid p-0">
            <div class="comingsoon">
                <div class="comingsoon-inner text-center"><img src="<?= BASE_URL . '/' . DIR_INC; ?>/images/logosim.png"
                        alt="logo">
                    <h5 class="text-white">PILIH STATUS ANDA</h5>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <a href="mahasiswa">
                                    <div class="card small-widget">
                                        <div class="card-body primary">
                                            <span class="d-flex align-items-end">Login</span>
                                            <div class="d-flex align-items-end gap-1">
                                                <h4>Mahasiswa</h4>
                                            </div>
                                            <div class="bg-gradient">
                                                <i class="icofont icofont-group-students f-26"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <a href="dosen">
                                    <div class="card small-widget ">
                                        <div class="card-body primary">
                                            <span class="d-flex align-items-end">Login</span>
                                            <div class="d-flex align-items-end gap-2">
                                                <h4>Dosen</h4>
                                            </div>
                                            <div class="bg-gradient">
                                                <span class="stroke-icon svg-fill">
                                                    <i class="icofont icofont-teacher f-26"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- latest jquery-->
    <script type="text/javascript">
    var BASE_URL = '<?=BASE_URL;?>';
    </script>
    <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/jquery.min.js"></script>
    <!-- Bootstrap js-->
    <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- Sidebar jquery-->

</body>

</html>