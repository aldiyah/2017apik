<?php
$detail = isset($detail) ? $detail : FALSE;
?>
<script>
    $(document).ready(function () {
        $('#tr_aktifitas_mulai').timepicker({minuteStep: 1, showMeridian: false});
//        $('#tr_aktifitas_selesai').timepicker({showMeridian: false});
    });
    function hitungSelesai() {
        $('input[type=submit]').attr('disabled', true);
        var idAktifitas = $('#aktifitas_id').val();
        var mulai = $('#tr_aktifitas_mulai').val().split(':');
        var volume = $('#tr_aktifitas_volume').val();
        if (idAktifitas !== '' && volume !== '' && mulai[0] !== '') {
            $.ajax({
                url: "<?php echo base_url(); ?>back_end/aktifitasharian/get_waktu/" + idAktifitas,
                success: function (resp) {
                    var selesai = new Date(0, 0, 0, mulai[0], parseInt(mulai[1]) + (parseInt(volume) * parseInt(resp)), 0);
                    $('#tr_aktifitas_selesai').val(selesai.getHours() + ':' + selesai.getMinutes());
                }
            });
        }
        $('input[type=submit]').attr('disabled', false);
    }
</script>