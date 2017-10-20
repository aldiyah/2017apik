<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$total_record = isset($total_record) ? $total_record : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$status = array('Draft', 'Pengajuan', 'Proses', 'Selesai');
//var_dump($access_rules);
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">                                
                <h3 class="panel-title"><?php echo $header_title; ?></h3>
            </div>
            <div class="panel-body">
                <?php echo load_partial("back_end/shared/attention_message"); ?>
                <form class="form-panel">
                    <div>
                        <div class="input-group">
                            <input type="text" name="keyword" style="width: calc(100% - 55px);" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                            <?php echo dropdown_tahun('tahun', $tahun, 5, 'class="form-control" style="width: 55px;"') ?>
                            <div class="input-group-btn">
                                <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                                <a href="<?php echo base_url('back_end/' . $active_modul . '/laporan'); ?>" class="btn btn-default"><span class="fa fa-print"></span> Laporan</a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Tahun</th>
                                <th>Lama</th>
                                <th>Kuantitas</th>
                                <th>Biaya</th>
                                <th>Kualitas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($records): ?>
                                <?php foreach ($records as $row) : ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++; ?></td>
                                        <td><?php echo $row->skpt_kegiatan; ?></td>
                                        <td class="text-center"><?php echo $row->skpt_tahun; ?></td>
                                        <td class="text-center"><?php echo $row->skpt_waktu; ?></td>
                                        <td class="text-center"><?php echo $row->real_kuantitas . '/' . $row->kuantitas; ?></td>
                                        <td class="text-right"><span class="pull-left">Rp. </span><?php echo _format_number($row->real_biaya, 0) . '/' . _format_number($row->biaya, 0); ?></td>
                                        <td class="text-center"><?php echo number_format($row->kualitas / $row->skpt_waktu, 2, ',', '.'); ?></td>
                                        <td class="text-center"><?php echo $status[$row->skpt_status]; ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/read") . "/" . $row->skpt_id; ?>">Lihat</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9">Belum ada data...!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    Total ada <?php echo $total_record ?> data.
                </div>
            </div>
        </div>
    </div>
</div>
