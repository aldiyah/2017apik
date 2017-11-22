<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$detail = isset($detail) ? $detail : FALSE;
$skpb = isset($skpb) ? $skpb : FALSE;
$skpt_ouput = array('Laporan','Dokumen');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">Formulir <strong><?php echo $header_title; ?></strong></h3>
            </div>
            <div class="panel-body">
                <?php echo load_partial("back_end/shared/attention_message"); ?>
                <form role="form" method="POST" class="form-horizontal" id="wizard-validation">
                    <div class="wizard show-submit wizard-validation">                                
                        <ul>
                            <li>
                                <a href="#step-1">
                                    <span class="stepNumber">1</span>
                                    <span class="stepDesc">SKP Tahunan<br /><small>Sasaran Kerja Pegawai Tahunan</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-2">
                                    <span class="stepNumber">2</span>
                                    <span class="stepDesc">SKP Bulanan<br /><small>Breakdown Bulanan</small></span>
                                </a>
                            </li>                                    
                        </ul>
                        <div id="step-1">   
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Periode Tahun *</label>
                                <div class="col-md-6 col-xs-12">
                                    <?php
                                    $default_value_tahun = $detail ? $detail->skpt_tahun : date('Y');
                                    echo dropdown_tahun('skpt_tahun', $default_value_tahun, 1, 'class="form-control select"');
                                    ?>
                                    <span class="help-block">Pilih periode tahun.</span>
                                </div>
                            </div>
                            <?php echo form_hidden('pegawai_id', $pegawai_id); ?>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Nama Kegiatan *</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <?php echo form_input('skpt_kegiatan', set_value('skpt_kegiatan', $detail ? $detail->skpt_kegiatan : ''), 'class="form-control"'); ?>
                                    <span class="help-block">Isikan dengan nama kegiatan yang akan dilakukan.</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Lama Kegiatan *</label>
                                <div class="col-md-6 col-xs-12">
                                    <?php echo form_input('skpt_waktu', set_value('skpt_waktu', $detail ? $detail->skpt_waktu : '0'), 'class="form-control"'); ?>
                                    <span class="help-block">Isikan dengan lama pengerjaan kegiatan dalam hitungan bulan.</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Kuantitas Output *</label>
                                <div class="col-md-6 col-xs-12">
                                    <div class="col-xs-4" style="padding: 0;">
                                        <?php echo form_input('skpt_kuantitas', set_value('skpt_kuantitas', $detail ? $detail->skpt_kuantitas : '0'), 'class="form-control"'); ?>
                                    </div>
                                    <div class="col-xs-8" style="padding-right: 0;">
                                        <?php echo form_dropdown('skpt_output', $skpt_ouput, set_value('skpt_output', $detail ? $detail->skpt_output : '0'), 'class="form-control select"'); ?>
                                    </div>
                                    <span class="help-block">Isikan dengan kuantitas output yang akan dihasilkan.</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Kualitas Output *</label>
                                <div class="col-md-6 col-xs-12">
                                    <?php echo form_input('skpt_kualitas', set_value('skpt_kualitas', $detail ? $detail->skpt_kualitas : '0'), 'class="form-control"'); ?>
                                    <span class="help-block">Isikan dengan kualitas kegiatan yang akan dihasilkan.</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Biaya Kegiatan *</label>
                                <div class="col-md-6 col-xs-12">
                                    <?php echo form_input('skpt_biaya', set_value('skpt_biaya', $detail ? $detail->skpt_biaya : '0'), 'class="form-control"'); ?>
                                    <span class="help-block">Isikan dengan biaya yang akan dikeluarkan jika ada. Atau isi dengan "0" jika tidak ada.</span>
                                </div>
                            </div>
                        </div>
                        <div id="step-2">
                            <p>Silahkan bagi sasaran kerja tahunan Anda menjadi sasaran kerja bulanan di sini.</p>
                            <div class="col-md-offset-3 col-md-6">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Kuantitas</th>
                                            <th>Biaya</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                                            <tr>
                                                <td><?php echo array_month($i); ?></td>
                                                <td><?php echo form_input('kuantitas[' . $i . ']', set_value('kuantitas[' . $i . ']', isset($skpb[$i]) ? $skpb[$i]['kuantitas'] : 0), 'class="form-control"'); ?></td>
                                                <td><?php echo form_input('biaya[' . $i . ']', set_value('biaya[' . $i . ']', isset($skpb[$i]) ? $skpb[$i]['biaya'] : 0), 'class="form-control"'); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>                                                                                                            
                        </div>                                                                                                            
                    </div>
                </form>
            </div>
        </div>
        <!--
                <form enctype="multipart/form-data" method="POST" class="form-horizontal" id="frm-ref-kegiatan">
                    <div class="panel panel-default">
        
                        <div class="panel-heading">
                            <h3 class="panel-title">Formulir <strong><?php echo $header_title; ?></strong></h3>
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel-body">
        
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn-primary btn pull-right">Submit</button>
                            <a href="<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                    </div>
            </form>-->
    </div>
</div>