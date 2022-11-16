<div class="breadcrumb">
    <h1><?php echo 'Registro de Atividades';?></h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row mb-3">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <label><?php echo __('users_log.filter.start_date');?></label>
                            <input type="date" id="start_date" name="start_date" class="form-control parsley-validated" data-required="true" value="<?php echo \Input::post('start_date', isset($startDate) ? $startDate : null); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label><?php echo __('users_log.filter.end_date');?></label>
                            <input type="date" id="end_date" name="end_date" class="form-control parsley-validated" data-required="true" value="<?php echo \Input::post('end_date', isset($endDate) ? $endDate : null); ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <br><button type="submit" class="btn btn-info">
                                <?php echo __('users_log.button.search');?>
                                    <i class="fa fa-cog fa-spin hidden action-loader"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
<?php if (!empty($usersName) && isset($usersName)) : ?>
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
                                            <th class="text-center"><?php echo __('users_log.table.date_and_time');?></th>
                                            <th class="text-center"><?php echo __('users_log.table.user');?></th>
                                            <th class="text-center"><?php echo __('users_log.table.module');?></th>
                                            <th class="text-center"><?php echo __('users_log.table.event');?></th>
                                            <th class="text-center"><?php echo __('users_log.table.actions');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usersName as $userName) :; ?>
                                            <tr class="text-center">
                                                <td><?php echo !empty($userName) && isset($userName) ? $userName['date'] : '-'; ?></td>
                                                <td><?php echo !empty($userName) && isset($userName) ? $userName['username'] : '-'; ?></td>
                                                <td><?php echo !empty($userName) && isset($userName) ? $userName['module'] : '-'; ?></td>
                                                <td><?php echo !empty($userName) && isset($userName) ? $userName['event'] : '-'; ?></td>
                                                <td width="12px">
                                                    <button class="btn btn-primary detailed-status" data-new_registry="<?php echo $userName['new_registry']; ?>" data-old_registry="<?php echo $userName['old_registry']; ?>">
                                                        <i class="fa fa-table"></i> <?php echo __('users_log.button.detail');?>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif (empty($startDate) && empty($endDate)) : ?>
    <table id="zero_configuration_table" class="display table table-striped table-bordered datable">
        <thead>
        </thead>
        <tbody>
            <tr class="text-center">
                <td colspan="4" class="text-center"><?php echo __('users_log.no_data');?></td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>