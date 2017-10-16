<?php
$header_title = isset($header_title) ? $header_title : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$detail = isset($detail) ? $detail : FALSE;
//var_dump($detail);
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
                    <?php echo form_hidden('pegawai_id', $pegawai_id); ?>
                    <div class = "form-group">
                        <label class = "col-md-3 col-xs-12 control-label">Pilih Aktivitas *</label>
                        <div class = "col-md-6 col-xs-12">
                            <?php
                            $pilihan = array();
                            $pilihan[''] = 'Pilih Aktivitas';
                            foreach ($aktifitas as $row) {
                                $pilihan[$row->aktifitas_id] = $row->aktifitas_nama . ' (' . $row->aktifitas_waktu . ' menit) &DoubleRightArrow; ' . $row->aktifitas_output;
                            }
                            echo form_dropdown('aktifitas_id', $pilihan, set_value('aktifitas_id', $detail ? $detail->aktifitas_id : ''), 'id="aktifitas_id" class="form-control select" data-live-search="true" onchange="hitungSelesai()"');
                            ?>
                            <span class="help-block">Isikan sesuai dengan nama aktivitas.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Tanggal Aktivitas *</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <?php echo form_input('tr_aktifitas_tanggal', set_value('tr_aktifitas_tanggal', $detail ? $detail->tr_aktifitas_tanggal : $tanggal ? $tanggal : ''), 'id="tr_aktifitas_tanggal" class="form-control" readonly'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Aktivitas Volume *</label>
                        <div class="col-md-6 col-xs-12">
                            <?php
                            $pilihan = array();
                            $pilihan[''] = 'Pilih Volume';
                            $pilihan[1] = '1 Volume';
                            $pilihan[2] = '2 Volume';
                            $pilihan[3] = '3 Volume';
                            $pilihan[4] = '4 Volume';
                            $pilihan[5] = '5 Volume';
                            $pilihan[6] = '6 Volume';
                            $pilihan[7] = '7 Volume';
                            $pilihan[8] = '8 Volume';
                            $pilihan[9] = '9 Volume';
                            $pilihan[10] = '10 Volume';
                            echo form_dropdown('tr_aktifitas_volume', $pilihan, set_value('tr_aktifitas_volume', $detail ? $detail->tr_aktifitas_volume : ''), 'id="tr_aktifitas_volume" class="form-control select" onchange="hitungSelesai()"');
                            ?>
                            <span class="help-block">Isikan sesuai dengan volume aktivitas.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Aktivitas Mulai *</label>
                        <div class="col-md-6 col-xs-12">        
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                <?php echo form_input('tr_aktifitas_mulai', set_value('tr_aktifitas_mulai', $detail ? $detail->tr_aktifitas_mulai : ''), 'id="tr_aktifitas_mulai" class="form-control" onchange="hitungSelesai()"'); ?>
                            </div>
                            <span class="help-block">Isikan sesuai dengan waktu mulai aktivitas (hh:mm).</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Aktivitas Selesai *</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                <?php echo form_input('tr_aktifitas_selesai', set_value('tr_aktifitas_selesai', $detail ? $detail->tr_aktifitas_selesai : ''), 'id="tr_aktifitas_selesai" class="form-control" readonly'); ?>
                            </div>
                            <span class="help-block">Otomatis terisi dengan waktu selesai aktivitas (hh:mm).</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Keterangan Aktivitas *</label>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                <?php echo form_input('tr_aktifitas_keterangan', set_value('tr_aktifitas_keterangan', $detail ? $detail->tr_aktifitas_keterangan : ''), 'class="form-control"'); ?>
                            </div>
                            <span class="help-block">Isikan sesuai dengan keterangan input aktivitas.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Dokumen Pendukung</label>
                        <div class="col-md-6 col-xs-12">
                            <?php echo form_upload('tr_aktifitas_dokumen', set_value('tr_aktifitas_dokumen', $detail ? $detail->tr_aktifitas_dokumen : ''), 'class="form-control"'); ?>
                            <span class="help-block">Silahkan upload dokumen pendukung di sini.</span>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <input type="submit" value="Submit" class="btn-primary btn pull-right">
                    <a href="<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>