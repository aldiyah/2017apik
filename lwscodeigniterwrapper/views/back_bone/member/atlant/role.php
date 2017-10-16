<?php
$detail = isset($detail) ? $detail : FALSE;
$user_roles = isset($user_roles) ? $user_roles : FALSE;
?>

<div class="row">
    <div class="col-md-12">
        <form enctype="multipart/form-data" method="POST" class="form-horizontal">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h3 class="panel-title">Pengaturan <i>Role</i> (Peran) Pengguna</h3>
                </div>
                <div class="panel-body">
                    <div class="block">
                        <p><?php echo load_partial("back_bone/shared/attention_message"); ?></p>
                    </div>
                    <div class="block">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Nama Pengguna</label>
                            <div class="col-md-10">
                                <p class="form-control-static"><?php echo $detail ? $detail->username : ""; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <h4>Daftar <i>Role</i> (Peran)</h4>
                                <div class="row">
                                    <div class="dataTables_wrapper no-footer">
                                        <table class="table no-footer" id="DataTables_Table_0">
                                            <thead>
                                                <tr>
                                                    <td>
                                                        Nama Role
                                                    </td>
                                                    <td>
                                                        Akses&nbsp;<?php /* <input name="ck_check_all" type="checkbox" id="ck_check_all" value="1"> (check semua) */ ?>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($user_roles): ?>
                                                    <?php foreach ($user_roles as $key => $user_role): ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo beautify_str($user_role->nama_role); ?>
                                                            </td>
                                                            <td>
                                                                <input class="ck_role" name="ck_role[]" type="checkbox" <?php echo ($user_role->selected == 1 ? "checked=\"checked\"" : ""); ?> value="<?php echo $user_role->id_role; ?>">
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="2"> Kosong / Data tidak ditemukan. </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn-primary btn pull-right">Simpan</button>
                    <a href="<?php echo base_url("back_bone/member/index"); ?>" class="btn-default btn">Batal / Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
