<div class="breadcrumb">
    <h3><?php echo __('_machine.title'); ?></h3>
</div>

<div class="separator-breadcrumb border-top"></div>

<?php if (\Auth::has_access('administration.machine[create]')) : ?>
    <div class="row">
        <div class="col-md-7">
            <a class="btn btn-info" href="<?php echo Uri::create("admin/machine/create"); ?>" role="button"><i class="i-Add"></i><?php echo __('_button.create'); ?></a>
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
                        <div class="table-resposive">
                            <table id="zero_configuration_table" class="display table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo __('_machine.table.machine'); ?></th>
                                        <th class="text-center" style="width:25%"><?php echo __('_machine.table.actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($machines)) : ?>
                                        <td colspan="2" class="text-center"><?php echo __('_machine.no_data'); ?></td>
                                    <?php else : ?>
                                        <?php foreach ($machines as $machine) : ?>
                                            <tr class="text-center">
                                                <td><?php echo $machine->description; ?></td>
                                                <td>
                                                    <?php if ($machine->active == 1) : ?>
                                                        <?php echo Html::anchor('admin/machine/edit/' . $machine->id . '', '<i class="nav-icon i-Pen-4 font-weight-bold icon-edit"></i>', array('class' => '')); ?>
                                                    <?php endif; ?>
                                                    &nbsp;
                                                    <?php if ($machine->active == 1) : ?>
                                                        <a class="btn-disabled" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/machine/activate_unactivate/{$machine->id}/0"); ?>"><i class="nav-icon i-Unlock-2 font-weight-bold icon-disable"></i></a>
                                                    <?php else : ?>
                                                        <a class="btn-activate" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/machine/activate_unactivate/{$machine->id}/1"); ?>"><i class="nav-icon i-Lock-2 font-weight-bold icon-activate"></i></a>
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