<style>
    .input {
        border: 0;
        outline: 0;
    }

    .input[readonly] {
        background-color: white;
        pointer-events: none;
    }
</style>
<form method="POST">
    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 style="float: left">Adicionar e-mail</h5>
                    <a style="float: right" href="<?php echo Uri::create('admin/maillist') ?>" class="btn btn-danger" role="button"><?php echo __('_button.cancel') ?></a>
                </div>
                <div class="card-body">
                    <p class="card-description">E-mail</p>
                    <div class="input-group col-sm-12">
                        <input type="email" class='form-control' placeholder=<?php echo __('_user.form.useremail') ?> id='email' />
                        <div class="input-group-append">
                            <button class="btn btn-danger add_email" type="button" data-rows="0"><i class="i-Add"></i><?php echo __('_button.create'); ?></button>
                        </div>
                    </div>
                    <br>
                    <p id="message_format"></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 style="float: left">Lista de e-mails</h5>
                    <button style="float: right" type="submit" class="btn btn-info"><?php echo __('_button.save') ?></button>
                </div>
                <div class="card-body" id="email_list">
                    <table class="message_email_list table table-striped table-bordered">
                        <tbody>
                            <tr class="text-center">
                                <td class="text-center">Nenhum e-mail adicionado</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>