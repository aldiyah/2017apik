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
$status_masuk = array('Hadir', 'Absen', 'Terlambat', 'Izin', 'Sakit', 'Dinas');
$status_pulang = array('Hadir', 'Absen', 'Pulang', 'Izin', 'Sakit', 'Dinas');
$status = array('Hadir', 'Absen', 'T/P', 'Izin', 'Sakit', 'Dinas');
//$approval = array('Proses', 'Disetujui', 'Ditolak');
//var_dump($tanggal);
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
                        <input type="text" name="keyword" style="width: calc(100% - 145px);" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan pilih periode absensi di sebelah ini..." disabled/>
                        <?php echo form_dropdown('bulan', array_month(), $bulan, 'class="form-control" style="width: 90px;"') ?>
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
                                <th rowspan="3">No</th>
                                <th rowspan="3">Tanggal</th>
                                <th rowspan="2" colspan="2">Upacara/Apel</th>
                                <th colspan="6">Absensi</th>
                            </tr>
                            <tr>
                                <th colspan="2">Masuk</th>
                                <th colspan="2">Pulang</th>
                                <th rowspan="2">Status</th>
                                <th rowspan="2">Pinalti</th>
                            </tr>
                            <tr>
                                <th>Datang</th>
                                <th>Pinalti</th>
                                <th>Jam</th>
                                <th>Status</th>
                                <th>Jam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (ENVIRONMENT == 'testing' || ENVIRONMENT == 'development') : ?>
                            <tr>
                                <td class="text-right" style="background: #99ccff"><?php echo 0 ?></td>
                                    <td class="text-center" style="background: #99ccff">Contoh</td>
                                    <td class="text-center" style="background: #99ccff"><?php echo '<a href="' . base_url('back_end/' . $active_modul . '/ulapor/0"') . '" class="btn btn-sm btn-default">' . $status_pulang[1] . '</a>' ?></td>
                                    <td class="text-center" style="background: #99ccff">4 %</td>
                                    <td class="text-center" style="background: #99ccff">-</td>
                                    <td class="text-center" style="background: #99ccff"><?php echo '<a href="' . base_url('back_end/' . $active_modul . '/mlapor/0"') . '" class="btn btn-sm btn-default">' . $status_pulang[1] . '</a>' ?></td>
                                    <td class="text-center" style="background: #99ccff">-</td>
                                    <td class="text-center" style="background: #99ccff"><?php echo '<a href="' . base_url('back_end/' . $active_modul . '/plapor/0"') . '" class="btn btn-sm btn-default">' . $status_pulang[1] . '</a>' ?></td>
                                    <td class="text-center" style="background: #99ccff"><?php echo '<a href="' . base_url('back_end/' . $active_modul . '/lapor/0"') . '" class="btn btn-sm btn-default">' . $status_pulang[1] . '</a>' ?></td>
                                    <td class="text-center" style="background: #99ccff">4 %</td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($records != FALSE): ?>
                                <?php $total_pinalty = 0; ?>
                                <?php foreach ($records as $key => $record): ?>
                                    <?php
                                    $pinalty = $record->abs_pinalty_masuk + $record->abs_pinalty_pulang;
                                    $total_pinalty += $pinalty;
                                    ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++; ?></td>
                                        <td class="text-center"><?php echo pg_date_to_text($record->abs_tanggal) ?></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">
                                            <?php echo $record->abs_masuk ? $record->abs_masuk : '-' ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo ($record->abs_masuk_status > 0 && $record->abs_masuk_status < 3 ? '<a href="' . base_url("back_end/" . $active_modul . "/mlapor") . "/" . $record->abs_id . '" class="btn btn-sm btn-default">' . $status_masuk[$record->abs_masuk_status] . '</a>' : $status_masuk[$record->abs_masuk_status]); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $record->abs_pulang ? $record->abs_pulang : '-' ?>
                                        </td>
                                        <td class="text-center"><?php echo ($record->abs_pulang_status > 0 && $record->abs_pulang_status < 3 ? '<a href="' . base_url("back_end/" . $active_modul . "/plapor") . "/" . $record->abs_id . '" class="btn btn-sm btn-default">' . $status_pulang[$record->abs_pulang_status] . '</a>' : $status_pulang[$record->abs_pulang_status]) ?></td>
                                        <td class="text-center"><?php echo ($record->abs_status == 1 ? '<a href="' . base_url("back_end/" . $active_modul . "/lapor") . "/" . $record->abs_id . '" class="btn btn-sm btn-default">' . $status[$record->abs_status] . '</a>' : $status[$record->abs_status]) ?></td>
                                        <td class="text-center"><?php echo $pinalty ?> %</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-footer">
                                    <td colspan="3" class="text-center">TOTAL</td>
                                    <td class="text-center"></td>
                                    <td colspan="5"></td>
                                    <td class="text-center"><?php echo $total_pinalty ?> %</td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11"> Kosong / Data tidak ditemukan. </td>
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