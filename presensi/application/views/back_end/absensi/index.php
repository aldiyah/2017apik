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
$status_upacara = array("Hadir", "Tidak");
//var_dump($tanggal, $records);
//exit();
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
                        <input type="text" name="keyword" style="width: calc(100% - 145px);" value="" class="form-control" placeholder="Silahkan pilih periode absensi di sebelah ini..." disabled/>
                        <?php echo form_dropdown('bulan', array_month(), $bulan, 'class="form-control" style="width: 90px;"') ?>
                        <?php echo dropdown_tahun('tahun', $tahun, 5, 'class="form-control" style="width: 55px;"') ?>
                        <div class="input-group-btn">
                            <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                            <button class="btn btn-default"><span class="fa fa-print"></span> Rekap</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-condensed table-bordered table-top">
                        <thead>
                            <tr role="row">
                                <th rowspan="3">No</th>
                                <th rowspan="3">Tanggal</th>
                                <th rowspan="2" colspan="3">Upacara Gabungan</th>
                                <th colspan="6">Absensi</th>
                            </tr>
                            <tr>
                                <th colspan="2">Masuk</th>
                                <th colspan="2">Pulang</th>
                                <th rowspan="2">Status</th>
                                <th rowspan="2">Pinalti</th>
                            </tr>
                            <tr>
                                <th>Jam</th>
                                <th>Status</th>
                                <th>Pinalti</th>
                                <th>Jam</th>
                                <th>Status</th>
                                <th>Jam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($records != FALSE): ?>
                                <?php
                                $pinalty_upacara = 0;
                                $total_pinalty = 0;
                                ?>
                                <?php foreach ($records as $key => $record): ?>
                                    <?php if (in_array($record->abs_tanggal, $tanggal)): ?>
                                        <?php
                                        $pinalty = $record->abs_pinalty_absensi;
                                        $pinalty_upacara += $record->upacara_pinalty;
                                        $total_pinalty += $pinalty;
                                        ?>
                                        <tr>
                                            <td class="text-right"><?php echo $next_list_number++; ?></td>
                                            <td class="text-center"><?php echo pg_date_to_text($record->abs_tanggal); ?></td>
                                            <td class="text-center"><?php echo is_null($record->upacara_hadir) ? "-" : date('H:i:s', strtotime($record->upacara_hadir)); ?></td>
                                            <td class="text-center"><?php echo is_null($record->upacara_status) ? "-" : $status_upacara[$record->upacara_status]; ?></td>
                                            <td class="text-center"><?php echo is_null($record->upacara_pinalty) ? "-" : $record->upacara_pinalty . "%"; ?></td>
                                            <td class="text-center">
                                                <?php echo $record->abs_masuk ? date('H:i:s', strtotime($record->abs_masuk)) : '-' ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                if ($record->abs_status == 1) {
                                                    if ($record->lm_approval_al == 1 || $record->lm_approval_aa == 1) {
                                                        
                                                    } else {
                                                        echo $status_masuk[$record->abs_masuk_status];
                                                    }
                                                } else {
                                                    if ($record->lm_lapor == 0) {
                                                        if ($record->abs_masuk_status > 0 && $record->abs_masuk_status < 3) {
                                                            echo anchor(base_url("back_end/" . $active_modul . "/mlapor") . "/" . $record->abs_id, $status_masuk[$record->abs_masuk_status], 'class="btn btn-sm btn-primary"');
                                                        } else {
                                                            echo $status_masuk[$record->abs_masuk_status];
                                                        }
                                                    } else {
                                                        if ($record->lm_approval_al == 1 || $record->lm_approval_aa == 1) {
                                                            echo $lapor_masuk[$record->abs_masuk_lapor] . ' [V]';
                                                        } else {
                                                            echo $lapor_masuk[$record->lm_lapor] . ' [P]';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo $record->abs_pulang ? date('H:i:s', strtotime($record->abs_pulang)) : '-' ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                if ($record->abs_status == 1) {
                                                    if ($record->lp_approval_al == 1 || $record->lp_approval_aa == 1) {
                                                        
                                                    } else {
                                                        echo $status_pulang[$record->abs_pulang_status];
                                                    }
                                                } else {
                                                    if ($record->lp_lapor == 0) {
                                                        if ($record->abs_pulang_status > 0 && $record->abs_pulang_status < 3) {
                                                            echo anchor(base_url("back_end/" . $active_modul . "/plapor") . "/" . $record->abs_id, $status_pulang[$record->abs_pulang_status], 'class="btn btn-sm btn-primary"');
                                                        } else {
                                                            echo $status_pulang[$record->abs_pulang_status];
                                                        }
                                                    } else {
                                                        if ($record->lp_approval_al == 1 || $record->lp_approval_aa == 1) {
                                                            echo $lapor_pulang[$record->abs_pulang_lapor] . ' [V]';
                                                        } else {
                                                            echo $lapor_pulang[$record->lp_lapor] . ' [P]';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                if ($record->abs_status == 1) {
                                                    if ($record->la_lapor == 0) {
                                                        echo anchor(base_url("back_end/" . $active_modul . "/lapor") . "/" . $record->abs_id, $status[$record->abs_status], 'class="btn btn-sm btn-primary"');
                                                    } else {
                                                        if ($record->la_approval_al == 1 || $record->la_approval_aa == 1) {
                                                            echo $lapor[$record->abs_lapor] . ' [V]';
                                                        } else {
                                                            echo $lapor[$record->la_lapor] . ' [P]';
                                                        }
                                                    }
                                                } else { // Lanjutkan lagi brooooo.... Cek approval semua
                                                    if ($record->la_approval_al == 1 || $record->la_approval_aa == 1) {
                                                        echo $lapor[$record->abs_lapor] . ' [V]';
                                                    } else {
                                                        echo $status[$record->abs_status];
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center"><?php echo $pinalty ?> %</td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <tr class="table-footer">
                                    <td colspan="4" class="text-center">TOTAL</td>
                                    <td class="text-center"><?php echo $pinalty_upacara; ?>%</td>
                                    <td colspan="5"></td>
                                    <td class="text-center"><?php echo $total_pinalty; ?> %</td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11"> Kosong / Data tidak ditemukan. </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <table>
                        <tr>
                            <td colspan="2"><strong>KETERANGAN</strong></td>
                        </tr>
                        <tr>
                            <td>Terlambat</td>
                            <td>=</td>
                            <td>Datang Terlambat</td>
                        </tr>
                        <tr>
                            <td>Pulang</td>
                            <td>=</td>
                            <td>Pulang Lebih Cepat</td>
                        </tr>
                        <tr>
                            <td>Izin</td>
                            <td>=</td>
                            <td>Izin</td>
                        </tr>
                        <tr>
                            <td>SDKD</td>
                            <td>=</td>
                            <td>Sakit Dengan Keterangan Dokter</td>
                        </tr>
                        <tr>
                            <td>STKD</td>
                            <td>=</td>
                            <td>Sakit Tanpa Keterangan Dokter</td>
                        </tr>
                        <tr>
                            <td>Dinas</td>
                            <td>=</td>
                            <td>Menjalankan Tugas Dinas</td>
                        </tr>
                        <tr>
                            <td>Cuti</td>
                            <td>=</td>
                            <td>Sedang Dalam Cuti</td>
                        </tr>
                        <tr>
                            <td>[P]</td>
                            <td>=</td>
                            <td>Dalam Pengajuan</td>
                        </tr>
                        <tr>
                            <td>[V]</td>
                            <td>=</td>
                            <td>Telah Disetujui</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>