<?php echo Form::open() ?>
<div class="row mb-3">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <?php echo Form::label(('_user.form.username'), 'username', array('class' => 'control-label')); ?>
                        <?php echo Form::input('user[username]', Input::post('username', isset($user) ? $user->username : ''), array('class' => 'form-control', 'placeholder' => __('_user.form.username'), 'required')); ?>
                    </div>
                    <div class="col-sm-3">
                        <?php echo Form::label(('_user.form.useremail'), 'email', array('class' => 'control-label')); ?>
                        <?php echo Form::input('user[email]', Input::post('email', isset($user) ? $user->email : ''), array('class' => 'form-control', 'placeholder' => __('_user.form.useremail'))); ?>
                    </div>
                    <div class="col-sm-3">
                        <?php echo Form::label(('_user.form.fullname'), 'fullname', array('class' => 'control-label')); ?>
                        <?php echo Form::input('usermetadata[fullname]', Input::post('fullname', isset($fullname) ? $fullname : ''), array('class' => 'form-control', 'placeholder' => __('_user.form.fullname'), 'required')); ?>
                    </div>
                    <div class="col-sm-2">
                        <label for="active"><?php echo __('_user.form.group') ?></label>
                        <select name="user[group_id]" class="form-control" required>
                            <option value=""><?php echo __('_user.form.select') ?></option>
                            <?php foreach ($groups as $group) : ?>
                                <?php if (isset($user) && $user['group_id'] == $group->id) : ?>
                                    <option value="<?php echo $group->id; ?>" selected><?php echo $group->name; ?></option>
                                <?php else : ?>
                                    <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-info"><?php echo __('_button.save') ?></button>
                <a href="<?php echo Uri::create('admin/user') ?>" class="btn btn-danger" role="button"><?php echo __('_button.cancel') ?></a>
            </div>
        </div>
    </div>
</div>
<?php echo Form::close() ?>