<?php

/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * detail.php
 * Oct 22, 2017
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
                        <label class="col-md-3 col-xs-12 control-label">Tanggal</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                            <input type="text" name="upacara_tanggal" id="upacara_tanggal" class="form-control datepicker" value="<?php echo $detail ? $detail->upacara_tanggal : ""; ?>">                               
                                <span class="input-group-addon add-on"><span class="fa fa-calendar"></span></span>
                            </div>
                            <span class="help-block">Masukkan tanggal pelaksanaan upacara</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Keterangan</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <input type="text" name="upacara_keterangan" class="form-control" value="<?php echo $detail ? $detail->upacara_keterangan : ""; ?>">
                                <span class="input-group-addon add-on"><span class="fa fa-pencil"></span></span>
                            </div>
                            <span class="help-block">Masukkan keterangan untuk upacara</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Tempat</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <input type="text" name="upacara_tempat" class="form-control" value="<?php echo $detail ? $detail->upacara_tempat : ""; ?>">
                                <span class="input-group-addon add-on"><span class="fa fa-pencil"></span></span>
                            </div>
                            <span class="help-block">Masukkan tempat pelaksanaan upacara</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Pakaian Seragam</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <input type="text" name="upacara_pakaian" class="form-control" value="<?php echo $detail ? $detail->upacara_pakaian : ""; ?>">
                                <span class="input-group-addon add-on"><span class="fa fa-pencil"></span></span>
                            </div>
                            <span class="help-block">Masukkan pakaian seragam untuk upacara</span>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Simpan</button>
                    <a href="<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>