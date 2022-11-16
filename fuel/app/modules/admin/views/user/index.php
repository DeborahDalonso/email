<div class="breadcrumb">
    <h1><?php echo 'Usuários'; ?></h1>
</div>

<div class="separator-breadcrumb border-top"></div>

<?php if (\Auth::has_access('administration.user[create]')) : ?>
    <div class="row">
        <div class="form-group">
            <div class="pull-right">
                <div class="col-md-12">
                    <a href="<?php echo Uri::create('admin/user/create'); ?>" class="btn btn-info"><i class="i-Add"></i> <?php echo __('_button.create'); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<br>

<div class="row mb-3">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="zero_configuration_table" class="display table table-striped table-bordered datable">
                                <thead>
                                    <tr class="text-center">
                                        <th><?php echo __('_user.table.username'); ?></th>
                                        <th><?php echo __('_user.table.user_profile'); ?></th>
                                        <th style="width: 150px;"><?php echo __('_user.table.actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody style="font-weight: normal;">
                                    <?php if (empty($users)) : ?>
                                        <td colspan="3" class="text-center"><?php echo __('_user.no_data') ?></td>
                                    <?php else : ?>
                                        <?php foreach ($users as $user) :; ?>
                                            <tr class="text-center">
                                                <td><?php echo $user->username; ?></td>
                                                <td><?php echo isset($user->group['name']) ? $user->group['name'] : ('_user.no_group'); ?></td>
                                                <td>
                                                    <?php if ($user->active == 1) : ?>
                                                        <?php echo Html::anchor('admin/user/edit/' . $user->id . '', '<i class="nav-icon i-Pen-4 font-weight-bold icon-edit"></i>', array('class' => '')); ?>
                                                        &nbsp;
                                                        <?php echo Html::anchor('admin/user/reset_password/' . $user->id . '', '<i class="nav-icon i-Repeat-3 font-weight-bold icon-reset"></i>', array('class' => '')); ?>
                                                    <?php endif; ?>
                                                    &nbsp;
                                                    <?php if ($user->active == 1) : ?>
                                                        <a class="btn-disabled" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/user/activate_unactivate/{$user->id}/0"); ?>"><i class="nav-icon i-Unlock-2 font-weight-bold icon-disable"></i></a>
                                                    <?php else : ?>
                                                        <a class="btn-activate" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/user/activate_unactivate/{$user->id}/1"); ?>"><i class="nav-icon i-Lock-2 font-weight-bold icon-activate"></i></a>
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>