<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta http-equiv="Copyright" content="<?= CONF_STRUCTURE; ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="Log In Panel <?= CONF_STRUCTURE; ?>" />
    <meta name="generator" content="<?= CONF_STRUCTURE; ?> <?= CONF_VER; ?>.<?= CONF_BUILD; ?>" />
    <meta name="author" content="Zagitanank" />
    <meta name="language" content="Indonesia" />
    <meta name="revisit-after" content="7" />
    <meta name="webcrawlers" content="all" />
    <meta name="rating" content="general" />
    <meta name="spiders" content="all" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->
    <title>PENERIMAAN DITUTUP</title>
    <link rel="shortcut icon" href="<?= BASE_URL; ?>/<?= DIR_INC; ?>/images/favicon.png" />

    <link type="text/css" rel="stylesheet" href="<?= BASE_URL; ?>/<?= DIR_INC; ?>/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?= BASE_URL; ?>/<?= DIR_INC; ?>/css/font-awesome.min.css" />

    <script type="text/javascript" src="<?= BASE_URL; ?>/<?= DIR_INC; ?>/js/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>/<?= DIR_INC; ?>/js/bootstrap/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body {
            background-color: #f1f1f1;
            text-align: center;
            padding: 150px 30px;
        }

        h1 {
            letter-spacing: -1px;
            line-height: 60px;
            font-size: 40px;
        }

        body {
            font: 20px "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #666666;
        }

        article {
            display: block;
            text-align: left;
            margin: 0 auto;
        }

        a {
            color: #4183c4;
            text-decoration: none;
        }

        a:hover {
            color: #666666;
            text-decoration: none;
        }

        .text-small {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <style>
        body {
            background-color: #f1f1f1;
            text-align: center;
            padding: 150px 30px;
        }

        h1 {
            letter-spacing: -1px;
            line-height: 60px;
            font-size: 40px;
        }

        body {
            font: 20px "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #666666;
        }

        article {
            display: block;
            text-align: left;
            margin: 0 auto;
        }

        a {
            color: #4183c4;
            text-decoration: none;
        }

        a:hover {
            color: #666666;
            text-decoration: none;
        }

        .text-small {
            font-size: 18px;
        }
    </style>
    <?php
        $notelp = preg_replace('/^0?/', '+62', $this->pocore()->call->posetting[6]['value']);
        $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
        $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
        $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
        $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
    ?>
    <!--
    <article class="col-md-8 col-md-offset-2 text-center">
        <h1>Mohon Maaf!</h1>
        <div>
            <p>Pendaftaran secara online mulai dibuka tanggal <strong>1 April 2022</strong>. <br>Untuk informasi lebih lanjut silahkan datang langsung ke kampus Unifa, Gedung Rektorat Lt. 1. Jl. Prof. Abdurrahman Basalamah 101. Makassar atau menghubungi Panitia Penerimaan Mahasiswa Baru via Whatsapp/Telphone pada kontak di bawah ini:<br>
            
            </p>
            <div class="d-none d-xl-block col-xl-2 bd-toc">
                <?php
                 if ($iphone || $android || $palmpre || $ipod || $berry == true)
                 {
                ?>
                <a href="https://api.whatsapp.com/send?phone=$notelp&text=Hai,%20Universitas%20Fajar.%20Saya%20ingin%20menanyakan%20seputar%20penerimaan%20mahasiswa%20baru." class="btn btn-primary"><i class="fa fa-phone"></i> Ibu Feby : <?=$this->pocore()->call->posetting[6]['value'];?></a>
                <?php }else{ ?>
                <a href="https://web.whatsapp.com/send?phone=$notelp&text=Hai,%20Universitas%20Fajar.%20Saya%20ingin%20menanyakan%20seputar%20penerimaan%20mahasiswa%20baru." class="btn btn-primary"><i class="fa fa-phone"></i> Ibu Feby : <?=$this->pocore()->call->posetting[6]['value'];?></a>
                <?php } ?>
            </div>
        </div>
        <div id="fixedban" style="position:fixed; bottom:0; right:25px; z-index: 100;-webkit-transform:translateZ(0);">
    <?php
       
        // check if is a mobile
        if ($iphone || $android || $palmpre || $ipod || $berry == true)
        {
         echo"<a href='https://api.whatsapp.com/send?phone=$notelp&text=Hai,%20Universitas%20Fajar.%20Saya%20ingin%20menanyakan%20seputar%20penerimaan%20mahasiswa%20baru.' target='_blank'><img src='".BASE_URL."/".DIR_INC."/images/hallo.gif' width='140'></a>";
        }
        // all others
        else {
         echo"<a href='https://web.whatsapp.com/send?phone=$notelp&text=Hai,%20Universitas%20Fajar.%20Saya%20ingin%20menanyakan%20seputar%20penerimaan%20mahasiswa%20baru.' target='_blank'><img src='".BASE_URL."/".DIR_INC."/images/hallo.gif' width='140'></a>";
        }
    ?>
</div>
    </article>
-->
<article class="col-md-8 col-md-offset-2 text-center">
        <h1>Mohon Maaf!</h1>
        <div>
            <p>Pendaftaran Mahasiswa Baru telah ditutup, silahkan kembali ditahun ajaran ke depan.</p>
</div>
    </article>
</body>

</html>