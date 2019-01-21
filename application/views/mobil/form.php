<div class="row">
    <div class="col-md-8">
        <?php
            // cek jika $form_edit adalah true jika false maka akan diarahkan ke tambah.
            $fungsi = $form_edit ? 'edit/' . $mobil->id : 'add';
        ?>
        <?php echo form_open_multipart("mobil/" . $fungsi, array('class' => 'form-horizontal')); ?>
            <?php /*
            <div class="form-group <?php echo form_error('kode') ? 'has-error' : ''; ?>">
                <label for="input-kode" class="col-sm-2 control-label">Kode Mobil</label>
                <div class="col-sm-10">
                    <input type="text" name="kode" class="form-control" id="input-kode" placeholder="Kode Mobil" value="<?php echo set_value('kode', $form_edit ? $mobil->kode : null); ?>">
                    <?php echo form_error('kode', '<span class="help-block">', '</span>'); ?>
                </div>
            </div>
            */ ?>
            <div class="form-group <?php echo form_error('id_jenis') ? 'has-error' : ''; ?>">
                <label for="input-jenis" class="col-sm-2 control-label">Jenis</label>
                <div class="col-sm-10">
                    <?php echo form_dropdown('id_jenis', array('' => 'Pilih Jenis') + $jenis_mobil, set_value('id_jenis', $form_edit ? $mobil->id_jenis : null), 'id="input-jenis" class="form-control"'); ?>
                    <?php echo form_error('id_jenis', '<span class="help-block">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group <?php echo form_error('no_polisi') ? 'has-error' : ''; ?>">
                <label for="input-no_polisi" class="col-sm-2 control-label">No Polisi</label>
                <div class="col-sm-10">
                    <input type="text" name="no_polisi" class="form-control" id="input-no_polisi" placeholder="No Polisi" value="<?php echo set_value('no_polisi', $form_edit ? $mobil->no_polisi : null); ?>">
                    <?php echo form_error('no_polisi', '<span class="help-block">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group <?php echo form_error('harga') ? 'has-error' : ''; ?>">
                <label for="input-harga" class="col-sm-2 control-label">Harga</label>
                <div class="col-sm-10">
                    <input type="text" name="harga" class="form-control" id="input-harga" placeholder="Harga" value="<?php echo set_value('harga', $form_edit ? $mobil->harga : null); ?>">
                    <?php echo form_error('harga', '<span class="help-block">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group <?php echo form_error('tahun') ? 'has-error' : ''; ?>">
                <label for="input-tahun" class="col-sm-2 control-label">Tahun</label>
                <div class="col-sm-10">
                    <input type="text" name="tahun" class="form-control datepicker" id="input-tahun" placeholder="Tahun" value="<?php echo set_value('tahun', $form_edit ? $mobil->tahun : null); ?>">
                    <?php echo form_error('tahun', '<span class="help-block">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="<?php echo site_url("mobil"); ?>" class="btn btn-default">Batal</a>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>