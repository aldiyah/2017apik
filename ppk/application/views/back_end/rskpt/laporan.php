<?php
/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * laporan.php
 * Oct 30, 2017
 */

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
//var_dump($skpt, $perilaku);
//exit();
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Laporan SKP Tahunan</h3>
            </div>
            <div class="panel-body">
                <table class="table table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Kegiatan</th>
                            <th colspan="4">Target</th>
                            <th colspan="4">Realisasi</th>
                            <th rowspan="2">Perhi-<br>tungan</th>
                            <th rowspan="2">Nilai<br>Capaian<br>SKP</th>
                        </tr>
                        <tr>
                            <th>Kuantitas</th>
                            <th>Kualitas</th>
                            <th>Waktu</th>
                            <th>Biaya</th>
                            <th>Kuantitas</th>
                            <th>Kualitas</th>
                            <th>Waktu</th>
                            <th>Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($skpt): ?>
                            <?php
                            $total = 0;
                            $jumlah = 0;
                            ?>
                            <?php foreach ($skpt as $row) : ?>
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
                                    <td class="text-right"><?php echo $next_list_number++; ?></td>
                                    <td><?php echo $row->skpt_kegiatan; ?></td>
                                    <td class="text-center"><?php echo $kuantitas_target; ?></td>
                                    <td class="text-center"><?php echo $kualitas_target; ?></td>
                                    <td class="text-center"><?php echo $waktu_target; ?></td>
                                    <td class="text-right"><span class="pull-left">Rp. </span><?php echo number_format($biaya_target, 0, ',', '.') ?></td>
                                    <td class="text-center"><?php echo $kuantitas_real; ?></td>
                                    <td class="text-center"><?php echo number_format($kualitas_real, 2, ',', '.'); ?></td>
                                    <td class="text-center"><?php echo $waktu_real; ?></td>
                                    <td class="text-right"><span class="pull-left">Rp. </span><?php echo number_format($biaya_real, 0, ',', '.') ?></td>
                                    <td class="text-center"><?php echo number_format($hitung, 0, ',', '.') ?></td>
                                    <td class="text-center"><?php echo number_format($nilai_skp, 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php
                            $nilai_capaian = $jumlah > 0 ? $total / $jumlah : 0;
                            $nilai_huruf = '';
                            if ($nilai_capaian <= 50) {
                                $nilai_huruf = 'Buruk';
                            } elseif ($nilai_capaian <= 60) {
                                $nilai_huruf = 'Sedang';
                            } elseif ($nilai_capaian <= 75) {
                                $nilai_huruf = 'Cukup';
                            } elseif ($nilai_capaian < 91) {
                                $nilai_huruf = 'Baik';
                            } else {
                                $nilai_huruf = 'Sangat Baik';
                            }
                            ?>
                            <tr class="table-footer">
                                <td colspan="10" class="text-center">Nilai Capaian SKP</td>
                                <td colspan="2" class="text-right">
                                    <?php echo number_format($nilai_capaian, 2, ',', '.') ?><br>
                                    (<?php echo $nilai_huruf ?>)
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-4">
                        <?php
                        $perilaku_pelayanan = $perilaku ? $perilaku->perilaku_pelayanan / 12 : 0;
                        $perilaku_integritas = $perilaku ? $perilaku->perilaku_integritas / 12 : 0;
                        $perilaku_komitmen = $perilaku ? $perilaku->perilaku_komitmen / 12 : 0;
                        $perilaku_disiplin = $perilaku ? $perilaku->perilaku_disiplin / 12 : 0;
                        $perilaku_kerjasama = $perilaku ? $perilaku->perilaku_kerjasama / 12 : 0;
                        $perilaku_kepemimpinan = $perilaku ? $perilaku->perilaku_kepemimpinan / 12 : 0;
                        ?>
                        <table class="table table-bordered table-condensed">
                            <tr style="font-weight: bold;">
                                <td colspan="2" class="text-center">Perilaku Kerja</td>
                            </tr>
                            <tr>
                                <td>Orientasi Pelayanan</td>
                                <td class="text-right"><?php echo number_format($perilaku_pelayanan, 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Integritas</td>
                                <td class="text-right"><?php echo number_format($perilaku_integritas, 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Komitmen</td>
                                <td class="text-right"><?php echo number_format($perilaku_komitmen, 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Disiplin</td>
                                <td class="text-right"><?php echo number_format($perilaku_disiplin, 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Kerjasama</td>
                                <td class="text-right"><?php echo number_format($perilaku_kerjasama, 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Kepemimpinan</td>
                                <td class="text-right"><?php echo number_format($perilaku_kepemimpinan, 2, ',', '.') ?></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td>Jumlah</td>
                                <td class="text-right"><?php
                                    $nilai_perilaku = $perilaku_pelayanan + $perilaku_integritas + $perilaku_komitmen + $perilaku_disiplin + $perilaku_kepemimpinan + $perilaku_pelayanan;
                                    $nilai_perilaku_kerja = $nilai_perilaku > 0 ? ($perilaku_pelayanan > 0 ? $nilai_perilaku / 6 : $nilai_perilaku / 5) : 0;
                                    echo number_format($nilai_perilaku, 2, ',', '.');
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
                                <td class="text-right"><?php echo number_format($nilai_capaian, 2, ',', '.') ?></td>
                                <td class="text-right">60 %</td>
                                <td class="text-right"><?php echo number_format($nilai_capaian * 0.6, 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Nilai Perilaku Kerja</td>
                                <td class="text-right"><?php echo number_format($nilai_perilaku_kerja, 2, ',', '.') ?></td>
                                <td class="text-right">40 %</td>
                                <td class="text-right"><?php echo number_format($nilai_perilaku_kerja * 0.4, 2, ',', '.') ?></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td colspan="3">Nilai Prestasi Kerja</td>
                                <td class="text-right"><?php echo number_format($nilai_capaian * 0.6 + $nilai_perilaku_kerja * 0.4, 2, ',', '.') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
