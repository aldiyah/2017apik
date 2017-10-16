<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
//var_dump($records);
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">                                
                <h3 class="panel-title"><?php echo $header_title; ?></h3>
            </div>
            <div class="panel-body">
                <div class="block">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                    <div class="col-md-12">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="keyword" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="block">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-striped table-hover no-footer" id="DataTables_Table_0">
                            <thead>
                                <tr role="row">
                                    <th>No</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Kuantitas</th>
                                    <th>Biaya</th>
                                    <th>Kualitas</th>
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
                                            <td class="text-center"><?php echo array_month($row->skpb_bulan); ?></td>
                                            <td class="text-center"><?php echo $row->skpb_real_kuantitas . '/' . $row->skpb_kuantitas; ?></td>
                                            <td class="text-right"><?php echo _format_number($row->skpb_real_biaya, 0) . '/' . _format_number($row->skpb_biaya, 0); ?></td>
                                            <td class="text-center"><?php echo intval($row->skpb_kualitas); ?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/detail") . "/" . $row->skpb_id; ?>">Lihat Laporan</a>
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
                        <?php echo $paging_set; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
