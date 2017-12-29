<?php
$header_title = isset($header_title) ? $header_title : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$detail = isset($detail) ? $detail : FALSE;
//var_dump($_SERVER);
?>

<div class="row">
    <div class="col-md-12">

        <form id="frm-pegawai" enctype="multipart/form-data" method="POST" class="form-horizontal">
            <?php echo form_hidden('abs_id', $detail->abs_id); ?>
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">Lapor Absensi</h3>
                </div>
                <div class="panel-body">
                    <p><?php echo load_partial("back_end/shared/attention_message"); ?></p>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Absensi Tanggal</label>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" class="form-control" readonly value="<?php echo $detail ? pg_date_to_text($detail->abs_tanggal) : ""; ?>">                               
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Status Absensi</label>
                        <div class="col-md-6 col-xs-12">
                            <?php echo form_dropdown('la_lapor', $absensi, set_value('la_lapor'), 'id="la_lapor" class="form-control select" data-live-search="true"'); ?>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Dokumen Pendukung</label>
                        <div class="col-md-6 col-xs-12">
                            <?php echo form_upload('la_dokumen', '', 'class="form-control"'); ?>
                            <span class="help-block">Silahkan upload dokumen pendukung di sini.</span>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Lapor</button>
                    <a href="<?php echo $referer; ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>