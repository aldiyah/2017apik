<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
//var_dump($tpp_harian);
//var_dump($records);
//exit();
?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Rekap Bulanan <?php echo array_month($bulan) . ' ' . $tahun ?></h3>
                </div>
                <div class="panel-body">
                    <?php if ($records): ?>
                        <table class="table table-condensed table-bordered no-footer" id="DataTables_Table_0">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_waktu = 0;
                                $total_tpp = 0;
                                $status = array('Laporan', 'Diterima', 'Ditolak');
                                ?>
                                <?php foreach ($records as $row) : ?>
                                    <?php
                                    $waktu = $row->aktifitas_waktu * $row->tr_aktifitas_volume;
                                    $nilai_tpp = ($waktu > 300 ? 1 : $waktu / 300) * $tpp_harian;
                                    ?>
                                    <tr>
                                        <td class="text-right"><?php echo $next_list_number++; ?></td>
                                        <td class="text-center"><?php echo string_to_date($row->tr_aktifitas_tanggal); ?></td>
                                        <td class="text-center"><?php echo $row->aktifitas_waktu * $row->tr_aktifitas_volume; ?> menit</td>
                                        <td class="text-right">Rp <?php echo $nilai_tpp ? _format_number($nilai_tpp) : 0; ?></td>
                                    </tr>
                                    <?php
                                    $total_waktu += $row->aktifitas_waktu * $row->tr_aktifitas_volume;
                                    $total_tpp += $nilai_tpp;
                                    ?>
                                <?php endforeach; ?>
                                <tr class="">
                                    <td class="text-right" colspan="2">Total</td>
                                    <td class="text-center"><?php echo $total_waktu ? _format_number($total_waktu) : 0; ?> menit</td>
                                    <td class="text-right">Rp <?php echo $total_tpp ? _format_number($total_tpp) : 0; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php else: ?>
                        Belum ada aktifitas...
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
