<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$skpt_ouput = array('Laporan','Dokumen','Paket','Orang','Unit');
$status = array('Draft', 'Pengajuan', 'Proses', 'Selesai', 'Ditolak');
//var_dump($records);
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
                            <input type="text" name="keyword" style="width: calc(100% - 55px);" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                            <?php echo dropdown_tahun('tahun', $tahun, 5, 'class="form-control" style="width: 55px;"') ?>
                            <div class="input-group-btn">
                                <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                                <?php if ($access_rules[1][0] == 'allow'): ?>
                                    <a href="<?php echo base_url('back_end/' . $active_modul . '/detail'); ?>" class="btn btn-default"><span class="fa fa-plus"></span> Tambah</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-striped table-hover no-footer" id="DataTables_Table_0">
                        <thead>
                            <tr role="row">
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Tahun</th>
                                <th>Lama</th>
                                <th>Kuantitas</th>
                                <th>Kualitas</th>
                                <th>Biaya</th>
                                <th>Pegawai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($records != FALSE): ?>
                                <?php foreach ($records as $key => $record): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++ ?></td>
                                        <td><?php echo beautify_str($record->skpt_kegiatan) ?></td>
                                        <td class="text-center"><?php echo $record->skpt_tahun ?></td>
                                        <td class="text-right"><?php echo $record->skpt_waktu ?></td>
                                        <td class="text-right"><?php echo $record->skpt_kuantitas  . " " . $skpt_ouput[$record->skpt_output]?></td>
                                        <td class="text-right"><?php echo $record->skpt_kualitas ?></td>
                                        <td class="text-right"><span class="pull-left">Rp. </span><?php echo number_format($record->skpt_biaya, 0, ',', '.') ?></td>
                                        <td class="text-left"><?php echo '<strong>'.$record->pegawai_nama . '</strong><br>NIP. ' . $record->pegawai_nip; ?></td>
                                        <td class="text-center"><?php echo $status[$record->skpt_status] ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <?php if ($record->skpt_status == 1): ?>
                                                    <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/persetujuan") . "/" . $record->skpt_id; ?>">Persetujuan</a>
                                                <?php else: ?>
                                                    <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/lihat") . "/" . $record->skpt_id; ?>">Lihat</a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
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
