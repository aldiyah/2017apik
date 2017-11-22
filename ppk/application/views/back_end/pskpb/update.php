<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$skpb = isset($skpb) ? $skpb : FALSE;
$status = array('Proses', 'Pengajuan', 'Selesai');
//var_dump($skpb);
?>

<div class="row">
    <div class="col-md-12">
        <form method="POST" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">                                
                    <h3 class="panel-title">Formulir <?php echo $header_title; ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                    <table>
                        <tr>
                            <td>Nama Pegawai</td>
                            <td>:</td>
                            <td><strong><?php echo $skpb->pegawai_nama ?></strong></td>
                        </tr>
                        <tr>
                            <td>NIP</td>
                            <td>:</td>
                            <td><?php echo $skpb->pegawai_nip ?></td>
                        </tr>
                        <tr>
                            <td>Nama Kegiatan</td>
                            <td>:</td>
                            <td><strong><?php echo $skpb->skpt_kegiatan ?></strong></td>
                        </tr>
                        <tr>
                            <td>Periode Tahun</td>
                            <td>:</td>
                            <td><?php echo $skpb->skpt_tahun ?></td>
                        </tr>
                        <tr>
                            <td>Kegiatan Bulan</td>
                            <td>:</td>
                            <td><?php echo array_month($skpb->skpb_bulan) ?></td>
                        </tr>
                        <tr>
                            <td>Status Kegiatan</td>
                            <td>:</td>
                            <td><?php echo $status[$skpb->skpb_status] ?></td>
                        </tr>
                    </table>
                    <hr>
                    <table class="table-condensed table-bordered col-md-3 col-xs-12">
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
                                <td class="text-center"><?php echo $skpb->skpb_kuantitas ?></td>
                                <td class="text-center"><?php echo $skpb->skpb_real_kuantitas ?></td>
                            </tr>
                            <tr>
                                <td>Biaya</td>
                                <td class="text-right"><?php echo $skpb->skpb_biaya ?></td>
                                <td class="text-right"><?php echo $skpb->skpb_real_biaya ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group col-md-3 col-xs-12" style="margin-left: 20px;">
                        <label class="control-label">Kualitas Kegiatan</label>
                        <div class="">
                            <?php echo form_input('skpb_real_kualitas', set_value('skpb_real_kualitas', $skpb ? $skpb->skpb_real_kualitas : 0), 'class="form-control"'); ?>
                            <span class="help-block">Berikan penilaian untuk kegiatan ini (max. 100)</span>
                        </div>
                    </div>
                </div>

                <div class = "panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Berikan Penilaian</button>
                    <a href = "<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class = "btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
