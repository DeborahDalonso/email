<?php echo Form::open(array("class" => "")); ?>
<?php if (isset($usersGroup) && $usersGroup->id) : ?>
    <input type="hidden" name="id" value="<?php echo $usersGroup->id; ?>" />
<?php endif; ?>
<div class="form-group">
    <div class="row">
        <div class="col-sm-4">
            <label>Nome Perfil de Acesso</label>
            <?php echo Form::input('name', Input::post('name', isset($usersGroup) ? $usersGroup->name : ''), array('class' => 'form-control', 'required' => 'required', 'type' => 'text', 'placeholder' => 'Nome do Perfil de Acesso', 'maxlength' => '60')); ?>
        </div>
    </div>
    <hr />
    <?php echo Form::submit('submit', 'Salvar', array('class' => 'btn btn-primary')); ?>
    <?php echo Html::anchor('admin/acl/group', __('form.cancel'), array('class' => 'btn btn-dark')); ?>
</div>

<?php echo Form::close(); ?>