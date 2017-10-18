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
$approval = array('Proses', 'Disetujui', 'Ditolak');
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
                <div class="dataTables_wrapper no-footer">
                    <div class="table-responsive">
                        <table class="table table-striped table-condensed table-bordered table-top no-footer" id="DataTables_Table_0">
                            <thead>
                                <tr role="row">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Absensi</th>
                                    <th>Masuk</th>
                                    <th>Pulang</th>
                                    <th>Status</th>
                                    <th>Pinalti</th>
                                    <th width="80">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($records != FALSE): ?>
                                    <?php $total_pinalty = 0; ?>
                                    <?php foreach ($records as $key => $record): ?>
                                        <?php
                                        $pinalty = pinalty_absensi($record->absensi_id, $record->abs_masuk, $record->abs_pulang);
                                        $total_pinalty += $pinalty;
                                        ?>
                                        <tr>
                                            <td class="text-right"><?php echo $next_list_number++; ?></td>
                                            <td class="text-center"><?php echo pg_date_to_text($record->abs_tanggal) ?></td>
                                            <td><?php echo $record->absensi_id > 0 ? beautify_str($record->absensi_nama) : 'Belum Absen' ?></td>
                                            <td class="text-center"><?php echo $record->abs_masuk ? $record->abs_masuk : '-' ?></td>
                                            <td class="text-center"><?php echo $record->abs_pulang ? $record->abs_pulang : '-' ?></td>
                                            <td class="text-center"><?php echo $approval[$record->abs_approval] ?></td>
                                            <td class="text-center"><?php echo $pinalty ?> %</td>
                                            <td class="text-center">
                                                <?php if ($record->absensi_id == 0): ?>
                                                    <div class="btn-group btn-group-sm">
                                                        <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/lapor") . "/" . $record->abs_id; ?>">Lapor</a>
                                                    </div>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr style="background: #00232c;font-weight: bold;">
                                        <td colspan="6" class="text-center">TOTAL</td>
                                        <td class="text-center"><?php echo $total_pinalty ?> %</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5"> Kosong / Data tidak ditemukan. </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>