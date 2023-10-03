<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= $this->e($page_desc); ?>">
    <meta name="keywords" content="<?= $this->e($page_key); ?>" />




    <!-- ========== Page Title ========== -->
    <title><?= $this->e($page_title); ?></title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="<?= BASE_URL . '/' . DIR_INC; ?>/images/favicon.png" type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
    <link href="<?= $this->asset('/assets/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/font-awesome.min.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/flaticon-set.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/elegant-icons.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/magnific-popup.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/owl.carousel.min.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/owl.theme.default.min.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/animate.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/bootsnav.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/style.css') ?>" rel="stylesheet">
    <link href="<?= $this->asset('/assets/css/responsive.css') ?>" rel="stylesheet" />
    <!-- ========== End Stylesheet ========== -->



    <!-- ========== Google Fonts ========== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">

</head>

<body>

    <!-- Preloader Start 
    <div class="se-pre-con"></div>
     Preloader Ends -->
    <!-- Insert Header -->
    <?= $this->insert('header'); ?>

    <!-- Insert Content -->
    <?= $this->section('content'); ?>

    <!-- Insert Footer -->
    <?= $this->insert('footer'); ?>


    <!-- jQuery Frameworks
    ============================================= -->
    <script src="<?= $this->asset('/assets/js/jquery-1.12.4.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/equal-height.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/jquery.appear.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/jquery.easing.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/jquery.magnific-popup.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/modernizr.custom.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/owl.carousel.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/wow.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/isotope.pkgd.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/imagesloaded.pkgd.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/count-to.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/loopcounter.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/jquery.nice-select.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/bootsnav.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/main.js') ?>"></script>

</body>


</html>