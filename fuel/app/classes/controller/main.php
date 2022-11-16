<?php

namespace controller;

class Main extends Admin
{
    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $this->template->title = "Home";
        $this->template->content = \View::forge('main/index');
    }

    public function post_send_mail()
    {
        if (!\Input::is_ajax()) {
            die();
        }

        $mailTo = \Input::post('mailTo');
        $mailFrom = \Input::post('mailFrom');
        $mailSubject = \Input::post('mailSubject');
        $mailMessage = \Input::post('mailMessage');
        $mailPassword = \Input::post('mailPassword');

        $response = array(
            'status' => 'success',
            'data' => [],
            'message' => ''
        );

        try {

            $mail = new \KMailer();

            $mail->isSMTP(true);

            $mail->setUserName($mailFrom);
            $mail->setPassword($mailPassword);

            $mail->Subject = $mailSubject;
            $mail->setFrom($mailFrom, $mailFrom);
            $mail->addAddress($mailTo, $mailTo);

            $mail->Body = '<b>' . $mailMessage . '</b>';

            $mail->send();

            $response['message'] = 'Enviado com sucesso!';
        } catch (\EmailValidationFailedException $e) {
            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
        } catch (\EmailSendingFailedException $e) {
            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
        } catch (\SmtpAuthenticationFailedException $e) {
            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
        } catch (phpmailerException $e) {
            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
        }

        return \Response::forge(json_encode($response));
    }
}
