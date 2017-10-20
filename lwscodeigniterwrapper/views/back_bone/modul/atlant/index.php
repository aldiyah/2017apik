<?php
$header_title = isset($header_title) ? $header_title : '';
$message_error = isset($message_error) ? $message_error : '';
$records = isset($records) ? $records : FALSE;
$field_id = isset($field_id) ? $field_id : FALSE;
$paging_set = isset($paging_set) ? $paging_set : FALSE;
$next_list_number = isset($next_list_number) ? $next_list_number : 1;
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ui-draggable-handle">                                
                <h3 class="panel-title">Daftar Modul</h3>
                <!--                <ul class="panel-controls">
                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                    <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                </ul>-->
            </div>
            <div class="panel-body">
                <?php echo load_partial("back_bone/shared/attention_message"); ?>
                <p>Gunakan Formulir ini untuk melakukan pencarian pada halaman ini.</p>
                <form class="form-panel">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="keyword" value="<?php echo $keyword; ?>" class="form-control" placeholder="Silahkan masukkan kata kunci disini"/>
                            <div class="input-group-btn">
                                <button class="btn btn-default"><span class="fa fa-search"></span> Cari</button>
                                <a href="<?php echo base_url('back_bone/modul/detail'); ?>" class="btn btn-default">
                                    <span class="fa fa-plus"></span> Tambah baru
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-striped">
                        <thead>
                            <tr role="row">
                                <th>
                                    No
                                </th>
                                <th>
                                    Nama Modul
                                </th>
                                <th>
                                    Label
                                </th>
                                <th>
                                    Turunan Dari
                                </th>
                                <th width="180">Aksi</th>
                            </tr>
                            <?php
                            /**
                              <tr role="row">
                              <th  style="width: 196px;">Name</th>
                              <th style="width: 307px;">Position</th>
                              <th  style="width: 148px;">Office</th>
                              <th  style="width: 70px;">Age</th>
                              <th  style="width: 135px;">Start date</th>
                              <th  style="width: 121px;">Salary</th>
                              </tr>
                             */
                            ?>
                        </thead>
                        <tbody>
                            <?php if ($records != FALSE): ?>
                                <?php foreach ($records as $key => $record): ?>
                                    <tr>
                                        <td class="text-right">
                                            <?php echo $next_list_number; ?>
                                        </td>
                                        <td>
                                            <?php echo $record->nama_modul ?>
                                        </td>
                                        <td>
                                            <?php echo beautify_str($record->deskripsi_modul) ?>
                                        </td>
                                        <td>
                                            <?php echo beautify_str($record->turunan_dari) ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a class="btn btn-default" href="<?php echo base_url("back_bone/modul/detail") . "/" . $record->id_modul; ?>">Ubah</a>
                                                <a class="btn btn-default btn-hapus-modul" href="javascript:void(0);" rel="<?php echo base_url("back_bone/modul/delete") . "/" . $record->id_modul; ?>">Hapus</a>
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