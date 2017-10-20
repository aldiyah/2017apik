<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
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
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="keyword" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                                <?php if ($access_rules[1][0] == 'allow'): ?>
                                    <a href="<?php echo base_url('back_end/' . $active_modul . '/detail'); ?>" class="btn btn-default"><span class="fa fa-plus"></span> Tambah</a>
                                <?php endif; ?>
        <!--<a href="<?php echo base_url('back_end/klpaktifitas'); ?>" class="btn btn-default"><span class="fa fa-list"></span> Kelompok</a>-->
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-condensed table-bordered table-top">
                        <thead>
                            <tr role="row">
                                <th>NO</th>
                                <th width="60%">NAMA</th>
                                <th>OUTPUT</th>
                                <th>WAKTU</th>
                                <th>STATUS</th>
                                <?php if ($access_rules[2][0] == 'allow' || $access_rules[3][0] == 'allow'): ?>
                                    <th width="130">AKSI</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($records != FALSE): ?>
                                <?php foreach ($records as $key => $record): ?>
                                    <tr>
                                        <td class="text-right">
                                            <?php echo $next_list_number; ?>
                                        </td>
                                        <td>
                                            <?php echo beautify_str($record->aktifitas_nama) ?>
                                        </td>
                                        <td>
                                            <?php echo beautify_str($record->aktifitas_output) ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $record->aktifitas_waktu . ' menit' ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo beautify_str($record->record_active == 1 ? "Aktif" : "Pasif") ?>
                                        </td>
                                        <?php if ($access_rules[2][0] == 'allow' || $access_rules[3][0] == 'allow'): ?>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm btn-group-icon">
                                                    <?php if ($access_rules[2][0] == 'allow'): ?>
                                                        <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/detail") . "/" . $record->aktifitas_id; ?>">Ubah</a>
                                                    <?php endif; ?>
                                                    <?php if ($access_rules[3][0] == 'allow'): ?>
                                                        <a class="btn btn-default btn-hapus-row" href="javascript:void(0);" rel="<?php echo base_url("back_end/" . $active_modul . "/delete") . "/" . $record->aktifitas_id; ?>">Hapus</a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php $next_list_number++; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10"> Kosong / Data tidak ditemukan. </td>
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