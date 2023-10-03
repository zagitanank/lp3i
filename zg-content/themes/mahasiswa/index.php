<!DOCTYPE html>
<?php if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) {
    $bodycolor = "background-color: #E9E9E9;";
} else {
    $bodycolor = "";
}
?>
<html dir="ltr" lang="en">

<head>

    <!-- Meta Tags -->
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
    <!-- END META SECTION -->
    <link rel="shortcut icon" href="<?= BASE_URL . '/' . DIR_INC; ?>/images/favicon.png" />
    <!-- CSS INCLUDE -->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/feather-icon.css">



    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/bootstrap.css">


    <?php if (!empty($_SESSION['namauser_member']) and !empty($_SESSION['passuser_member']) and !empty($_SESSION['login_member'])) { ?>
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css"
        href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/vendors/datatable-extension.css">
    <!-- Plugins css Ends-->
    <?php } ?>

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/style.css">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/responsive.css">



    <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/' . DIR_INC; ?>/akun/css/custome-style.css">


</head>

<body>
    <?php if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) { ?>
    <?php } else { ?>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- START PAGE CONTAINER -->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->

        <div class="page-header">
            <div class="header-wrapper row m-0">

                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"><a href="<?= BASE_URL; ?>/akun"><img class="img-fluid"
                                src="<?= BASE_URL . '/' . DIR_INC; ?>/images/logosim.png" alt=""></a></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle"
                            data-feather="align-center"></i></div>
                </div>

                <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                    <ul class="nav-menus">

                        <li class="profile-nav onhover-dropdown pe-0 py-0">
                            <div class="media profile-media">
                                <div class="media-body"><span><?=$_SESSION['namauser_member'];?></span>
                                    <p class="mb-0">Mahasiswa <i class="middle fa fa-angle-down"></i></p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="<?= BASE_URL ?>/mahasiswa/profile"><i data-feather="user"></i><span>Profil
                                        </span></a></li>
                                <li><a href="#" class="mb-control" data-box="#mb-signout"><i data-feather="log-in">
                                        </i><span>Keluar</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper" sidebar-layout="stroke-svg">
                <div>
                    <div class="logo-wrapper"><a href="<?= BASE_URL ?>/mahasiswa"><img class="img-fluid for-light"
                                src="<?= BASE_URL . '/' . DIR_INC; ?>/images/logosim_small.png" alt=""><img
                                class="img-fluid for-dark"
                                src="<?= BASE_URL . '/' . DIR_INC; ?>/images/logosim_small.png" alt=""></a>
                        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid">
                            </i></div>
                    </div>
                    <div class="logo-icon-wrapper"><a href="<?= BASE_URL; ?>/mahasiswa"><img class="img-fluid"
                                src="<?= BASE_URL . '/' . DIR_INC; ?>/images/logombkm.png" alt=""></a>
                    </div>
                    <nav class="sidebar-main">
                        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                        <div id="sidebar-menu">
                            <ul class="sidebar-links" id="simple-bar">
                                <li class="back-btn"><a href="<?= BASE_URL; ?>/mahasiswa"><img class="img-fluid"
                                            src="<?= BASE_URL . '/' . DIR_INC; ?>/images/logombkm.png" alt=""></a>
                                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                            aria-hidden="true"></i></div>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>General</h6>
                                    </div>
                                </li>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= BASE_URL; ?>/mahasiswa">
                                        <svg class="stroke-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-home">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#fill-home">
                                            </use>
                                        </svg><span>Beranda </span></a>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Kelas</h6>
                                    </div>
                                </li>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= BASE_URL; ?>/mahasiswa/kelas">
                                        <svg class="stroke-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-ui-kits">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#fill-ui-kits">
                                            </use>
                                        </svg><span>Kelas Anda</span></a>
                                </li>
                                <!-- <li class="sidebar-main-title">
                                        <div>
                                            <h6>Proses Seleksi</h6>
                                        </div>
                                    </li>
                                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="<?= BASE_URL; ?>/akun/tes">
                                            <svg class="stroke-icon">
                                                <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-to-do">
                                                </use>
                                            </svg>
                                            <svg class="fill-icon">
                                                <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#fill-to-do">
                                                </use>
                                            </svg><span>Tes Kepribadian </span></a>
                                    </li>

                                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="<?= BASE_URL; ?>/akun/wawancara">
                                            <svg class="stroke-icon">
                                                <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-knowledgebase">
                                                </use>
                                            </svg>
                                            <svg class="fill-icon">
                                                <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#fill-knowledgebase">
                                                </use>
                                            </svg><span>Wawancara</span></a>
                                    </li>

                                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="<?= BASE_URL; ?>/akun/hasilseleksi">
                                            <svg class="stroke-icon">
                                                <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-form">
                                                </use>
                                            </svg>
                                            <svg class="fill-icon">
                                                <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#fill-form">
                                                </use>
                                            </svg><span>Hasil Seleksi </span></a>
                                    </li> -->
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Assesment</h6>
                                    </div>
                                </li>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= BASE_URL; ?>/mahasiswa/logbook">
                                        <svg class="stroke-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-table">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#fill-table">
                                            </use>
                                        </svg><span>Log Book</span></a>
                                </li>

                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= BASE_URL; ?>/mahasiswa/penilaian-mingguan">
                                        <svg class="stroke-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-widget">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#fill-widget">
                                            </use>
                                        </svg><span>Penilaian Mingguan DPL</span></a>
                                </li>

                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= BASE_URL; ?>/mahasiswa/laporanakhir">
                                        <svg class="stroke-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-bonus-kit">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#fill-bonus-kit">
                                            </use>
                                        </svg><span>Laporan Akhir</span></a>
                                </li>

                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Account</h6>
                                    </div>
                                </li>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="<?= BASE_URL; ?>/mahasiswa/profile">
                                        <svg class="stroke-icon">
                                            <use
                                                href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-user">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#fill-user">
                                            </use>
                                        </svg><span>Profil Anda</span></a>
                                </li>
                                <li class="sidebar-list"><a href="#"
                                        class="sidebar-link sidebar-title link-nav mb-control" data-box="#mb-signout">
                                        <svg class="stroke-icon">
                                            <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#stroke-faq">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="<?= BASE_URL . '/' . DIR_INC; ?>/svg/icon-sprite.svg#fill-faq">
                                            </use>
                                        </svg><span>Keluar</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </nav>
                </div>

            </div>
            <?php } ?>


            <!-- CONTENT -->
            <?= $this->section('content'); ?>
            <!-- END CONTENT -->


            <?php if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) { ?>
            <?php } else { ?>
            <!-- END PAGE CONTENT -->
            <footer class="footer footer-fix">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright 2023 © Universitas Fajar by Zagi </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- END PAGE CONTAINER -->
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Apakah Anda yakin untuk keluar dari aplikasi?</p>
                        <p>Tekan Tidak jika Anda masih ingin di dalam aplikasi. Tekan Ya untuk keluar dari aplikasi.
                        </p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="<?= BASE_URL; ?>/mahasiswa/logout" class="btn btn-success btn-lg">Ya</a>
                            <button class="btn btn-danger btn-lg mb-control-close">Tidak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->
        <?php } ?>
        <!-- START SCRIPTS -->

        <script type="text/javascript">
        var BASE_URL = '<?=BASE_URL;?>';
        </script>
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/jquery.min.js"></script>
        <!-- Bootstrap js-->
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/bootstrap/bootstrap.bundle.min.js"></script>
        <!-- feather icon js-->
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/icons/feather-icon/feather.min.js"></script>
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/icons/feather-icon/feather-icon.js"></script>
        <!-- scrollbar js-->
        <?php if (empty($_SESSION['namauser_member']) and empty($_SESSION['passuser_member']) and empty($_SESSION['login_member'])) { ?>
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/script-login.js"></script>
        <?php } else { ?>
        <!-- scrollbar js-->
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/scrollbar/simplebar.js"></script>
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/scrollbar/custom.js"></script>

        <!-- Plugins JS start-->
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/sidebar-menu.js"></script>
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/datatable/datatables/jquery.dataTables.min.js"></script>
        <script
            src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/datatable/datatable-extension/dataTables.bootstrap4.min.js">
        </script>
        <script
            src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/datatable/datatable-extension/dataTables.responsive.min.js">
        </script>
        <script
            src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/datatable/datatable-extension/responsive.bootstrap4.min.js">
        </script>
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/tooltip-init.js"></script>s

        <!-- Plugins JS Ends-->

        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/script.js"></script>
        <script src="<?= BASE_URL . '/' . DIR_INC; ?>/akun/js/page-script/<?=$this->e($page_name);?>.js"></script>
        <?php } ?>

        <!-- END SCRIPTS -->
</body>

</html>