<?php echo Form::open() ?>
<div class="row mb-3">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <?php echo Form::label('Email', 'email', array('class' => 'control-label')); ?>
                        <?php echo Form::input('email', Input::post('email', isset($mailListItem) ? $mailListItem->email : ''), array('class' => 'form-control', 'placeholder' => __('_user.form.username'), 'required')); ?>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-info"><?php echo __('_button.save') ?></button>
                <a href="<?php echo Uri::create('admin/maillist') ?>" class="btn btn-danger" role="button"><?php echo __('_button.cancel') ?></a>
            </div>
        </div>
    </div>
</div>
<?php echo Form::close() ?>