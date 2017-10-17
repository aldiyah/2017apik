<?php
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$record_active_column_name = isset($record_active_column_name) ? $record_active_column_name : FALSE;
$records = isset($records) ? $records : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$keyword = isset($keyword) ? $keyword : "";
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
$is_developer = isset($is_developer) ? $is_developer : TRUE;
?>

<div class="row">
    <div class="col-md-12">

        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">                                
                <h3 class="panel-title">Daftar Pengguna</h3>
            </div>
            <div class="panel-body">

                <div class="block">
                    <?php echo load_partial("back_bone/shared/attention_message"); ?>
                    <p>Gunakan Formulir ini untuk melakukan pencarian pada halaman ini.</p>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" name="keyword" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                                        <a href="<?php echo backbone_url('member/detail'); ?>" class="btn btn-default">
                                            <span class="fa fa-plus"></span> Tambah baru
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="block">
                    <div class="dataTables_wrapper no-footer">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered table-striped no-footer" id="DataTables_Table_0">
                                <thead>
                                    <tr role="row">
                                        <th>
                                            No
                                        </th>
                                        <th>
                                            Username
                                        </th>
                                        <th>
                                            Nama
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th width="180">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($records != FALSE): ?>
                                        <?php foreach ($records as $key => $record): ?>
                                            <tr>
                                                <td class="text-right">
                                                    <?php echo $next_list_number; ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->username; ?>
                                                </td>
                                                <td>
                                                    <?php echo beautify_str($record->nama_profil); ?>
                                                </td>
                                                <td>
                                                    <?php echo beautify_str($record->email_profil); ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm">
                                                        <?php if ($record_active_column_name): ?>
                                                            <a class="btn btn-default user-non-activation" href="javascript:void(0)" rel="<?php echo backbone_url("member/update_status_active") . "/" . $record->username; ?>">
                                                                <?php if ($record->{$record_active_column_name} == '1'): ?>
                                                                    Non Aktifkan
                                                                <?php else: ?>
                                                                    Aktifkan
                                                                <?php endif; ?>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if ($is_developer): ?>
                                                            <a class="btn btn-default" href="<?php echo backbone_url("user/role") . "/" . $record->id_user; ?>">
                                                                Role
                                                            </a>
                                                            <a id="r_<?php echo $record->username; ?>" class="btn btn-default resetusername" onclick="javascript:;">
                                                                Reset Password
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $next_list_number++; ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5"> Kosong / Data tidak ditemukan. </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <?php /** <div class="dataTables_info" id="DataTables_Table_0_info">Showing 1 to 10 of 57 entries</div> */ ?>
                            <?php
                            echo $paging_set;
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- message Box -->
<div class="message-box message-box-success animated fadeIn" id="message-box-success-reset-password">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-check"></span> Hore ..</div>
            <div class="mb-content">
                <p>Password Telah sukses di reset.</p>
            </div>
            <div class="mb-footer">
                <button class="btn btn-default btn-lg pull-right mb-control-close">Tutup</button>
            </div>
        </div>
    </div>
</div>
