<?php
/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * index.php
 * Nov 12, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');
$records = isset($records) ? $records : FALSE;
$urutan = isset($urutan) ? $urutan : 1;
var_dump($records);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $header_title; ?></h3>
            </div>
            <div class="panel-body">
                <?php echo load_partial("back_end/shared/attention_message"); ?>
                <form class="form-panel">
                    <div class="input-group">
                        <input type="text" name="keyword" style="width: calc(100% - 145px);" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                        <?php echo form_dropdown('bulan', array_month(), $bulan, 'class="form-control" style="width: 90px;"') ?>
                        <?php echo dropdown_tahun('tahun', $tahun, 5, 'class="form-control" style="width: 55px;"') ?>
                        <div class="input-group-btn">
                            <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-condensed table-bordered table-top">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mesin</th>
                                <th>Alias</th>
                                <th>Device</th>
                                <th>Aktivitas Terakhir</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($records): ?>
                                <?php foreach ($records as $row): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $urutan++ ?></td>
                                        <td><?php echo $row->SN ?></td>
                                        <td><?php echo beautify_str($row->Alias) ?></td>
                                        <td><?php echo $row->OEMVendor . " " . $row->DeviceName . " - " . $row->Platform ?></td>
                                        <td><?php echo $row->LastActivity ?></td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <?php echo anchor(base_url("back_end/" . $active_modul . "/detail") . "/" . $row->SN, 'Ubah', 'class="btn btn-default"') ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5">Belum ada data...</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>