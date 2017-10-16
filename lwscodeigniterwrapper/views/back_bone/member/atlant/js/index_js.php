<script type="text/javascript">
    $(document).ready(function () {

        $(".resetusername").click(function () {
            modalConfirm({
                id: 'message-box-confirm',
                title: 'Mohon Perhatian',
                msg: 'Password akan dikembalikan menjadi default yaitu : 12345.\nAnda yakin?',
                onOk: function () {
                    fnResetPassword($(this).attr("id"));
                }
            });
        });

        $(".user-non-activation").click(function () {
            var url = $(this).attr('rel');

            modalConfirm({
                id: 'message-box-confirm',
                title: 'Mohon Perhatian',
                msg: 'Anda yakin akan merubah status pengguna ini?',
                onOk: function () {
                    window.location = url;
                }
            });
        });

    });

    var fnResetPassword = function (uname) {
        $.ajax({
            url: "<?php echo base_url('back_bone/member/reset_password'); ?>",
            method: "POST",
            data: {uname: uname.substring(2)},
            success: function (response) {
                var box = $("#message-box-success-reset-password");
                if (box.length > 0) {
                    box.toggleClass("open");
                    playAudio('alert');
                }
                backToTop();
            }
        });
    };
</script>