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

$pegawai_id = isset($pegawai_id) ? $pegawai_id : 9999;

$master_tpp = isset($master_tpp) ? $master_tpp : '24000000';
$total_tpp = isset($total_tpp) ? $total_tpp : $master_tpp;
$total_ditolak = isset($total_ditolak) ? $total_ditolak : ($pegawai_id == '2' || $pegawai_id == '1' ? 0 : 1);
//var_dump($records);
?>
<div class="page-content-wrap">
    <div class="row">
        <!--<a href="<?php echo base_url() . 'back_end/aktifitasharian/rkbulanan'; ?>">-->
        <div class="col-md-6">
            <div class="widget widget-success widget-item-icon">
                <div class="widget-item-left">
                    <span class="fa fa-star"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-int"><?php echo rupiah_display($total_tpp, 0); ?></div>
                    <div class="widget-title">TPP Presensi</div>
                    <div class="widget-subtitle">Estimasi TPP Presensi Anda bulan ini</div>
                </div>
            </div>
        </div>
        <!--</a>-->
        <div class="col-md-6">
            <div class="widget widget-danger widget-item-icon">
                <div class="widget-item-left">
                    <span class="fa fa-tag"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-int"><?php echo _format_number($total_ditolak, 0); ?></div>
                    <div class="widget-title">Presensi Ditolak</div>
                    <div class="widget-subtitle">Jumlah presensi ditolak sampai dengan hari ini</div>
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