<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
//var_dump($access_rules);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">                                
                <h3 class="panel-title"><?php echo $header_title . ' ' . array_month($bulan) . ' ' . $tahun ?></h3>
            </div>
            <div class="panel-body">
                <?php echo load_partial("back_end/shared/attention_message"); ?>
                <form class="form-panel">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="keyword" style="width: calc(100% - 145px);" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                            <?php echo form_dropdown('bulan', array_month(), $bulan, 'class="form-control" style="width: 90px;"') ?>
                            <?php echo dropdown_tahun('tahun', $tahun, 5, 'class="form-control" style="width: 55px;"') ?>
                            <div class="input-group-btn">
                                <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-striped table-hover">
                        <thead>
                            <tr role="row">
                                <th>No</th>
                                <th>Pegawai</th>
                                <th>Nilai</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($records != FALSE): ?>
                                <?php foreach ($records as $key => $record): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++ ?></td>
                                        <td><?php echo $record->pegawai_nip . ' - ' . beautify_str($record->pegawai_nama) ?></td>
                                        <td class="text-center"><?php echo number_format($record->tpn, 2, ',', '.') ?></td>
                                        <td class="text-center">
                                            <?php if ($record->tpn > 0): ?>
                                                Penilaian Selesai
                                            <?php else: ?>
                                                <div class="btn-group btn-group-sm">
                                                    <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/penilaian") . "/" . $record->pegawai_id . "/" . $tahun . "/" . $bulan; ?>">Penilaian</a>
                                                    <!--<a class="btn btn-default btn-hapus-roww" href="javascript:void(0);" rel="<?php echo base_url("back_end/" . $active_modul . "/delete") . "/" . $record->pegawai_id; ?>">Hapus</a>-->
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4"> Kosong / Data tidak ditemukan. </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    Total ada <?php echo $total_record ?> data
                </div>
            </div>
        </div>
    </div>
</div>