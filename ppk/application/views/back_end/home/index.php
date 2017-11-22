<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$pegawai_nip = isset($pegawai_nip) ? $pegawai_nip : '-';
$total_tpp = isset($total_tpp) ? $total_tpp : 0;
$total_skp_diterima = isset($total_skp_diterima) ? $total_skp_diterima : 0;
$total_skp_ditolak = isset($total_skp_ditolak) ? $total_skp_ditolak : 0;
?>
<div class="page-content-wrap">
    <div class="row">
        <a href="">
        <!--<a href="<?php echo base_url() . 'back_end/aktifitasharian/rkbulanan'; ?>">-->
            <div class="col-md-4">
                <div class="widget widget-success widget-item-icon">
                    <div class="widget-item-left">
                        <span class="fa fa-star"></span>
                    </div>
                    <div class="widget-data">
                        <div class="widget-int">Rp. <?php echo number_format($total_tpp, 0, ',', '.'); ?></div>
                        <div class="widget-title">TPP PPK</div>
                        <div class="widget-subtitle">Estimasi TPP dari PPK Anda bulan ini</div>
                    </div>
                </div>
            </div>
        </a>
        <div class="col-md-4">
            <div class="widget widget-default widget-item-icon">
                <div class="widget-item-left">
                    <span class="fa fa-suitcase"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-int"><?php echo number_format($total_skp_diterima, 0, ',', '.'); ?></div>
                    <div class="widget-title">SKP Bulanan Diterima</div>
                    <div class="widget-subtitle">Jumlah SKP Anda yang diterima bulan ini</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget widget-danger widget-item-icon">
                <div class="widget-item-left">
                    <span class="fa fa-tag"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-int"><?php echo number_format($total_skp_ditolak, 0, ',', '.'); ?></div>
                    <div class="widget-title">SKP Bulanan Ditolak</div>
                    <div class="widget-subtitle">Jumlah SKP Anda yang ditolak bulan ini</div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Pengumuman</h3>
                </div>
                <div class="panel-body">
                    <p>Isi pengumuman...!!!</p>
                </div>
            </div>
        </div>
    </div>
</div>