<div class="row">
    <div class="col-md-8">
        <?php echo form_open_multipart("pesanan/add", array('class' => 'form-horizontal')); ?>
            <div class="form-group <?php echo form_error('nama') ? 'has-error' : ''; ?>">
                <label for="input-nama" class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" name="nama" class="form-control" id="input-nama" placeholder="Nama" value="<?php echo set_value('nama'); ?>">
                    <?php echo form_error('nama', '<span class="help-block">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group <?php echo form_error('alamat') ? 'has-error' : ''; ?>">
                <label for="input-alamat" class="col-sm-2 control-label">Alamat</label>
                <div class="col-sm-10">
                    <textarea name="alamat" class="form-control" id="input-alamat" placeholder="Alamat"><?php echo set_value('alamat'); ?></textarea>
                    <?php echo form_error('alamat', '<span class="help-block">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group <?php echo form_error('mobil_id') ? 'has-error' : ''; ?>">
                <label for="input-mobil" class="col-sm-2 control-label">Mobil</label>
                <div class="col-sm-10">
                    <?php echo form_dropdown('mobil_id', array('' => 'Pilih Mobil') + $mobil, set_value('mobil_id'), 'id="input-mobil" class="form-control"'); ?>
                    <?php echo form_error('mobil_id', '<span class="help-block">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group <?php echo form_error('tanggal_batas_kembali') ? 'has-error' : ''; ?>">
                <label for="input-tanggal_batas_kembali" class="col-sm-2 control-label">Tanggal Batas Kembali</label>
                <div class="col-sm-10">
                    <input type="date" name="tanggal_batas_kembali" class="form-control" id="input-tanggal_batas_kembali" placeholder="Tanggal Kembali" value="<?php echo set_value('tanggal_batas_kembali'); ?>">
                    <?php echo form_error('tanggal_batas_kembali', '<span class="help-block">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="<?php echo site_url("pesanan"); ?>" class="btn btn-default">Batal</a>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>