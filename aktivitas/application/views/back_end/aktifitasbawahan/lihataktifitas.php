<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<br>
<?php if ($aktifitas): ?>
    <?php $i = 1; ?>
    <table class="table table-bordered table-condensed table-hover table-striped table-top">
        <thead>
            <tr>
                <th>No</th>
                <th>Aktivitas</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $status = array('Proses', 'Diterima', 'Ditolak'); ?>
            <?php foreach ($aktifitas as $row) : ?>
                <tr>
                    <td class="text-right"><?php echo $i++; ?></td>
                    <td><?php echo beautify_str($row->aktifitas_nama); ?>
                        <?php if (trim($row->tr_aktifitas_dokumen) != ""): ?>
                            <br />
                            <a href="<?php echo base_url() . "_assets/uploads/aktifitas/" . $row->tr_aktifitas_id . "/" . $row->tr_aktifitas_dokumen; ?>" target="_blank"><span class="fa fa-download"></span> Lihat Dokumen Pendukung</a>
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><?php echo date('j M Y', strtotime($row->tr_aktifitas_tanggal)); ?></td>
                    <td class="text-center"><?php echo date('H:i', strtotime($row->tr_aktifitas_mulai)) . " - " . date('H:i', strtotime($row->tr_aktifitas_selesai)) ?></td>
                    <td class="text-center"><?php echo $status[$row->tr_aktifitas_status]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    Belum ada data...
<?php endif; ?>
