<?php
$is_authenticated = isset($is_authenticated) ? $is_authenticated : FALSE;
$active_modul = isset($active_modul) ? $active_modul : "";
$current_user_profil_name = isset($current_user_profil_name) ? $current_user_profil_name : "-";
$current_user_roles = isset($current_user_roles) ? $current_user_roles : "pengguna";
$menu_item = isset($menu_item) ? build_atlant_menu($menu_item, $active_modul) : "";
$pegawai_avatar = isset($active_user_detail) && is_array($active_user_detail) && array_key_exists("pegawai_nip", $active_user_detail) && !is_null($active_user_detail["pegawai_nip"]) ? $active_user_detail["pegawai_nip"] : "user_default_avatar";
?>

<ul class="x-navigation">
    <li class="xn-logo">
        <a href="<?php echo base_url(); ?>">BKPP</a>
        <a href="#" class="x-navigation-control"></a>
    </li>
    <li class="xn-profile">
        <?php if ($is_authenticated): ?>
            <div class="profile">
                <div class="profile-image" style="border:none;">
                    <img style="border:none;" src="<?php echo (remote_file_exists(upload_location("images/users/" . $pegawai_avatar . ".jpg")) ? upload_location("images/users/" . $pegawai_avatar . ".jpg") : upload_location("images/users/user_default_avatar.jpg")) ?>" alt="<?php echo $current_user_profil_name ?>"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name" style="font-weight: bold;"><?php echo $current_user_profil_name; ?></div>
                    <div class="profile-data-name" style="font-size: 11px;">NIP. <?php echo isset($user_detail['pegawai_nip']) ? $user_detail['pegawai_nip'] : ''; ?></div>
                    <div class="profile-data-name" style="font-size: 11px;"><?php echo ucwords(strtolower(isset($user_detail['nama_jabatan']) ? $user_detail['nama_jabatan'] : '')); ?></div>
                </div>
                <div class="profile-controls">
                    <?php /*
                      <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                      <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                     * 
                     */
                    ?>
                </div>
            </div>
        <?php else: ?>
            <a href="#" class="profile-mini">
                <img src="<?php echo upload_location("images/users/user_default_avatar.jpg"); ?>" alt="User"/>
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="<?php echo upload_location("images/users/user_default_avatar.jpg"); ?>" alt="User"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">User</div>
                    <div class="profile-data-title">Tamu</div>
                </div>
            </div>
        <?php endif ?>                                                                        
    </li>
    <li class="xn-title">Menu Utama</li>
    <?php
    if (strtolower(trim($active_modul)) == 'home') {
        echo '<li class="active"><a href="' . base_url() . '"><span class="fa fa-circle-o"></span> Beranda</span></a></li>';
    } else {
        echo '<li><a href="' . base_url() . '"><span class="fa fa-circle-o"></span> Beranda</span></a></li>';
    }
    ?>
    <?php echo $menu_item; ?>
    <li class="xn-title">Aplikasi Lain</li>
        <?php echo '<li><a href="' . base_url() . 'back_end/home/to_presensi"><span class="fa fa-calendar"></span> Aplikasi Presensi</span></a></li>'; ?>
        <?php echo '<li><a href="' . base_url() . 'back_end/home/to_ppk"><span class="fa fa-book"></span> Aplikasi PPK</span></a></li>'; ?>
</ul>