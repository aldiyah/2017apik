<?php
/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * detail.php
 * Oct 21, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$detail = isset($detail) ? $detail : FALSE;
?>

<div class="row">
    <div class="col-md-12">

        <form id="frm-pegawai" enctype="multipart/form-data" method="POST" class="form-horizontal">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">Data <strong><?php echo $header_title; ?></strong></h3>
                </div>
                <div class="panel-body">
                    <p><?php echo load_partial("back_end/shared/attention_message"); ?></p>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Nomor Mesin</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <input type="text" name="cuti_lama" class="form-control" value="<?php echo $detail ? $detail->cuti_lama : ""; ?>">
                                <span class="input-group-addon add-on"><span class="fa fa-pencil"></span></span>
                            </div>
                            <span class="help-block">Masukkan keterangan untuk hari libur</span>
                        </div>
                    </div>















<!--                    <div class = "form-group">
                        <label class = "col-md-3 col-xs-12 control-label">Pilih Aktivitas *</label>
                        <div class = "col-md-6 col-xs-12">
                            <?php
                            $pilihan = array();
                            $pilihan[''] = 'Pilih Jenis Cuti';
                            foreach ($jenis_cuti as $key => $value) {
                                $pilihan[$key] = $value;
                            }
                            echo form_dropdown('cuti_jenis', $pilihan, set_value('cuti_jenis', $detail ? $detail->cuti_jenis : ''), 'id="jenis_cuti" class="form-control select" data-live-search="true"');
                            ?>
                            <span class="help-block">Isikan sesuai dengan nama aktivitas.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Tanggal</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <input type="text" name="cuti_tanggal" id="cuti_tanggal" class="form-control" value="<?php echo $detail ? $detail->cuti_tanggal : ""; ?>">                               
                                <span class="input-group-addon add-on"><span class="fa fa-calendar"></span></span>
                            </div>
                            <span class="help-block">Masukkan tanggal yang akan dijadikan hari libur</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Lama Cuti</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <input type="text" name="cuti_lama" class="form-control" value="<?php echo $detail ? $detail->cuti_lama : ""; ?>">
                                <span class="input-group-addon add-on"><span class="fa fa-pencil"></span></span>
                            </div>
                            <span class="help-block">Masukkan keterangan untuk hari libur</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Keterangan</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <input type="text" name="cuti_keterangan" class="form-control" value="<?php echo $detail ? $detail->cuti_keterangan : ""; ?>">
                                <span class="input-group-addon add-on"><span class="fa fa-pencil"></span></span>
                            </div>
                            <span class="help-block">Masukkan keterangan untuk hari libur</span>
                        </div>
                    </div>-->
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Simpan</button>
                    <a href="<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>