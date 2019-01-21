<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a role="button" data-toggle="collapse" href="#collapse-form" aria-expanded="true" aria-controls="collapse-form">
                    Filter Mobil
                </a>
            </div>
            <?php echo form_open('mobil', ['method' => 'get', 'class' => 'form-horizontal']); ?>
                <div id="collapse-form" class="panel-collapse collapse <?php echo !empty($this->input->get()) ? 'in' : ''; ?>" role="tabpanel">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="input-jenis" class="col-md-2 control-label">Jenis</label>
                            <div class="col-md-6">
                                <?php echo form_dropdown('id_jenis', array('' => 'Pilih Jenis') + $jenis_mobil, $this->input->get('id_jenis'), 'id="input-jenis" class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="col-md-2 control-label">Kata Kunci</label>
                            <div class="col-md-8">
                                <input type="text" name="keyword" class="form-control" value="<?php echo $this->input->get('keyword'); ?>" placeholder="Kata Kunci">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="col-md-2 control-label">Status Mobil</label>
                            <div class="col-md-6">
                                <?php 
                                    $input_status = $this->input->get('status');
                                    echo form_dropdown('status', array('' => 'Pilih Status', 'all' => 'Semua') + $status_mobil, $input_status ? $input_status : 'all' , 'id="input-jenis" class="form-control"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?php echo site_url('mobil/add'); ?>" class="btn btn-primary">Tambah Mobil</a>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>No Polisi</th>
                            <th>Jenis</th>
                            <th>Tahun</th>
                            <th>Harga</th>
                            <th>Tanggal Input</th>
                            <th>Terakhir Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($list_mobil)) { ?>
                            <?php $no = 0; foreach($list_mobil as $mobil) { ?>
                                <tr>
                                    <td><?php echo $no += 1; ?></td>
                                    <td><?php echo $mobil->kode; ?></td>
                                    <td><?php echo $mobil->no_polisi; ?></td>
                                    <td><?php echo $jenis_mobil[$mobil->id_jenis]; ?></td>
                                    <td><?php echo $mobil->tahun; ?></td>
                                    <td><?php echo format_rp($mobil->harga); ?></td>
                                    <td><?php echo $mobil->tanggal_input; ?></td>
                                    <td class="text-center"><?php echo !empty($mobil->tanggal_update) ? $mobil->tanggal_update : '-'; ?></td>
                                    <td>
                                        <a href="<?php echo site_url("mobil/edit/" . $mobil->id) ?>" class="btn btn-info">Edit</a>
                                        <a href="<?php echo site_url("mobil/delete/" . $mobil->id)?>" class="btn btn-danger">Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data Mobil</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>