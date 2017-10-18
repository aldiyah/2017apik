<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$detail = isset($detail) ? $detail : FALSE;
$status = array('Proses', 'Pengajuan', 'Selesai');
?>

<div class="row">
    <div class="col-md-12">
        <form method="POST" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">                                
                    <h3 class="panel-title">Laporan <?php echo $header_title; ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                    <table>
                        <tr>
                            <td>Nama Kegiatan</td>
                            <td>:</td>
                            <td><?php echo $detail->skpt_kegiatan ?></td>
                        </tr>
                        <tr>
                            <td>Periode Tahun</td>
                            <td>:</td>
                            <td><?php echo $detail->skpt_tahun ?></td>
                        </tr>
                        <tr>
                            <td>Kegiatan Bulan</td>
                            <td>:</td>
                            <td><?php echo array_month($detail->skpb_bulan) ?></td>
                        </tr>
                        <tr>
                            <td>Status Kegiatan</td>
                            <td>:</td>
                            <td><?php echo $status[$detail->skpb_status] ?></td>
                        </tr>
                    </table>
                    <hr>
                    <table class="table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Keterangan</th>
                                <th>Target</th>
                                <th>Realisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Kuantitas</td>
                                <td class="text-center"><?php echo $detail->skpb_kuantitas ?></td>
                                <td class="text-center"><?php echo $detail->skpb_real_kuantitas ?></td>
                            </tr>
                            <tr>
                                <td>Biaya</td>
                                <td class="text-center"><?php echo $detail->skpb_biaya ?></td>
                                <td class="text-center"><?php echo $detail->skpb_real_biaya ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <table>
                        <tr>
                            <td>Penilaian Atasan</td>
                            <td>:</td>
                            <td><strong><?php echo $detail->skpb_kualitas ?></strong></td>
                        </tr>
                    </table>
                </div>
                <div class = "panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Submit</button>
                    <a href = "<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class = "btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
