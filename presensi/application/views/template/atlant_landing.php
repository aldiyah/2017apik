<?php
$app_author = isset($app_author) ? $app_author : 'Lahir Wisada Santoso';
$global_search_action = isset($global_search_action) ? $global_search_action : "#";
$page_title = isset($page_title) ? $page_title : "My Application";
$app_name = isset($app_name) ? $app_name : "My Application";

$site_description = isset($site_description) ? $site_description : "";
$site_keyword = isset($site_keyword) ? $site_keyword : "";

$view_js_default = isset($js_default) ? $js_default : '';
$view_css_default = isset($css_default) ? $css_default : '';

$template_body_class = isset($template_body_class) ? $template_body_class : '';

$is_authenticated = isset($is_authenticated) ? $is_authenticated : FALSE;

/**
 * User information
 */
$target_sub_page = isset($target_sub_page) ? $target_sub_page : FALSE;
$slogan = isset($slogan) ? $slogan : FALSE;

$currentusername = isset($currentusername) ? $currentusername : "Tidak Dikenal";
$current_user_profil_name = isset($current_user_profil_name) ? $current_user_profil_name : "Tidak Dikenal";
$current_user_roles = isset($current_user_roles) ? $current_user_roles : "Tamu";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title><?php echo $page_title; ?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="<?php echo $site_description; ?>" />
        <meta name="author" content="<?php echo $app_author; ?>" />

        <link rel="icon" href="<?php echo img(); ?>atlant/favicon.ico" type="image/x-icon" />

        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo img(); ?>atlant/ico/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo img(); ?>atlant/ico/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo img(); ?>atlant/ico/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo img(); ?>atlant/ico/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo img(); ?>atlant/ico/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo img(); ?>atlant/ico/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo img(); ?>atlant/ico/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo img(); ?>atlant/ico/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo img(); ?>atlant/ico/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo img(); ?>atlant/ico/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo img(); ?>atlant/ico/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo img(); ?>atlant/ico/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo img(); ?>atlant/ico/favicon-16x16.png">
        <link rel="manifest" href="<?php echo img(); ?>atlant/ico/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo img(); ?>atlant/ico/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <!-- END META SECTION -->

        <link rel="stylesheet" type="text/css" href="<?php echo css(); ?>atlant_landing/revolution-slider/extralayers.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo css(); ?>atlant_landing/revolution-slider/settings.css" media="screen" />

        <link rel="stylesheet" type="text/css" href="<?php echo css(); ?>atlant_landing/styles.css" media="screen" />                  
        <?php echo isset($css) ? $css : ''; ?>
        <style type="text/css">
            .profile {
                padding: 15px 10px;
                position: relative;
                background: #192233;
            }

            .profile .profile-image {
                float: left;
                width: 100%;
                margin: 0px 0px 10px;
                text-align: center;
            }
            .profile .profile-image img {
                width: 100px;
                border: 3px solid #FFF;
            }
            .profile .profile-data {
                width: 100%;
                text-align: center;
            }
            .xn-profile {
                padding: 0px;
                background: transparent;
                display: block;
                width: 100%;
                padding: 0px;
                margin: 0px;
                position: relative;
            }
            .page-container {
                margin-bottom: 40px;
            }
            .page-container .page-content .page-content-wrap {
                border-bottom: 1px solid #c1c1c1;
            }
            .page-container .page-header {
                text-align: center;
                text-transform: uppercase;
                font-size: 16px;
                font-weight: bold;
                background: rgba(250,250,250,0.5);
                padding: 10px;
                border-bottom: 1px solid #c1c1c1;
            }
            .boxshadow {
                padding: 10px;
                box-shadow: 0 0 3px #999;
                margin-bottom: 10px;
                background: rgba(250,250,250,0.8);
                border-radius: 5px;
            }
            .profile .profile-image {
                height: 120px;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <!-- page container -->
        <div class="page-container">

            <!-- page header -->
            <div class="page-header">

                <!-- page header holder -->
                <div class="page-header-holder">
                    <?php echo $page_title; ?>
                </div>
                <!-- ./page header holder -->

            </div>
            <!-- ./page header -->

            <!-- page content -->
            <div class="page-content">
                <?php echo $content_for_layout; ?>
            </div>
            <!-- ./page content -->

            <!-- page footer -->
            <div class="page-footer" style="position: fixed !important; bottom: 0 !important;">


                <!-- page footer wrap -->
                <div class="page-footer-wrap bg-darken-gray">
                    <!-- page footer holder -->
                    <div class="page-footer-holder">

                        <!-- copyright -->
                        <div class="copyright">
                            &copy; 2017 <a href="#">BKPP</a> Kota Tangerang Selatan
                        </div>
                        <!-- ./copyright -->

                        <!-- social links -->
                        <div class="social-links">
                            <a href="https://www.facebook.com/bkpptangsel"><span class="fa fa-facebook"></span></a>
                            <a href="https://twitter.com/bkpptangsel"><span class="fa fa-twitter"></span></a>
                        </div>                        
                        <!-- ./social links -->

                    </div>
                    <!-- ./page footer holder -->
                </div>
                <!-- ./page footer wrap -->

            </div>
            <!-- ./page footer -->

        </div>        
        <!-- ./page container -->

        <!-- page scripts -->
        <?php echo load_partial('template/atlant_landing/default_scripts'); ?>

        <?php echo isset($js) ? $js : ''; ?>
        <script type="text/javascript" src="<?php echo assets(); ?>js/helper/general_helper.js"></script>
        <?php echo load_partial('template/additional_js'); ?>

        <?php echo $view_js_default; ?>
        <!-- ./page scripts -->
    </body>
</html>