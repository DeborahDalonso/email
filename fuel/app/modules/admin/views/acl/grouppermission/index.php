<div class="breadcrumb">
    <h1> <?php echo __('group_permissions'); ?></h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row mb-3">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <?php if (isset($groupId) && !empty($groupId)) : /* Exists a groupId ? */ ?>
                    <?php if (count($perms)) : ?>
                        <div class="group-name">
                            <p><strong>Grupo: </strong><?php echo $groupName ?></p>
                        </div>
                        <form class="" method="post" action="grouppermission/save">
                            <input type="hidden" name="group_id" value="<?php echo $groupId; ?>" />
                            <table class="table table-striped table-bordered thumbnail-table">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo __('table.module'); ?></th>
                                        <th class="text-center" style="width: 250px;"><?php echo __('table.screen'); ?></th>
                                        <th class="text-center td-actions"><?php echo __('table.actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody style="font-weight: normal;">
                                    <?php foreach ($perms as $module => $areas) : ?>
                                        <tr>
                                            <td class="text-center valign-middle" style="vertical-align:middle;">
                                                <?php echo __('table.modules.' . $module); ?>
                                            </td>
                                            <td colspan="2" style="padding: 0;">
                                                <table class="inner-table">
                                                    <tbody>
                                                        <?php foreach ($areas as $area => $actions) : ?>
                                                            <tr>
                                                                <td class="text-center valign-middle">
                                                                    <?php echo __('table.permission.' . $area); ?>
                                                                </td>
                                                                <td class="text-center valign-middle td-actions border-left">
                                                                    <div class="form-group">
                                                                        <div class="col-md-12">
                                                                            <?php foreach ($actions['actions'] as $idx => $value) : ?>
                                                                                <div class="checkbox-inline" style="display: inline-block;">
                                                                                    <label>
                                                                                        <input <?php echo (isset($groupPerms[$actions['perm_id']]) && in_array($idx, $groupPerms[$actions['perm_id']]['actions'])) ? 'checked' : '' ?> value="<?php echo $value ?>" type="checkbox" name="perms[<?php echo $actions['perm_id']; ?>][<?php echo $idx; ?>]">
                                                                                        <?php echo __('table.action.' . $value); ?>
                                                                                    </label>
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <hr />
                            <div class="form-group">
                                <?php echo Form::submit('submit', 'Salvar', array('class' => 'btn btn-primary')); ?>
                                <?php echo Html::anchor('admin/acl/grouppermission', __('cancel'), array('class' => 'btn btn-dark')); ?>
                            </div>
                        </form>
                    <?php else : ?>
                        <table class="table table-striped table-bordered thumbnail-table">
                            <thead>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        Não existe permissões cadastradas
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php else : ?>
                    <?php echo Form::open(array("class" => "")); ?>
                    <div class="row mb-2">
                        <div class="form-group col-md-12">
                            <h4>Para editar os privilégios de acesso de grupo, selecione abaixo e clique em "Próximo".</h4>
                            <label> </label>
                        </div>
                        <div class="form-group col-md-3">
                            <select id="group_id" name="group_id" class="form-control">
                                <option>Selecione...</option>
                                <?php foreach ($usersGroups as $group) : ?>
                                    <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <?php echo Form::submit('submit', 'Próximo', array('class' => 'btn btn-primary')); ?>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>