<?php
/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * index.php
 * Nov 15, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$lapor_masuk = isset($lapor_masuk) ? $lapor_masuk : FALSE;
//var_dump($masuk);
?>
<div class="row">
    <div class="col-md-12">
        <?php if ($masuk != FALSE): ?>
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">                                
                    <h3 class="panel-title">Validasi Keterlambatan</h3>
                </div>
                <div class="panel-body">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-condensed table-bordered table-top">
                            <thead>
                                <tr role="row">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pegawai</th>
                                    <th>Alasan</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($masuk as $key => $row): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++; ?></td>
                                        <td class="text-center"><?php echo pg_date_to_text($row->abs_tanggal) ?></td>
                                        <td><?php echo beautify_str($row->pegawai_nama) ?><br>
                                            NIP. <?php echo beautify_str($row->pegawai_nip) ?></td>
                                        <td><?php echo $lapor_masuk[$row->lm_lapor] ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/validasi") . "/m/" . $row->abs_id . "/setuju"; ?>">Setujui</a>
                                                <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/validasi") . "/m/" . $row->abs_id . "/tolak"; ?>">Tolak</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($pulang != FALSE): ?>
            <?php $next_list_number = 1; ?>
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">                                
                    <h3 class="panel-title">Validasi Pulang Cepat</h3>
                </div>
                <div class="panel-body">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-condensed table-bordered table-top">
                            <thead>
                                <tr role="row">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pegawai</th>
                                    <th>Alasan</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pulang as $key => $row): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++; ?></td>
                                        <td class="text-center"><?php echo pg_date_to_text($row->abs_tanggal) ?></td>
                                        <td><?php echo beautify_str($row->pegawai_nama) ?><br>
                                            NIP. <?php echo beautify_str($row->pegawai_nip) ?></td>
                                        <td><?php echo $lapor_pulang[$row->lp_lapor] ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/validasi") . "/p/" . $row->abs_id . "/setuju"; ?>">Setujui</a>
                                                <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/validasi") . "/p/" . $row->abs_id . "/tolak"; ?>">Tolak</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($absensi != FALSE): ?>
            <?php $next_list_number = 1; ?>
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">                                
                    <h3 class="panel-title">Validasi Ketidakhadiran</h3>
                </div>
                <div class="panel-body">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-condensed table-bordered table-top">
                            <thead>
                                <tr role="row">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pegawai</th>
                                    <th>Alasan</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($absensi as $key => $row): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++; ?></td>
                                        <td class="text-center"><?php echo pg_date_to_text($row->abs_tanggal) ?></td>
                                        <td><?php echo beautify_str($row->pegawai_nama) ?><br>
                                            NIP. <?php echo beautify_str($row->pegawai_nip) ?></td>
                                        <td><?php echo $lapor_absensi[$row->la_lapor] ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/validasi") . "/a/" . $row->abs_id . "/setuju"; ?>">Setujui</a>
                                                <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/validasi") . "/a/" . $row->abs_id . "/tolak"; ?>">Tolak</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (!$absensi && !$masuk && !$pulang): ?>
            <?php $next_list_number = 1; ?>
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">                                
                    <h3 class="panel-title">Validasi Absensi Bawahan</h3>
                </div>
                <div class="panel-body">
                    Belum ada data absensi bawahan yang perlu divalidasi...!!!
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
