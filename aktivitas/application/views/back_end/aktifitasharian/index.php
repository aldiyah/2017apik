<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$status = array('Pengajuan', 'Diterima', 'Ditolak');
//var_dump($records);
//exit();
?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default padding-bottom-0">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">Kalender</h3>
                </div>
                <div class="panel-body">
                    <div class="calendar">                                
                        <div id="calendar"></div>                            
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Daftar Aktivitas Harian Tanggal <?php echo string_to_date($tanggal) ?></h3>
                </div>
                <div class="panel-body">
                    <?php if ($absensi): ?>
                        <div class="clearfix" style="margin-bottom: 10px;">
                            <div class="btn-group btn-group-sm pull-right">
                                <a href="<?php echo base_url("back_end/" . $active_modul . '/detail/' . $tanggal); ?>" class="btn btn-default">Tambah</a>
                                <a href="<?php echo base_url("back_end/" . $active_modul . '/rkbulanan/' . string_to_date($tanggal, 'Y') . '/' . string_to_date($tanggal, 'n')); ?>" class="btn btn-default">Rekap Bulan <?php echo ucfirst(array_month(string_to_date($tanggal, 'n'), TRUE)) . ' ' . string_to_date($tanggal, 'Y'); ?></a>
                            </div>
                            Daftar aktivitas Anda pada tanggal <?php echo string_to_date($tanggal); ?>
                        </div>
                        <?php if ($records): ?>
                            <?php echo load_partial("back_end/shared/attention_message"); ?>
                            <div class="table-responsive">
                                <table class="table table-condensed table-bordered table-top">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Aktifitas</th>
                                            <th>Lama</th>
                                            <th>Output</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($records as $data) : ?>
                                            <tr<?php echo ($data->tr_aktifitas_status == 1 ? ' class="success"' : ($data->tr_aktifitas_status == 2 ? ' class="danger"' : '')); ?>>
                                                <td class="text-right"><?php echo $next_list_number++; ?></td>
                                                <td><?php echo beautify_str($data->aktifitas_nama); ?>
                                                    <?php if (trim($data->tr_aktifitas_dokumen) != ""): ?>
                                                        <br />
                                                        <a href="<?php echo base_url() . "_assets/uploads/aktifitas/" . $data->tr_aktifitas_id . "/" . $data->tr_aktifitas_dokumen; ?>" target="_blank"><span class="fa fa-download"></span> Lihat Dokumen Pendukung</a>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><?php echo $data->aktifitas_waktu * $data->tr_aktifitas_volume; ?> menit</td>
                                                <td class="text-center"><?php echo $data->tr_aktifitas_volume . " " . ucwords($data->aktifitas_output) ?></td>
                                                <td class="text-center"><?php echo $status[$data->tr_aktifitas_status]; ?></td>
                                                <td class="text-center">
                                                    <!--<div class="btn-group btn-group-sm btn-group-icon">-->
                                                    <div class="btn-group btn-group-sm">
                                                        <?php
                                                        if ($data->tr_aktifitas_status == 0) {
//                                                        echo anchor(backend_url('aktifitasharian/detail/' . $tanggal . '/' . $data->tr_aktifitas_id), '<span class="fa fa-edit"></span> Ubah', 'class="btn btn-default"');
                                                            echo anchor(backend_url('aktifitasharian/detail/' . $tanggal . '/' . $data->tr_aktifitas_id), 'Ubah', 'class="btn btn-default"');
                                                        } else {
//                                                    echo anchor(backend_url('aktifitasharian/lihat/' . $tanggal . '/' . $data->tr_aktifitas_id), '<span class="fa fa-fa-check"></span>', 'class="btn btn-default"');
//                                                        echo '<button class="btn btn-default"><span class="fa fa-check"></span></button>';
                                                            echo '-';
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            Belum ada aktifitas...
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    Maaf, Anda tidak hadir pada tanggal <?php echo string_to_date($tanggal) ?>. Silahkan menguhubungi admin Kepegawaian anda.
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
