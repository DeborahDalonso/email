<div class="breadcrumb">
    <h3><?php echo __('_scrapEvent.title'); ?></h3>
</div>

<div class="separator-breadcrumb border-top"></div>

<?php if (\Auth::has_access('administration.scrapevent[create]')) : ?>
    <div class="row">
        <div class="col-md-7">
            <a class="btn btn-info" href="<?php echo Uri::create("admin/scrapevent/create"); ?>" role="button"><i class="i-Add"></i><?php echo __('_button.create'); ?></a>
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
                                        <th class="text-center"><?php echo __('_scrapEvent.table.scrap'); ?></th>
                                        <th style="width:25%" class="text-center"><?php echo __('_scrapEvent.table.actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($scrapEvents)) : ?>
                                        <td colspan="2" class="text-center"><?php echo __('_scrapEvent.no_data'); ?></td>
                                    <?php else : ?>
                                        <?php foreach ($scrapEvents as $scrapEvent) : ?>
                                            <tr class="text-center">
                                                <td><?php echo $scrapEvent->description; ?></td>
                                                <td>
                                                    <?php if ($scrapEvent->active == 1) : ?>
                                                        <?php echo Html::anchor('admin/scrapevent/edit/' . $scrapEvent->id . '', '<i class="nav-icon i-Pen-4 font-weight-bold icon-edit"></i>', array('class' => '')); ?>
                                                    <?php endif; ?>
                                                    &nbsp;
                                                    <?php if ($scrapEvent->active == 1) : ?>
                                                        <a class="btn-disabled" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/scrapevent/activate_unactivate/{$scrapEvent->id}/0"); ?>"><i class="nav-icon i-Unlock-2 font-weight-bold icon-disable"></i></a>
                                                    <?php else : ?>
                                                        <a class="btn-activate" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/scrapevent/activate_unactivate/{$scrapEvent->id}/1"); ?>"><i class="nav-icon i-Lock-2 font-weight-bold icon-activate"></i></a>
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