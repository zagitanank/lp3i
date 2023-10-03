<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= $this->e($page_desc); ?>">
    <meta name="keywords" content="<?= $this->e($page_key); ?>" />
    <meta name="language" content="in,en" />
    <meta name="distribution" content="Global" />
    <meta name="rating" content="General" />
    <meta name="robots" content="index,follow" />
    <meta name="googlebot" content="index,follow" />

    <meta name="title" property="og:title" content="<?= $this->e($page_title); ?>" />
    <meta name="keywords" content="<?= $this->e($page_key); ?>" />
    <meta name="description" property="og:description" content="<?= $this->e($page_desc); ?>" />
    <meta name="image" property="og:image" content="<?= BASE_URL . '/' . DIR_INC; ?>/images/favicon.png" />


    <!-- ========== Page Title ========== -->
    <title><?= $this->e($page_title); ?></title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="<?= BASE_URL . '/' . DIR_INC; ?>/images/favicon.png" type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
    <link href="<?= $this->asset('/assets/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/fonts/fontawesome-pro/css/font-awesome.min.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/aos.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/swiper-bundle.min.css') ?>" rel="stylesheet" />
    <link href="<?= $this->asset('/assets/css/main.css') ?>" rel="stylesheet" />
    <!-- ========== End Stylesheet ========== -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- ========== Google Fonts ========== -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet"> -->

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
    <script src="<?= $this->asset('/assets/js/jquery-3.5.1.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/sweetalert.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/aos.js') ?>"></script>
    <script>
        AOS.init();
    </script>
    <script src="<?= $this->asset('/assets/js/swiper-bundle.min.js') ?>"></script>
    <script src="<?= $this->asset('/assets/js/main.js') ?>"></script>

</body>


</html>