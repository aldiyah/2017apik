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
                        <label class="col-md-3 col-xs-12 control-label">Pilih Pegawai *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <?php
                            $pegawai = array();
                            $pegawai[''] = 'Pilih Pegawai';
                            foreach ($pegawais as $r) {
                                $pegawai[$r->pegawai_id] = $r->pegawai_nip . ' - ' . $r->pegawai_nama;
                            }
                            echo form_dropdown('pegawai_id', $pegawai, set_value('pegawai_id', $detail ? $detail->pegawai_id : ''), 'class="form-control select" data-live-search="true"');
                            ?>
                            </select>
                            <span class="help-block">Silahkan masukkan NIP pegawai terkait.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Pilih Penilai *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <?php
                            $pegawai[''] = 'Pilih Penilai';
                            echo form_dropdown('penilai_id', $pegawai, set_value('penilai_id', $detail ? $detail->penilai_id : ''), 'class="form-control select" data-live-search="true"');
                            unset($pegawai);
                            ?>
                            </select>
                            <span class="help-block">Silahkan masukkan NIP penilai terkait.</span>
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