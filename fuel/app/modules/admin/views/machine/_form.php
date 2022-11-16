<?php echo form::open(); ?>

<fieldset>
    <div class="row mb-3">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="description"><?php echo __('_machine.form.machine'); ?></label>
                            <input type="text" class="form-control" id="description" placeholder="<?php echo __('_machine.form.machine'); ?>" name="machine[description]" value="<?php echo \Input::post('description', isset($machine) ? $machine->description : null); ?>" required>
                        </div>
                    </div>
                    <br>
                    <?php echo Form::submit('submit', __('_button.save'), array('class' => 'btn btn-primary')); ?>
                    <?php echo Html::anchor('admin/machine', __('_button.cancel'), array('class' => 'btn btn-danger')); ?>
                </div>
            </div>
        </div>

</fieldset>

<?php echo form::close(); ?>