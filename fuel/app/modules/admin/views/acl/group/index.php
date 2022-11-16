<div class="breadcrumb">
    <h1>Grupos de Acesso</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<?php if (\Auth::has_access('administration.group[create]')) : ?>
    <div class="row">
        <div class="form-group">
            <div class="pull-right">
                <div class="col-md-12">
                    <?php echo Html::anchor('admin/acl/group/create', '<i class="i-Add"></i> Adicionar', array('class' => 'btn btn-primary')); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row mb-3">
    <div class="col-md-12 mb-3">
        <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="zero_configuration_table" class="display table table-striped table-bordered datatable">
                        <thead>
                            <tr class="text-center">
                                <th>Nome</th>
                                <th style="width: 150px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($usersGroups) : ?>
                                <?php foreach ($usersGroups as $item) : ?>
                                    <tr class="text-center">
                                        <td class="valign-middle"><?php echo $item->name; ?></td>
                                        <td class="valign-middle">
                                            <?php echo Html::anchor('admin/acl/group/edit/' . $item->id . '', '<i class="nav-icon i-Pen-4 font-weight-bold icon-edit"></i>', array('class' => '')); ?>
                                            &nbsp;
                                            <?php echo Html::anchor('admin/acl/group/delete/' . $item->id . '', '<i class="nav-icon i-Close-Window font-weight-bold icon-delete"></i>', array('class' => '')); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr class="text-center">
                                    <td colspan="2">
                                        Não há grupos cadastrados
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>