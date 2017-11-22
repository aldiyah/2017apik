<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$header_title = isset($header_title) ? $header_title : '';
$active_modul = isset($active_modul) ? $active_modul : 'none';
$pegawai = isset($pegawai) ? $pegawai : FALSE;
$perilaku = isset($perilaku) ? $perilaku : FALSE;
$detail = isset($detail) ? $detail : FALSE;
//var_dump($perilaku);
?>
<div class="row">
    <div class="col-md-12">
        <form role="form" method="POST" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Penilaian Perilaku Pegawai</h3>
                </div>
                <div class="panel-body">
                    <?php echo load_partial("back_end/shared/attention_message"); ?>
                    <table>
                        <tr>
                            <td>Nama Pegawai</td>
                            <td>:</td>
                            <td><?php echo $pegawai->pegawai_nama ?></td>
                        </tr>
                        <tr>
                            <td>NIP</td>
                            <td>:</td>
                            <td><?php echo $pegawai->pegawai_nip ?></td>
                        </tr>
                    </table>
                    <hr>
                    <table>
                        <?php echo form_hidden('pegawai_id', $pegawai->pegawai_id) ?>
                        <?php echo form_hidden('perilaku_bulan', $bulan) ?>
                        <?php echo form_hidden('perilaku_tahun', $tahun) ?>
                        <tr>
                            <td>Orientasi Pelayanan</td>
                            <td>:</td>
                            <td><?php echo form_input('perilaku_pelayanan', 0, 'class="form-control"'); ?></td>
                        </tr>
                        <tr>
                            <td>Integritas</td>
                            <td>:</td>
                            <td><?php echo form_input('perilaku_integritas', 0, 'class="form-control"'); ?></td>
                        </tr>
                        <tr>
                            <td>Komitmen</td>
                            <td>:</td>
                            <td><?php echo form_input('perilaku_komitmen', 0, 'class="form-control"'); ?></td>
                        </tr>
                        <tr>
                            <td>Disiplin</td>
                            <td>:</td>
                            <td><?php echo form_input('perilaku_disiplin', 0, 'class="form-control"'); ?></td>
                        </tr>
                        <tr>
                            <td>Kerjasama</td>
                            <td>:</td>
                            <td><?php echo form_input('perilaku_kerjasama', 0, 'class="form-control"'); ?></td>
                        </tr>
                        <tr>
                            <td>Kepemimpinan</td>
                            <td>:</td>
                            <td><?php echo form_input('perilaku_kepemimpinan', 0, 'class="form-control"'); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Simpan</button>
                    <a href="<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>