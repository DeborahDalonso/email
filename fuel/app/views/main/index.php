<fieldset>
    <div class="row mb-3">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-left">
                        <h6>Envio de e-mail (apenas outlook)</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Email destinatário</label>
                        <input type="email" class="form-control email" id="mail-to" placeholder="teste@outlook.com">
                        <p id="message_format"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email remetente</label>
                        <input type="email" class="form-control email" id="mail-from" placeholder="teste@outlook.com">
                        <p id="message_format"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assunto da mensagem</label>
                        <input type="email" class="form-control" id="mail-subject" placeholder="Assunto da mensagem">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensagem</label>
                        <textarea class="form-control" rows="5" id="mail-message" placeholder="Mensagem"></textarea>
                    </div>
                    <hr>
                    <button type="button" class='btn btn-primary' id="send"><?php echo 'Enviar'; ?></button>
                </div>
            </div>
        </div>
</fieldset>