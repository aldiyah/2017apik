<?php
$tpp_pegawai = $tpp_presensi + $tpp_aktivitas + $tpp_ppk;
$tpp_pegawai_top = $tpp_presensi_top + $tpp_aktivitas_top + $tpp_ppk_top;
?>
<div class="page-content-wrap" style="padding-bottom: 10px;">
    <div class="page-content-holder">
        <div class="row">
            <div class="col-md-4">
                <div class="profile xn-profile boxshadow">
                    <div class="profile-image" style="border:none;">
                        <img style="border:none;" src="<?php echo isset($active_user_detail['user_foto'])? $active_user_detail['user_foto'] : upload_location("images/users/user_default_avatar.jpg"); ?>" alt="<?php echo $current_user_profil_name; ?>"/>
                    </div>
                    <div class="profile-data">
                        <div class="profile-data-name" style="font-size: 13px;font-weight: bold;color: #e0401d;"><?php echo $current_user_profil_name; ?></div>
                        <div class="profile-data-name" style="font-weight: bold;">NIP. <?php echo isset($active_user_detail['pegawai_nip']) ? $active_user_detail['pegawai_nip'] : '-'; ?></div>
                        <div class="profile-data-name"><?php echo ucwords(strtolower(isset($active_user_detail['nama_jabatan']) ? $active_user_detail['nama_jabatan'] : '')); ?></div>
                        <!--<div class="profile-data-name"><?php echo ucwords(strtolower($active_user_detail['nama_unit_organisasi'])); ?></div>-->
                        <!--<div class="profile-data-name"><?php echo ucwords(strtolower(isset($active_user_detail['nama_satuan_organisasi']) ? $active_user_detail['nama_satuan_organisasi'] : '')); ?></div>-->
                        <div class="profile-data-name"><?php echo ucwords(strtolower(isset($active_user_detail['nama_organisasi']) ? $active_user_detail['nama_organisasi'] : '')); ?></div>
                        <!--<div class="profile-data-name"><?php echo ucwords(strtolower(isset($active_user_detail['nama_instansi']) ? $active_user_detail['nama_instansi'] : '')); ?></div>-->
                    </div>
                    <div class="profile-controls">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="boxshadow">
                    <h3 style="border-bottom: 1px dashed #aaa;padding-bottom: 5px;">
                        <strong><?php show_greeting(); ?></strong>
                        <a href="<?php echo base_url("logout") ?>" class="btn btn-primary pull-right">KELUAR</a>
                    </h3>
                    <div class="block-heading-text">
                        Mudah, Tepat dan Cepat untuk Kota Tangerang Selatan.
                    </div>
                </div>
                <div class="boxshadow">
                    <h3 style="border-bottom: 1px dashed #aaa;padding-bottom: 5px;">
                        <strong>Estimasi TPP</strong>
                        <span class="pull-right"><strong>Rp. <?php echo number_format($tpp_pegawai, 0, ',', '.') ?></strong></span>
                    </h3>
                    <div class="block-heading-text">
                        Estimasi TPP bulan ini sampai dengan tanggal <?php echo date("d-m-Y"); ?>
                    </div>
                    <div style="border-top: 1px dashed #aaa;margin-top: 10px;padding-top: 5px;font-weight: bold;color: #0000ff;font-size: large;">
                        Max. TPP
                        <span class="pull-right"><strong>Rp. <?php echo number_format($tpp_pegawai_top, 0, ',', '.') ?></strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="background: rgba(250, 250, 150, 0.5);clear: both;border-bottom: 1px solid #c1c1c1;">
    <marquee style="padding: 15px 0; color: #ff0000; font-size: 18px; text-shadow: 0 0 5px #fff;">
        <strong>Pengumuman : </strong>Jum'at, 24-NOVEMBER-2017 Akan dilaksanakan Apel Gabungan dalam rangka "Memperingati HUT Kota Tangerang Selatan". Tempat : Lapangan Cilenggang. Pakaian : Batik KOPRI.
    </marquee>
</div>
<div class="page-content-wrap" style="min-height: 200px;background: rgba(255, 255, 255, 0.5);">
    <!-- page content holder -->
    <div class="page-content-holder padding-v-30">
        <!--        <div class="row">
                    <marquee style="padding: 15px 0; color: #ec0850; font-size: 18px; text-shadow: 0 0 5px #fff;background: #99ffff;">
                        <strong>Pengumuman : </strong>Jum'at, 24-NOVEMBER-2017 Akan dilaksanakan Apel Gabungan dalam rangka "Memperingati HUT Kota Tangerang Selatan". Tempat : Lapangan Cilenggang. Pakaian : Batik KOPRI.
                    </marquee>
                </div>-->
        <div class="row">
            <div class="col-md-4">

                <div class="pricing-block">                                    
                    <div class="pb-block">
                        <h3>
                            TPP Presensi
                            <span class="pull-right">Rp. <?php echo number_format($tpp_presensi, 0, ',', '.') ?></span>
                        </h3>
                    </div>
                    <div class="pb-block">
                        <p>TPP dari <strong>Absensi Harian dan Upacara</strong></p>
                    </div>
                    <div class="pb-block" style="font-weight: bold;color: #0000ff;">
                        Max. TPP Presensi
                        <span class="pull-right">Rp. <?php echo number_format($tpp_presensi_top, 0, ',', '.') ?></span>
                    </div>
                    <div class="pb-block">
                        <a href="<?php echo base_url("back_end/home/to_presensi") ?>" class="btn btn-block btn-primary">MASUK</a>
                    </div>
                </div>

            </div>
            <div class="col-md-4">

                <div class="pricing-block">                                    
                    <div class="pb-block">
                        <h3>
                            TPP Aktivitas
                            <span class="pull-right">Rp. <?php echo number_format($tpp_aktivitas, 0, ',', '.') ?></span>
                        </h3>
                    </div>
                    <div class="pb-block">
                        <p>TPP dari <strong>Aktivitas Harian</strong></p>
                    </div>
                    <div class="pb-block" style="font-weight: bold;color: #0000ff;">
                        Max. TPP Aktivitas
                        <span class="pull-right">Rp. <?php echo number_format($tpp_aktivitas_top, 0, ',', '.') ?></span>
                    </div>
                    <div class="pb-block">
                        <a href="<?php echo base_url("back_end/home/to_aktivitas") ?>" class="btn btn-block btn-primary">MASUK</a>
                    </div>
                </div>

            </div>
            <div class="col-md-4">

                <div class="pricing-block">                                    
                    <div class="pb-block">
                        <h3>
                            TPP PPK
                            <span class="pull-right">Rp. <?php echo number_format($tpp_ppk, 0, ',', '.') ?></span>
                        </h3>
                    </div>
                    <div class="pb-block">
                        <p>TPP dari <strong>SKP Bulanan</strong> dan <strong>Penilaian Perilaku</strong></p>
                    </div>
                    <div class="pb-block" style="font-weight: bold;color: #0000ff;">
                        Max. TPP PPK
                        <span class="pull-right">Rp. <?php echo number_format($tpp_ppk_top, 0, ',', '.') ?></span>
                    </div>
                    <div class="pb-block">
                        <a href="<?php echo base_url("back_end/home/to_ppk") ?>" class="btn btn-block btn-primary">MASUK</a>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- ./page content holder -->
</div>