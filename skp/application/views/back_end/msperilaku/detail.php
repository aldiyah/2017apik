<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$detail = isset($detail) ? $detail : FALSE;
?>

<div class="row">
    <div class="col-md-12">
        <form role="form" method="POST" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Formulir Data Perilaku</h3>
                </div>
                <div class="panel-body">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Nama Perilaku *</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <?php echo form_input('perilaku_nama', set_value('perilaku_nama', $detail ? $detail->perilaku_nama : ''), 'class="form-control"'); ?>
                            <span class="help-block">Isikan dengan nama perilaku.</span>
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