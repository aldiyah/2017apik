<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$status = array('Draft', 'Pengajuan', 'Proses', 'Selesai');
//var_dump($skpb);
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">                                
                <h3 class="panel-title">Laporan <?php echo $header_title; ?></h3>
            </div>
            <div class="panel-body">
                <table>
                    <tr>
                        <td>Nama Kegiatan</td>
                        <td>:</td>
                        <td><?php echo $skpt->skpt_kegiatan ?></td>
                    </tr>
                    <tr>
                        <td>Periode Tahun</td>
                        <td>:</td>
                        <td><?php echo $skpt->skpt_tahun ?></td>
                    </tr>
                    <tr>
                        <td>Lama Kegiatan</td>
                        <td>:</td>
                        <td><?php echo $skpt->skpt_waktu ?> bulan</td>
                    </tr>
                    <tr>
                        <td>Output Kegiatan</td>
                        <td>:</td>
                        <td><?php echo $skpt->kuantitas ?></td>
                    </tr>
                    <tr>
                        <td>Biaya Kegiatan</td>
                        <td>:</td>
                        <td><?php echo rupiah_display($skpt->biaya, 0) ?></td>
                    </tr>
                    <tr>
                        <td>Status Kegiatan</td>
                        <td>:</td>
                        <td><?php echo $status[$skpt->skpt_status] ?></td>
                    </tr>
                </table>
                <hr>
                <table class="table table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">Bulan</th>
                            <th colspan="2">Sasaran Kerja</th>
                            <th colspan="2">Realisasi</th>
                            <th rowspan="2">Kualitas</th>
                        </tr>
                        <tr>
                            <th>Kuantitas</th>
                            <th>Biaya</th>
                            <th>Kuantitas</th>
                            <th>Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($skpb): ?>
                            <?php foreach ($skpb as $row) : ?>
                                <tr>
                                    <td><?php echo array_month($row->skpb_bulan); ?></td>
                                    <td class="text-center"><?php echo $row->skpb_kuantitas; ?></td>
                                    <td class="text-right"><?php echo rupiah_display($row->skpb_biaya, 0); ?></td>
                                    <td class="text-center"><?php echo $row->skpb_real_kuantitas; ?></td>
                                    <td class="text-right"><?php echo rupiah_display($row->skpb_real_biaya, 0); ?></td>
                                    <td class="text-center"><?php echo intval($row->skpb_kualitas); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Belum ada sasaran kerja bulanan...!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <form method="POST">
                    <?php echo form_hidden('skpt_id', $skpt->skpt_id); ?>
                    <div class="pull-right">
                        <input type="submit" name="tolak" class="btn-danger btn" value="Tolak">
                        <input type="submit" name="setuju" class="btn-success btn" value="Setuju">
                    </div>
                    <a href="<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
