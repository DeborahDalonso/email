<?php echo Form::open() ?>
<div class="row mb-3">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="description"><?php echo __('_stop.form.description');?></label>
                        <input type="text" class="form-control" id="description" name="stop[description]" placeholder="<?php echo __('_stop.form.description');?>" value="<?php echo \Input::post('description', isset($stop) ? $stop->description : null); ?>" required>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-info"><?php echo __('_button.save');?></button>
                <a href="<?php echo Uri::create('admin/stopevent') ?>" class="btn btn-danger" role="button"><?php echo __('_button.cancel');?></a>
            </div>
        </div>
    </div>
</div>
<?php echo Form::close() ?>