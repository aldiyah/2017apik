<?php
/**
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * index.php
 * Oct 18, 2017
 */
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$total_record = isset($total_record) ? $total_record : 0;
//var_dump($records);
?>

<div class="row">
    <div class="col-md-12">

        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">                                
                <h3 class="panel-title"><?php echo $header_title; ?></h3>
            </div>
            <div class="panel-body">
                <?php echo load_partial("back_end/shared/attention_message"); ?>
                <form class="form-panel">
                    <div class="input-group">
                        <input type="text" name="keyword" style="width: calc(100% - 55px);" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                        <?php echo dropdown_tahun('tahun', $tahun, 5, 'class="form-control" style="width: 55px;"') ?>
                        <div class="input-group-btn">
                            <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-condensed table-bordered table-top">
                        <thead>
                            <tr role="row">
                                <th>No</th>
                                <th>Pegawai</th>
                                <th>Jenis Cuti</th>
                                <th>Mulai Cuti</th>
                                <th>Lama Cuti</th>
                                <th>Keterangan</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($records != FALSE): ?>
                                <?php foreach ($records as $key => $record): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++; ?></td>
                                        <td>
                                            <?php echo $record->pegawai_nama ?><br>
                                            NIP. <?php echo $record->pegawai_nip ?>
                                        </td>
                                        <td><?php echo $jenis_cuti[$record->cuti_jenis] ?></td>
                                        <td class="text-center"><?php echo pg_date_to_text($record->cuti_tanggal) ?></td>
                                        <td class="text-center"><?php echo $record->cuti_lama ?> hari</td>
                                        <td><?php echo $record->cuti_keterangan ?></td>
                                        <td class="text-center">
                                            <?php if ($record->cuti_status == 1): ?>
                                                <div class="btn-group btn-group-sm">
                                                    <a class="btn btn-default btn-valid-row" href="javascript:void(0);" rel="<?php echo base_url("back_end/" . $active_modul . "/validasi") . "/" . $record->cuti_id; ?>">Izinkan</a>
                                                    <a class="btn btn-default btn-reject-row" href="javascript:void(0);" rel="<?php echo base_url("back_end/" . $active_modul . "/reject") . "/" . $record->cuti_id; ?>">Tolak</a>
                                                </div>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8"> Kosong / Data tidak ditemukan. </td>
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