var Dialog = window.dialog || {};

const sendEmail = (mail) => {
    return $.ajax({
        url: HOST + 'main/send_mail',
        data: { 'mailTo': mail.to, 'mailFrom': mail.from, 'mailSubject': mail.subject, 'mailMessage': mail.message, 'mailPassword': mail.password },
        type: 'post',
        dataType: 'json'
    });
};

const isEmail = (email) => {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    }
    return true;
}

$(function () {
    Dialog = (function () {

        function show(message, conf = {}) {
            var _conf = conf;

            console.log(conf);
            var settings = $.extend({
                title: '<i class="glyphicon glyphicon-exclamation-sign"></i> Atenção!',
                message: message || "",
                type: BootstrapDialog.TYPE_DANGER,
                size: BootstrapDialog.SIZE_SMALL,
                closable: false,
                closeByBackdrop: false,
                closeByKeyboard: false,
                buttons: conf.buttons || [{
                    label: 'Ok',
                    action: function (dialogRef) {
                        dialogRef.close();
                    }
                }]
            }, _conf);

            BootstrapDialog.show(settings);
        };

        function __processing(conf) {
            var conf = conf || {};

            return BootstrapDialog.show({
                title: conf.title || 'Carregando...',
                message: '<div class="loader-image loader-bubble loader-bubble-primary m-5"></div>',
                type: BootstrapDialog.TYPE_PRIMARY,
                size: BootstrapDialog.SIZE_SMALL,
                closable: conf.closable || false,
                closeByBackdrop: conf.closeByBackdrop || false,
                closeByKeyboard: conf.closeByKeyboard || false,
                onhidden: conf.onhidden || function () { }
            });
        };

        return {
            show: show,
            processing: __processing

        };
    })();

    $('.email').on('input', function () {
        let that = $(this),
        email = that.val(),
        message = that.siblings('p');

        that.css("border", "1px solid red");
        message.text('E-mail fora do formato correto');
        message.css('color', 'red');

        if (isEmail(email)) {
            that.css("border", "1px solid green");
            message.text('E-mail no formato correto');
            message.css('color', 'green');
        }
    })

    $('#send').click('click', function () {
        let
            mail = {
                to: $('#mail-to').val(),
                from: $('#mail-from').val(),
                subject: $('#mail-subject').val(),
                message: $('#mail-message').val()
            },
            html = `
            <div class="form-group">
                    <label for="mail-password"><strong>Informe a senha do e-mail do remetente:</strong></label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" class="form-control" id="mail-password" class="form-control" placeholder="Senha">
                        <div class="input-group-append">
                            <span class="input-group-text" style="border-top-right-radius: 1rem; border-bottom-right-radius: 1rem; ">
                                <a href=""><i class="fa i-Eye" aria-hidden="true"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
        `,
            $confSize = {
                maxWidth: 900,
                maxHeight: 800,
                width: 900,
                height: 800,
                size: '',
            };


        if (!$('#mail-to').val() || !$('#mail-from').val() || !$('#mail-subject').val() || !$('#mail-message').val()) {
            Dialog.show("Preencha todos os campos!");
            return;
        }

        if (!isEmail(mail.to)) {
            Dialog.show('O e-mail "' + mail.to + '" não está no formato correto!', $confSize);
            return false;
        }

        if (!isEmail(mail.from)) {
            Dialog.show('O e-mail "' + mail.from + '" não está no formato correto!', $confSize);
            return false;
        }

        
        if (!mail.to.includes("outlook")) {
            Dialog.show('O e-mail "' + mail.from + '" não é um outlook!', $confSize);
            return false;
        }

        Dialog.show(html, {
            buttons: [
                {
                    label: 'Enviar',
                    cssClass: 'btn-primary',
                    action: function (dialog) {
                        let
                            password = dialog.getModalBody().find('#mail-password').val();

                        mail['password'] = password;

                        if (!password) {
                            Dialog.show("Preencha a senha!");
                            return;
                        }

                        $.when(sendEmail(mail)).done(function (resp) {
                            Dialog.show(resp.message);
                            dialog.close();
                        });
                    }
                },
                {
                    label: 'Cancelar',
                    cssClass: 'btn-dark',
                    action: function (dialogRef) {
                        dialogRef.close();
                    }
                }
            ]
        });
    });

    $("body").click('#show_hide_password a', function (event) {

        event.preventDefault();

        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });
})
