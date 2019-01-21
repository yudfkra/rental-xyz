<div class="row">
    <div class="col-md-8 col-xs-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">&nbsp;</div>
            <?php echo form_open(site_url('auth/login'), ['method' => 'post', 'class' => 'form-horizontal']); ?>
                <div class="panel-body">
                    <div class="form-group <?php echo form_error('email') ? 'has-error' : ''; ?>">
                        <label for="input-jenis" class="col-md-3 control-label">Email</label>
                        <div class="col-md-9">
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo set_value('email'); ?>">
                            <?php echo form_error('email', '<span class="help-block">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group <?php echo form_error('password') ? 'has-error' : ''; ?>">
                        <label for="password" class="col-md-3 control-label">Password</label>
                        <div class="col-md-9">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <?php echo form_error('password', '<span class="help-block">', '</span>'); ?>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>