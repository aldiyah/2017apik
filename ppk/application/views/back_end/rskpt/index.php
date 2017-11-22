<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$total_record = isset($total_record) ? $total_record : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$skpt_ouput = array('Laporan', 'Dokumen');
$status = array('Draft', 'Pengajuan', 'Proses', 'Selesai');
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
                    <div>
                        <div class="input-group">
                            <input type="text" name="keyword" style="width: calc(100% - 55px);" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                            <?php echo dropdown_tahun('tahun', $tahun, 5, 'class="form-control" style="width: 55px;"') ?>
                            <div class="input-group-btn">
                                <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                                <a href="<?php echo base_url('back_end/' . $active_modul . '/laporan/' . $tahun); ?>" class="btn btn-default"><span class="fa fa-print"></span> Laporan</a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-striped table-hover">
                        <thead>
                            <tr role="row">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama Kegiatan</th>
                                <th colspan="4">Target</th>
                                <th colspan="4">Realisasi</th>
                                <th rowspan="2">Penghi-<br>tungan</th>
                                <th rowspan="2">Nilai<br>Capaian<br>SKP</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>Kuantitas</th>
                                <th>Kualitas</th>
                                <th>Waktu</th>
                                <th width="120">Biaya</th>
                                <th>Kuantitas</th>
                                <th>Kualitas</th>
                                <th>Waktu</th>
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
                                    $kuantitas_target = $row->skpt_kuantitas;
                                    $kualitas_target = $row->skpt_kualitas;
                                    $waktu_target = $row->skpt_waktu;
                                    $biaya_target = $row->skpt_biaya;

                                    $kuantitas_real = $row->real_kuantitas > 0 ? $row->real_kuantitas : 0;
                                    $kualitas_real = $row->real_kualitas > 0 ? $row->real_kualitas / $row->jml : 0;
                                    $waktu_real = $row->jml;
                                    $biaya_real = $row->real_biaya > 0 ? $row->real_biaya : 0;

                                    $hitung = $row->real_hitung / $row->jml;
                                    $nilai_skp = $row->real_nilai / $row->jml;
                                    $total += $nilai_skp;
                                    $jumlah++;
                                    ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++ ?></td>
                                        <td><?php echo $row->skpt_kegiatan; ?></td>
                                        <td class="text-center"><?php echo $kuantitas_target . " " . $skpt_ouput[$row->skpt_output] ?></td>
                                        <td class="text-center"><?php echo $kualitas_target ?></td>
                                        <td class="text-center"><?php echo $waktu_target ?></td>
                                        <td class="text-right"><span class="pull-left">Rp. </span><?php echo number_format($biaya_target, 0, ',', '.') ?></td>
                                        <td class="text-center"><?php echo $kuantitas_real . " " . $skpt_ouput[$row->skpt_output] ?></td>
                                        <td class="text-center"><?php echo number_format($kualitas_real, 2, ',', '.') ?></td>
                                        <td class="text-center"><?php echo $waktu_real ?></td>
                                        <td class="text-right"><span class="pull-left">Rp. </span><?php echo number_format($biaya_real, 0, ',', '.') ?></td>
                                        <td class="text-right"><?php echo number_format($hitung, 0, ',', '.') ?></td>
                                        <td class="text-right"><?php echo number_format($nilai_skp, 2, ',', '.') ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a class="btn btn-default" href="<?php echo base_url("back_end/" . $active_modul . "/read") . "/" . $row->skpt_id; ?>">Lihat</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="14">Belum ada data...!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    Total ada <?php echo $total_record ?> data.
                </div>
            </div>
        </div>
    </div>
</div>
