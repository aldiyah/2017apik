<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$total_record = isset($total_record) ? $total_record : 0;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$skpt_ouput = array('Laporan', 'Dokumen', 'Paket', 'Orang', 'Unit');
$status = array('Proses', 'Pengajuan', 'Selesai');
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
                    <div class="input-group">
                        <input type="text" name="keyword" style="width: calc(100% - 145px);" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                        <?php echo form_dropdown('bulan', array_month(), $bulan, 'class="form-control" style="width: 90px;"') ?>
                        <?php echo dropdown_tahun('tahun', $tahun, 5, 'class="form-control" style="width: 55px;"') ?>
                        <div class="input-group-btn">
                            <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                            <a href="<?php echo base_url('back_end/' . $active_modul . '/laporan/' . $tahun . '/' . $bulan); ?>" class="btn btn-default"><span class="fa fa-print"></span> Laporan</a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-striped table-hover">
                        <thead>
                            <tr role="row">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama Kegiatan</th>
                                <th colspan="3">Target</th>
                                <th colspan="3">Realisasi</th>
                                <th rowspan="2">Penghi-<br>tungan</th>
                                <th rowspan="2">Nilai<br>Capaian<br>SKP</th>
                                <th rowspan="2">Status</th>
                                <th rowspan="2" width="80" class="text-center">Aksi</th>
                            </tr>
                            <tr>
                                <th>Kuantitas</th>
                                <th>Kualitas</th>
                                <th width="120">Biaya</th>
                                <th>Kuantitas</th>
                                <th>Kualitas</th>
                                <th width="120">Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($records): ?>
                                <?php
                                $total = 0;
                                $jumlah = 0;
                                ?>
                                <?php foreach ($records as $row) : ?>
                                    <?php
                                    $kuantitas_target = $row->skpb_kuantitas;
                                    $kualitas_target = $row->skpb_kualitas;
                                    $waktu_target = 1;
                                    $biaya_target = $row->skpb_biaya;
                                    $status_skpb = $row->skpb_status;
                                    $kuantitas_real = $row->skpb_real_kuantitas;
                                    $kualitas_real = $row->skpb_real_kualitas;
                                    $waktu_real = 1;
                                    $biaya_real = $row->skpb_real_biaya;
                                    if ($status_skpb > 1) {

                                        $kuantitas = $kuantitas_target > 0 ? $kuantitas_real / $kuantitas_target * 100 : 100;
                                        $kualitas = $kualitas_target > 0 ? $kualitas_real / $kualitas_target * 100 : 100;
                                        $persen_waktu = $waktu_target > 0 ? 100 - ($waktu_real / $waktu_target * 100) : 0;
                                        $waktu = $waktu_target > 0 ? $persen_waktu > 24 ? 76 - ((((1.76 * $waktu_target - $waktu_real) / $waktu_target) * 100) - 100) : ((1.76 * $waktu_target - $waktu_real) / $waktu_target) * 100 : 0;
                                        $persen_biaya = $biaya_target > 0 ? 100 - ($biaya_real / $biaya_target * 100) : 0;
                                        $biaya = $biaya_target > 0 ? $persen_biaya > 24 ? 76 - ((((1.76 * $biaya_target - $biaya_real) / $biaya_target) * 100) - 100) : ((1.76 * $biaya_target - $biaya_real) / $biaya_target) * 100 : 0;
                                        $hitung = $kuantitas + $kualitas + $waktu + $biaya;
                                        $nilai_skp = $biaya_real > 0 ? $hitung / 4 : $hitung / 3;
                                        $total += $nilai_skp;
                                    } else {
                                        $hitung = 0;
                                        $nilai_skp = 0;
                                    }
                                    $jumlah++;
                                    ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++; ?></td>
                                        <td><?php echo $row->skpt_kegiatan; ?></td>
                                        <td class="text-center"><?php echo $kuantitas_target . " " . $skpt_ouput[$row->skpt_output] ?></td>
                                        <td class="text-center"><?php echo $kualitas_target; ?></td>
                                        <td class="text-right"><span class="pull-left">Rp. </span><?php echo number_format($biaya_target, 0, ',', '.'); ?></td>
                                        <td class="text-center"><?php echo $kuantitas_real . " " . $skpt_ouput[$row->skpt_output] ?></td>
                                        <td class="text-center"><?php echo $kualitas_real; ?></td>
                                        <td class="text-right"><span class="pull-left">Rp. </span><?php echo number_format($biaya_real, 0, ',', '.'); ?></td>
                                        <td class="text-center"><?php echo number_format($hitung, 0, ',', '.'); ?></td>
                                        <td class="text-center"><?php echo number_format($nilai_skp, 2, ',', '.'); ?></td>
                                        <td class="text-center"><?php echo $status[$status_skpb]; ?></td>
                                        <td class="text-center">
                                            <!--<div class="btn-group btn-group-sm">-->
                                            <?php if ($row->skpb_status > 0): ?>
                                                <a class="btn btn-sm btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/read") . "/" . $row->skpb_id; ?>">Lihat</a>
                                            <?php else: ?>
                                                <a class="btn btn-sm btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/update") . "/" . $row->skpb_id; ?>">Realisasi</a>
                                                <a class="btn btn-sm btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/ajukan") . "/" . $row->skpb_id; ?>">Ajukan</a>
                                            <?php endif; ?>
                                            <!--</div>-->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr style="font-weight: bold;background:#f1f5f9;">
                                    <td colspan="9" class="text-center">Nilai Capaian SKP</td>
                                    <td class="text-center"><?php echo number_format($jumlah > 0 ? $total / $jumlah : 0, 2, ',', '.'); ?></td>
                                    <td colspan="2"></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="12">Belum ada data...!</td>
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
