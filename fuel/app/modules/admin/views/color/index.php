<div class="breadcrumb">
    <h1><?php echo __('_color.title'); ?></h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<?php if (\Auth::has_access('administration.color[create]')) : ?>
    <div class="row">
        <div class="col-md-7">
            <a href="<?php echo Uri::create("admin/color/create"); ?>" class="btn btn-info"><i class="i-Add"></i> <?php echo __('_button.create'); ?></a>
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
                                    <tr>
                                        <th class="text-center"><?php echo __('_color.table.description'); ?></th>
                                        <th style="width:25%" class="text-center"><?php echo __('_color.table.actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($colors)) : ?>
                                        <td colspan="2" class="text-center"><?php echo __('_color.no_data'); ?></td>
                                    <?php else : ?>
                                        <?php foreach ($colors as $color) :; ?>
                                            <tr class="text-center">
                                                <td><?php echo $color->description; ?></td>
                                                <td>
                                                    <?php if ($color->active == 1) : ?>
                                                        <?php echo Html::anchor('admin/color/edit/' . $color->id . '', '<i class="nav-icon i-Pen-4 font-weight-bold icon-edit"></i>', array('class' => '')); ?>
                                                    <?php endif; ?>
                                                    &nbsp;
                                                    <?php if ($color->active == 1) : ?>
                                                        <a class="btn-disabled" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/color/activate_unactivate/{$color->id}/0"); ?>"><i class="nav-icon i-Unlock-2 font-weight-bold icon-disable"></i></a>
                                                    <?php else : ?>
                                                        <a class="btn-activate" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/color/activate_unactivate/{$color->id}/1"); ?>"><i class="nav-icon i-Lock-2 font-weight-bold icon-activate"></i></a>
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