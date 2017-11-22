<?php
/*
 * CV MITRA INDOKOMP SEJAHTERA
 * MIS DEVELOPER
 * @autor Rinaldi <rinaldi79@gmail.com>
 * 2017apik
 * detail_js.php
 * Oct 21, 2017
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
    $(document).ready(function () {
        var tanggal = new Date();
        var minTgl = new Date(tanggal.getFullYear(), tanggal.getMonth(), tanggal.getDate() + 2);
        $('#cuti_tanggal').datepicker({
//                autoclose: false,
//                beforeShowDay: $.noop,
//                calendarWeeks: false,
//                clearBtn: false,
//                daysOfWeekDisabled: [],
//                endDate: Infinity,
//                forceParse: true,
            format: 'dd/mm/yyyy',
//                keyboardNavigation: true,
            language: 'id',
//                minViewMode: 0,
//                multidate: false,
//                multidateSeparator: ',',
//                orientation: "auto",
//                rtl: false,
            startDate: minTgl
//                startView: 0,
//                todayBtn: false,
//                todayHighlight: false,
//                weekStart: 0
        });
    });
</script>