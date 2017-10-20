<?php
$pegawai_avatar = isset($active_user_detail) && is_array($active_user_detail) && array_key_exists("pegawai_nip", $active_user_detail) && !is_null($active_user_detail["pegawai_nip"]) ? $active_user_detail["pegawai_nip"] : "user_default_avatar";
?>
<div class="page-content-wrap">
    <div class="page-content-holder">
        <div class="block-heading">
            <div class="col-md-4">
                <div class="text-column text-column-centralized this-animate animated fadeIn this-animated" data-animate="fadeIn">

                    <div class="profile xn-profile">
                        <div class="profile-image" style="border:none;">
                            <img style="border:none;" src="<?php echo upload_location("images/users/" . $pegawai_avatar . ".jpg"); ?>" alt="<?php echo $current_user_profil_name; ?>"/>
                        </div>
                        <div class="profile-data">
                            <div class="profile-data-name" style="font-size: 13px;font-weight: bold;"><?php echo $current_user_profil_name; ?></div>
                            <div class="profile-data-name" style="font-weight: bold;">NIP. <?php echo isset($user_detail['pegawai_nip']) ? $user_detail['pegawai_nip'] : '-'; ?></div>
                            <div class="profile-data-name"><?php echo ucwords(strtolower(isset($user_detail['nama_jabatan']) ? $user_detail['nama_jabatan'] : '')); ?></div>
                            <!--<div class="profile-data-name"><?php echo ucwords(strtolower($user_detail['nama_unit_organisasi'])); ?></div>-->
                            <div class="profile-data-name"><?php echo ucwords(strtolower(isset($user_detail['nama_satuan_organisasi']) ? $user_detail['nama_satuan_organisasi'] : '')); ?></div>
                            <div class="profile-data-name"><?php echo ucwords(strtolower(isset($user_detail['nama_organisasi']) ? $user_detail['nama_organisasi'] : '')); ?></div>
                            <div class="profile-data-name"><?php echo ucwords(strtolower(isset($user_detail['nama_instansi']) ? $user_detail['nama_instansi'] : '')); ?></div>
                        </div>
                        <div class="profile-controls">
                        </div>
                    </div>

                    <?php /** <div class="text-column-subtitle">Singer &amp; Songwriter</div> */ ?>
                </div>
            </div>
            <div class="col-md-5">
                <h3><strong><?php show_greeting(); ?></strong></h3>
                <div class="block-heading-text">
                    <small>Mudah, Tepat dan cepat untuk Kota Tangerang Selatan.</small>
                </div>
            </div>
            <!--            <div class="col-md-3">
                            <div class="row">
                                <h2>Rp. 8,000,000,-</h2>
                            </div>
                            <div class="row block-heading-text text-center">
                                Total TPP sampai dengan<br /><?php echo date("d-m-Y"); ?>.
                            </div>
                        </div>-->
        </div>
    </div>
</div>
<div class="page-content-wrap" style="min-height: 280px;background: rgba(255, 255, 255, 0.5);">
    <!-- page content holder -->
    <div class="page-content-holder padding-v-30">

        <div class="row">
            <marquee style="padding-top: 15px; color: #ec0850; font-size: 18px; text-shadow: 0 0 5px #fff;">
                <strong>Pengumuman : </strong>Senin, 30-OKTOBER-2017 Akan dilaksanakan Apel Gabungan dan Apel Hari Sumpah Pemuda. Tempat : Lapangan Cilenggang. Pakaian : PDH Coklat.
            </marquee>
        </div>
        <div class="row">
            <div class="col-md-4">

                <div class="pricing-block">                                    
                    <div class="pb-block">
                        <h3>Aplikasi A</h3>
                    </div>
                    <div class="pb-block">
                        <p>Pergunakan Aplikasi ini untuk mengajukan ijin tidak masuk kantor.</p>
                    </div>
                    <div class="pb-block">
                        <a href="<?php echo base_url('back_end/home/to_presensi'); ?>" class="btn btn-primary btn-block">Menuju Aplikasi</a>
                    </div>
                </div>

            </div>
            <div class="col-md-4">

                <div class="pricing-block">                                    
                    <div class="pb-block">
                        <h3>Aplikasi B</h3>
                    </div>
                    <div class="pb-block">
                        <p>Pergunakan aplikasi ini untuk mencatat aktifitas harian.</p>
                    </div>
                    <div class="pb-block">
                        <a href="<?php echo base_url('back_end/home/to_aktivitas'); ?>" class="btn btn-primary btn-block">Menuju Aplikasi</a>
                    </div>
                </div>

            </div>
            <div class="col-md-4">

                <div class="pricing-block">                                    
                    <div class="pb-block">
                        <h3>Aplikasi C</h3>
                    </div>
                    <div class="pb-block">
                        <p>Gunakan aplikasi ini untuk mencatat Sasaran Kerja Bulanan.</p>
                    </div>
                    <div class="pb-block">
                        <a href="<?php echo base_url('back_end/home/to_ppk'); ?>" class="btn btn-primary btn-block">Menuju Aplikasi</a>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- ./page content holder -->
</div>