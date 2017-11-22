<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$active_modul = isset($active_modul) ? $active_modul : 'none';
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
//var_dump($tahun, $bulan, $records);
//exit();
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar <?php echo $header_title . ' bulan ' . array_month($bulan) . ' ' . $tahun ?></h3>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                    <form class="form-panel form-inline">
                        <label for="bulan" class="control-label">Pilih Bulan</label>
                        <?php
                        echo form_dropdown('bulan', array_month(), set_value('bulan', $bulan), 'class="form-control"');
                        ?>
                        <label for="tahun" class="control-label">Pilih Tahun</label>
                        <?php
                        echo dropdown_tahun('tahun', $tahun, 5, 'class="form-control"');
                        ?>
                        <button type="submit" class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                    </form>
                </div>
            </div>
            <!--                <div class="block">
                                Daftar aktifitas bawahan bulan <?php echo array_month($bulan) . ' ' . $tahun ?>
                            </div>-->
            <?php if ($records): ?>
                <div class="panel-body panel-body-table list-group list-group-contacts border-bottom">
                    <?php foreach ($records as $pegawai) : ?>
                        <div class="list-group-item">
                            <img src="<?php echo assets() ?>uploads/images/users/pria.png" alt="<?php echo $pegawai->pegawai_nama; ?>"/>
                            <span class="contacts-title"><?php echo beautify_str($pegawai->pegawai_nama); ?></span>
                            <div class="list-group-controls">
                                <button class="btn btn-default" onclick="lihatAktifitas(this, <?php echo $pegawai->pegawai_id . "," . $tahun . "," . $bulan; ?>)">Lihat Aktivitas</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="panel-body">
                    Belum ada data...
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
