<?php $detail = isset($detail) ? $detail : FALSE; ?>
<script type="text/javascript">

    var slc_pegawai_temp = [];
    var slc_pegawai = {
        data: [],
        ajax: {
            url: "<?php echo base_url(); ?>back_end/msapi/like_nip",
            placeholder: 'Masukkan NIP',
            dataType: 'json',
            delay: 250,
            method: 'post',
            width: '100%',
            data: function (params) {
                return {
                    keyword: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                var data = $.map(data, function (obj) {
                    obj.id = obj.id || obj.id_identitas;
                    obj.text = obj.text || obj.nip + " " + obj.nama;
                    return obj;
                });
                params.page = params.page || 1;
                slc_pegawai_temp = data;

                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 4
    };

    $(document).ready(function () {

        $("#slc-nip").select2(slc_pegawai).on("select2:select", function (e) {

            var arrNamaPeg = $.grep(slc_pegawai_temp, function (obj) {
                return obj.id == $("#slc-nip").val();
            });

            if (arrNamaPeg.length > 0) {
                $("input[name=username]").val(arrNamaPeg[0].nip);
                $("input[name=nama_profil]").val(arrNamaPeg[0].nama);
                $("input[name=pegawai_nip]").val(arrNamaPeg[0].nip);
                $("input[name=pegawai_nama]").val(arrNamaPeg[0].nama);
            }
            slc_pegawai_temp = [];
//            $("input[name=nama_profil]").val(data.namaLengkap);
        });

<?php if ($detail && $detail->pegawai_id != ""): ?>
            $("#slc-nip").val(<?php echo $detail->pegawai_id ?>).trigger("change");
<?php endif; ?>

    });
</script>