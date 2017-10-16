<?php
$header_title = isset($header_title) ? $header_title : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$detail = isset($detail) ? $detail : FALSE;
?>

<div class="row">
    <div class="col-md-12">

        <form enctype="multipart/form-data" method="POST" class="form-horizontal">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">Formulir <strong><?php echo $header_title; ?></strong></h3>
                </div>
                <div class="panel-body">
                    <p><?php echo load_partial("back_end/shared/attention_message"); ?></p>
                </div>
                <div class="panel-body">
                    <!--                    <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Kelompok *</label>
                                            <div class="col-md-6 col-xs-12">                                            
                    <?php
                    $pilihan = array();
                    $pilihan[''] = 'Pilih Kelompok';
                    foreach ($kelompok as $row) {
                        $pilihan[$row->kelompok_id] = $row->kelompok_nama;
                    }
                    echo form_dropdown('kelompok_id', $pilihan, set_value('kelompok_id', $detail ? $detail->kelompok_id : ''), 'class="form-control select" data-live-search="true"');
                    unset($pilihan);
                    ?>
                                                </select>
                                                <span class="help-block">Isikan sesuai dengan kelompok aktifitas.</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Dinas *</label>
                                            <div class="col-md-6 col-xs-12">                                            
                    <?php
                    $pilihan = array();
                    $pilihan[''] = 'Pilih Dinas';
                    foreach ($dinas as $row) {
                        $pilihan[$row->dinas_id] = $row->dinas_nama;
                    }
                    echo form_dropdown('dinas_id', $pilihan, set_value('dinas_id', $detail ? $detail->dinas_id : ''), 'class="form-control select" data-live-search="true"');
                    unset($pilihan);
                    ?>
                                                </select>
                                                <span class="help-block">Isikan sesuai dengan nama dinas terkait.</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Kode Aktifitas *</label>
                                            <div class="col-md-6 col-xs-12">                                            
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                    <?php echo form_input('aktifitas_kode', set_value('aktifitas_kode', $detail ? $detail->aktifitas_kode : ''), 'class="form-control"'); ?>
                                                </div>
                                                <span class="help-block">Isikan sesuai dengan kode aktifitas.</span>
                                            </div>
                                        </div>-->
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Nama Aktifitas *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <?php echo form_input('aktifitas_nama', set_value('aktifitas_nama', $detail ? $detail->aktifitas_nama : ''), 'class="form-control"'); ?>
                            </div>
                            <span class="help-block">Isikan sesuai dengan nama aktifitas.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Output Aktifitas *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <?php echo form_input('aktifitas_output', set_value('aktifitas_output', $detail ? $detail->aktifitas_output : ''), 'class="form-control"'); ?>
                            </div>
                            <span class="help-block">Isikan sesuai dengan output aktifitas.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Waktu Aktifitas *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <?php echo form_input('aktifitas_waktu', set_value('aktifitas_waktu', $detail ? $detail->aktifitas_waktu : ''), 'class="form-control"'); ?>
                            </div>
                            <span class="help-block">Isikan sesuai dengan waktu aktifitas dalam menit.</span>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Submit</button>
                    <a href="<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>