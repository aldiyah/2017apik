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
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Nama Pegawai *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <?php
                            $pilihan = array();
                            $pilihan[''] = 'Pilih Pegawai';
                            foreach ($pegawai as $row) {
                                $pilihan[$row->pegawai_id] = $row->pegawai_nip . ' - ' . $row->pegawai_nama;
                            }
                            echo form_dropdown('pegawai_id', $pilihan, set_value('pegawai_id', $detail ? $detail->pegawai_id : ''), 'class="form-control select" data-live-search="true"');
                            unset($pilihan);
                            ?>
                            </select>
                            <span class="help-block">Isikan sesuai dengan nama pegawai berdasarkan NIP.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">TPP Beban Kerja *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <?php echo form_input('tpp_beban_kerja', set_value('tpp_beban_kerja', $detail ? $detail->tpp_beban_kerja : ''), 'class="form-control"'); ?>
                            </div>
                            <span class="help-block">Isikan sesuai dengan besar TPP Beban Kerja.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">TPP Objektif *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <?php echo form_input('tpp_objective', set_value('tpp_objective', $detail ? $detail->tpp_objective : ''), 'class="form-control"'); ?>
                            </div>
                            <span class="help-block">Isikan sesuai dengan besar TPP Objektif.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Tahun *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <?php echo form_input('tahun', set_value('tahun', $detail ? $detail->tahun : ''), 'class="form-control"'); ?>
                            </div>
                            <span class="help-block">Isikan sesuai dengan tahun berlaku TPP.</span>
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