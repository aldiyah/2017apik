<?php
/**
 * Aplikasi Penilaian Kinerja (APIK)
 * Pemerintahan Kota Tangerang Selatan Provinsi Banten
 *
 * @author Rinaldi
 */
$online = TRUE;
if ($online) {
    header('Location: http://' . $_SERVER['SERVER_NAME'] . '/' . 'aktivitas');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <title>APIK Tangerang Selatan</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Aplikasi Penilaian Kinerja Pegawai Tangerang Selatan" />
        <meta name="author" content="BKPP Tangerang Selatan" />
        <link rel="icon" href="_assets/img/atlant/favicon.ico" type="image/x-icon" />
        <link rel="apple-touch-icon" sizes="57x57" href="_assets/img/atlant/ico/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="_assets/img/atlant/ico/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="_assets/img/atlant/ico/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="_assets/img/atlant/ico/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="_assets/img/atlant/ico/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="_assets/img/atlant/ico/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="_assets/img/atlant/ico/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="_assets/img/atlant/ico/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="_assets/img/atlant/ico/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="_assets/img/atlant/ico/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="_assets/img/atlant/ico/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="_assets/img/atlant/ico/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="_assets/img/atlant/ico/favicon-16x16.png">
        <link rel="manifest" href="_assets/img/atlant/ico/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="_assets/img/atlant/ico/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" type="text/css" id="theme" href="_assets/css/atlant/theme-night.css"/>
        <style>
            body {
                background: #99ccff;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="panel panel-danger" style="margin-top: 50px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Pemeliharaan Sistem</h3>
                </div>
                <div class="panel-body">
                    Maaf, kami sedang melakukan pemeliharaan sistem. Silahkan datang kembali dalam beberapa menit lagi.
                </div>
                <div class="panel-footer">
                    <span class="pull-right">APIK Tangerang Selatan &copy; 2018</span>
                </div>
            </div>
        </div>
    </body>
</html>