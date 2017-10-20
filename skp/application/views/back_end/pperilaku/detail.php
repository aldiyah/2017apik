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
                    <h3 class="panel-title">Formulir Data Perilaku</h3>
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
                    <?php if ($perilaku): ?>
                        <table>
                            <?php foreach ($perilaku as $row) : ?>
                                <tr>
                                    <td><?php echo $row->perilaku_nama ?></td>
                                    <td>:</td>
                                    <td><?php echo form_input('perilaku[' . $row->perilaku_id . ']', 0, 'class="form-control"'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Simpan</button>
                    <a href="<?php echo base_url("back_end/" . $active_modul . "/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>