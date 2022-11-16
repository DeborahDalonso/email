<div class="breadcrumb">
    <h1><?php echo "Lista de E-mails"; ?></h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<?php if (\Auth::has_access('administration.maillist[create]')) : ?>
    <div class="row">
        <div class="col-md-7">
            <a href="<?php echo Uri::create('admin/maillist/create'); ?>" class="btn btn-info"><i class="i-Add"></i><?php echo __('_button.create'); ?></a>
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
                                        <th><?php echo "e-mail"; ?></th>
                                        <th><?php echo "status"; ?></th>
                                        <th style="width: 150px;"><?php echo 'Ações'; ?></th>
                                    </tr>
                                </thead>
                                <tbody style="font-weight: normal;">
                                    <?php if (empty($mailList)) : ?>
                                        <td colspan="3" class="text-center"><?php echo "Sem e-mails cadastrados." ?></td>
                                    <?php else : ?>
                                        <?php foreach ($mailList as $mail) :; ?>
                                            <tr class="text-center">
                                                <td><?php echo $mail->email; ?></td>
                                                <td><?php echo $mail->active == 1 ? 'Ativo' : 'Desativado'; ?></td>
                                                <td>
                                                    <?php if ($mail->active == 1) : ?>
                                                        <?php echo Html::anchor('admin/mailList/edit/' . $mail->id . '', '<i class="nav-icon i-Pen-4 font-weight-bold icon-edit"></i>', array('class' => '')); ?>
                                                        &nbsp;
                                                        <a class="btn-disabled" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/mailList/activate_unactivate/{$mail->id}/0"); ?>"><i class="nav-icon i-Unlock-2 font-weight-bold icon-disable"></i></a>
                                                        &nbsp;
                                                        <a class="delete" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/mailList/delete/{$mail->id}"); ?>"><i class="nav-icon i-Close-Window font-weight-bold icon-delete"></i></a>
                                                        &nbsp;
                                                    <?php else : ?>
                                                        <a class="btn-activate" href="javascript:void(0);" data-url="<?php echo Uri::create("admin/mailList/activate_unactivate/{$mail->id}/1"); ?>"><i class="nav-icon i-Lock-2 font-weight-bold icon-activate"></i></a>
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