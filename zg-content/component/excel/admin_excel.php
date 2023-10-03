<?php

/**
 * Fungsi ini digunakan untuk mencegah file ini diakses langsung tanpa melalui router.
 *
 * This function use for prevent this file accessed directly without going through a router.
 *
 */
if (!defined('CONF_STRUCTURE')) {
    header('location:index.html');
    exit;
}

/**
 * Fungsi ini digunakan untuk mencegah file ini diakses langsung tanpa login akses terlebih dahulu.
 *
 * This function use for prevent this file accessed directly without access login first.
 *
 */

if (empty($_SESSION['namauser']) and empty($_SESSION['passuser']) and $_SESSION['login'] == 0) {
    header('location:index.php');
    exit;
}

include_once '../zg-includes/core/config.php';
include_once '../zg-includes/core/core.php';

$laporan = new PoCore();

if ($_POST['laporan'] == '1') {
    //Rekap Pembayaran Registrasi Akun
    include_once dirname(__FILE__) . '/laporan_1.php';
} elseif ($_POST['laporan'] == '2') {
    //Laporan Data Lulus Seleksi
    include_once dirname(__FILE__) . '/laporan_2.php';
} elseif ($_POST['laporan'] == '3') {
    //Laporan Data Pendaftar Verifikasi Berkas
    include_once dirname(__FILE__) . '/laporan_3.php';
} elseif ($_POST['laporan'] == '4') {
    //Daftar Perkembangan Calon Mahasiswa Baru
    include_once dirname(__FILE__) . '/laporan_4.php';
} elseif ($_POST['laporan'] == '5') {
    //Daftar Wawancara Calon Mahasiswa Baru
    include_once dirname(__FILE__) . '/laporan_5.php';
} elseif ($_POST['laporan'] == '6') {
    //Daftar Calon Mahasiswa Baru Bayar Daftar Ulang
    include_once dirname(__FILE__) . '/laporan_6.php';
} elseif ($_POST['laporan'] == '7') {
    //Daftar Calon Mahasiswa Baru Belum Bayar Daftar Ulang
    include_once dirname(__FILE__) . '/laporan_7.php';
} elseif ($_POST['laporan'] == '8') {
    //Daftar Belum Bayar Registrasi Formulir
    include_once dirname(__FILE__) . '/laporan_8.php';
} else {
    echo $laporan->pohtml->error();
}
exit;
