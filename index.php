<?php
/**
 * Aplikasi Penilaian Kinerja (APIK)
 * Pemerintahan Kota Tangerang Selatan Provinsi Banten
 *
 * @author Rinaldi
 */
header('Location: http://'. $_SERVER['SERVER_NAME'] . '/' . 'aktivitas');
//var_dump($_SERVER);
//echo $_SERVER['SERVER_NAME'] . '/' . 'aktivitas';
?>
<h3>Aplikasi Penilaian Kinerja (APIK)</h3>
<ul>
    <li><a href="presensi" target="_blank">Presensi</a></li>
    <li><a href="aktivitas" target="_blank">Aktifitas Harian</a></li>
    <li><a href="ppk" target="_blank">SKP</a></li>
</ul>