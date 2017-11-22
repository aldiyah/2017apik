<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$pegawai = isset($pegawai) ? $pegawai : FALSE;
$skpb = isset($skpb) ? $skpb : FALSE;
$perilaku = isset($perilaku) ? $perilaku : FALSE;
$detail = isset($detail) ? $detail : FALSE;
$status = array('Proses', 'Pengajuan', 'Selesai');
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$nilai_skp_kerja = 0;
//var_dump($skpb, $perilaku);
//exit();
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">                                
                <h3 class="panel-title">Laporan SKP Bulanan</h3>
            </div>
            <div class="panel-body">
                <table>
                    <tr>
                        <td>Nama Pegawai</td>
                        <td>:</td>
                        <td><?php echo $pegawai->pegawai_nama ?></td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td><?php echo $pegawai->pegawai_nip ?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>:</td>
                        <td><?php echo array_month($bulan) . ' ' . $tahun ?></td>
                    </tr>
                </table>
                <hr>
                <table class="table table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Kegiatan</th>
                            <th colspan="3">Target</th>
                            <th colspan="3">Realisasi</th>
                            <th rowspan="2" width="50">Penghi-tungan</th>
                            <th rowspan="2" width="50">Nilai Capaian SKP</th>
                        </tr>
                        <tr>
                            <th width="50">Kuantitas</th>
                            <th width="120">Biaya</th>
                            <th width="50">Kualitas</th>
                            <th width="50">Kuantitas</th>
                            <th width="120">Biaya</th>
                            <th width="50">Kualitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($skpb): ?>
                            <?php
                            $total = 0;
                            $jumlah = 0;
                            ?>
                            <?php foreach ($skpb as $row) : ?>
                                <?php
                                $kuantitas_target = $row->skpb_kuantitas;
                                $kualitas_target = $row->skpb_kualitas;
                                $waktu_target = 1;
                                $biaya_target = $row->skpb_biaya;
                                $status_skpb = $row->skpb_status;
                                if ($status_skpb > 1) {
                                    $kuantitas_real = $row->skpb_real_kuantitas;
                                    $kualitas_real = $row->skpb_real_kualitas;
                                    $waktu_real = 1;
                                    $biaya_real = $row->skpb_real_biaya;

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
                                    $kuantitas_real = 0;
                                    $kualitas_real = 0;
                                    $waktu_real = 0;
                                    $biaya_real = 0;
                                    $hitung = 0;
                                    $nilai_skp = 0;
                                }
                                $jumlah++;
                                ?>
                                <tr>
                                    <td class="text-right"><?php echo $next_list_number++ ?></td>
                                    <td><?php echo $row->skpt_kegiatan; ?></td>
                                    <td class="text-center"><?php echo $kuantitas_target ?></td>
                                    <td class="text-right"><span class="pull-left">Rp. </span><?php echo number_format($biaya_target, 0, ',', '.') ?></td>
                                    <td class="text-center"><?php echo $kualitas_target ?></td>
                                    <td class="text-center"><?php echo $kuantitas_real ?></td>
                                    <td class="text-right"><span class="pull-left">Rp. </span><?php echo number_format($biaya_real, 0, ',', '.') ?></td>
                                    <td class="text-center"><?php echo $kualitas_real ?></td>
                                    <td class="text-right"><?php echo $hitung ?></td>
                                    <td class="text-right"><?php echo number_format($nilai_skp, 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php $nilai_skp_kerja = $jumlah > 0 ? $total / $jumlah : 0; ?>
                            <tr style="font-weight: bold;">
                                <td colspan="9" class="text-center">Nilai Capaian SKP</td>
                                <td class="text-right"><?php echo number_format($nilai_skp_kerja, 2, ',', '.'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <table class="table table-bordered table-condensed">
                            <tr style="font-weight: bold;">
                                <td colspan="2" class="text-center">Perilaku Kerja</td>
                            </tr>
                            <tr>
                                <td>Orientasi Pelayanan</td>
                                <td class="text-right"><?php echo $perilaku ? $perilaku->perilaku_pelayanan : 0 ?></td>
                            </tr>
                            <tr>
                                <td>Integritas</td>
                                <td class="text-right"><?php echo $perilaku ? $perilaku->perilaku_integritas : 0 ?></td>
                            </tr>
                            <tr>
                                <td>Komitmen</td>
                                <td class="text-right"><?php echo $perilaku ? $perilaku->perilaku_komitmen : 0 ?></td>
                            </tr>
                            <tr>
                                <td>Disiplin</td>
                                <td class="text-right"><?php echo $perilaku ? $perilaku->perilaku_disiplin : 0 ?></td>
                            </tr>
                            <tr>
                                <td>Kerjasama</td>
                                <td class="text-right"><?php echo $perilaku ? $perilaku->perilaku_kerjasama : 0 ?></td>
                            </tr>
                            <tr>
                                <td>Kepemimpinan</td>
                                <td class="text-right"><?php echo $perilaku ? $perilaku->perilaku_kepemimpinan : 0 ?></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td>Jumlah</td>
                                <td class="text-right"><?php
                                    $nilai_perilaku = $perilaku ? $perilaku->perilaku_pelayanan +
                                            $perilaku->perilaku_integritas +
                                            $perilaku->perilaku_komitmen +
                                            $perilaku->perilaku_disiplin +
                                            $perilaku->perilaku_kepemimpinan +
                                            $perilaku->perilaku_pelayanan : 0;
                                    $nilai_perilaku_kerja = $nilai_perilaku > 0 ? ($perilaku->perilaku_kepemimpinan > 0 ? $nilai_perilaku / 6 : $nilai_perilaku / 5) : 0;
                                    echo $nilai_perilaku;
                                    ?></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td>Nilai Rata-rata</td>
                                <td class="text-right"><?php echo number_format($nilai_perilaku_kerja, 2, ',', '.') ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-offset-3 col-md-5">
                        <table class="table table-bordered table-condensed">
                            <tr style="font-weight: bold;">
                                <td colspan="4" class="text-center">Prestasi Kerja</td>
                            </tr>
                            <tr>
                                <td>Sasaran Kerja Pegawai</td>
                                <td class="text-right"><?php echo number_format($nilai_skp_kerja, 2, ',', '.') ?></td>
                                <td class="text-right">60 %</td>
                                <td class="text-right"><?php echo number_format($nilai_skp_kerja * 0.6, 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Nilai Perilaku Kerja</td>
                                <td class="text-right"><?php echo number_format($nilai_perilaku_kerja, 2, ',', '.') ?></td>
                                <td class="text-right">40 %</td>
                                <td class="text-right"><?php echo number_format($nilai_perilaku_kerja * 0.4, 2, ',', '.') ?></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td colspan="3">Nilai Prestasi Kerja</td>
                                <td class="text-right"><?php echo number_format($nilai_skp_kerja * 0.6 + $nilai_perilaku_kerja * 0.4, 2, ',', '.') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class = "panel-footer">
                <a href = "<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class = "btn-default btn">Kembali</a>
            </div>
        </div>
    </div>
</div>
