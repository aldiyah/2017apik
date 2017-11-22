<?php
/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * index_js.php
 * Oct 21, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-valid-row").click(function () {
            var url = $(this).attr('rel');
            modalConfirm({
                id: 'message-box-confirm',
                title: 'Persetujuan Cuti',
                msg: 'Anda yakin akan menyetujui "Izin Cuti" ini?',
                onOk: function () {
                    window.location = url;
                }
            });
        });
        
        $(".btn-reject-row").click(function () {
            var url = $(this).attr('rel');
            modalConfirm({
                id: 'message-box-confirm',
                title: 'Penolakan Cuti',
                msg: 'Anda yakin akan menolak "Izin Cuti" ini?',
                onOk: function () {
                    window.location = url;
                }
            });
        });
    });
</script>