<?php

namespace Admin\Controller;

use Console;

class MailList extends \Controller\Admin
{

    protected $businessUnitRepository;

    /**
     * @var bool
     */
    protected $isRoot; // Is the user a super user ?

    /**
     * @var array
     */
    protected $roles = array();

    public function before()
    {
        if (!\Input::is_ajax()) {
            if (!\Auth::has_access('administration.maillist[access]')) {
                \Session::set_flash('error', 'Acesso negado!');
                \Response::redirect('/');
            }
        }

        parent::before();

        \lang::load('translations');
    }

    public function action_index()
    {

        $mailList = \Admin\Model\MailList::find('all');

        $this->template->set_global('mailList', $mailList, false);
        $this->template->title = "Lista de E-mails";
        $this->template->content = \View::forge('maillist/index');
    }

    /**
     * Create an user
     */
    public function action_create()
    {
        if (!\Auth::has_access('administration.maillist[create]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/maillist');
        }

        if (\Input::method() == 'POST') {
            $val = \Admin\Model\MailList::validate('create');
            $mailList = \Input::post('maillist');


            if ($val->run()) {

                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {

                    $query = \DB::insert('mail_list')->columns(array('email'));

                    foreach ($mailList as $email) {

                        $haveEmail = \Admin\Model\MailList::query()
                            ->where('email', $email)
                            ->get_one();

                        if (empty($haveEmail)) {
                            $query->values(array($email));
                        }
                    }

                    $query->execute();

                    $log = \Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Model\SystemActivity::TYPE_CREATE,
                        'module' => 'admin/maillist',
                        'new_registry' => json_encode(array_merge($mailList)),
                    ));

                    $log->save();
                    $db->commit_transaction();

                    \Session::set_flash('success', "Adicionado com sucesso!");
                    \Response::redirect("admin/maillist");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', $val->error());
                    \Session::set_flash('error', "Erro ao adicionar");
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $emailsObj = \Admin\Model\MailList::query()
            ->where('active', 1)
            ->get();

        //To check in js if the email that the user is trying to register already exists in the base
        $emailsArr =  $this->createArrayFromAnObject($emailsObj);

        $emailsJson = json_encode($emailsArr);

        $this->template->title = 'Lista de E-mail | Novo';
        $this->template->content = \View::forge('maillist/create');

        $scripts = [
            \Asset::js("var EMAILS = {$emailsJson};", array(), null, true), // Create a variable with json
            \Asset::js('module/admin/maillist/main.js')
        ];

        $this->template->set('extra_js', implode('', $scripts), false);
    }

    private function createArrayFromAnObject($objs)
    {
        $array = [];

        foreach ($objs as $obj) {
            $array[] = [
                'email' => $obj['email']
            ];
        }

        return $array;
    }

    /**
     * Edit an user
     *
     * @param int $id
     */
    public function action_edit($id = null)
    {
        if (!\Auth::has_access('administration.maillist[update]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/maillist');
        }

        is_null($id) && \Session::set_flash('warning', 'Id não encontrado!') && \Response::redirect('admin/maillist');

        $mailListItem = \Admin\Model\MailList::find($id);

        if (!$mailListItem) {
            \Session::set_flash('error', __('_user.message.access_denied'));
            \Response::redirect('admin/maillist');
        }

        if ($mailListItem->active == 0) {
            \Session::set_flash('error', __('_user.message.user_disabled'));
            \Response::redirect('admin/maillist');
        }

        if (\Input::method() == 'POST') {
            $val = \Admin\Model\User::validate('edit');
            $email = \Input::post();

            $checkEmailExist = \Admin\Model\MailList::query()
                ->where('email', $email)
                ->where('id', '!=', $id)
                ->get_one();

            if (isset($checkEmailExist)) {
                \Session::set_flash('error', 'Este e-mail já existe!');
                \Response::redirect('admin/user');
            }

            if ($val->run(null, true)) {
                // Start Transaction
                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $oldRegistry = $mailListItem;

                    $mailListItem->set($email);
                    $mailListItem->save();

                    $newRegistry = $mailListItem;

                    $log = \Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Model\SystemActivity::TYPE_UPDATE,
                        'module' => 'admin/maillist',
                        'old_registry' => json_encode($oldRegistry),
                        'new_registry' => json_encode($newRegistry),
                    ));

                    $log->save();

                    $db->commit_transaction();

                    \Session::set_flash('success', "Editado com sucesso!");
                    \Response::redirect('admin/maillist');
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', "Erro ao editar");
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->set_global('mailListItem', $mailListItem, false);

        $this->template->title = 'Lista de E-mail | Editar';
        $this->template->content = \View::forge('maillist/edit');
    }

    public function action_delete($id = null)
    {
        if (!\Auth::has_access('administration.mailist[delete]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/maillist');
        }

        is_null($id) && \Session::set_flash('error', 'Id não encontrado!') && \Response::redirect('admin/maillist');

        $email = \Admin\Model\MailList::find($id);

        if (!$email) {
            \Session::set_flash('error', __('_user.message.user_disabled'));
            \Response::redirect('admin/maillist');
        }

        if ($email->active == 0) {
            \Session::set_flash('error', __('_user.message.user_disabled'));
            \Response::redirect('admin/maillist');
        }

        // Start Transaction
        $db = \Database_Connection::instance();
        $db->start_transaction();

        try {
            $oldRegistry = $email->to_array();

            $email->delete();

            $log = \Model\SystemActivity::forge(array(
                'user_id' => $this->getCurrentUser()->id,
                'date' => date('Y-m-d H:i:s'),
                'event' => \Model\SystemActivity::TYPE_DELETE,
                'module' => 'admin/maillist',
                'old_registry' => json_encode($oldRegistry),
            ));
            $log->save();
            $db->commit_transaction();

            \Session::set_flash('success', 'Excluido com sucesso!');
        } catch (\Exception $e) {
            $db->rollback_transaction();

            \Log::error('Disable User - ' . $e->getMessage());
            \Session::set_flash('error', 'Erro ao excluir!');
        }

        \Response::redirect('admin/maillist');
    }

    public function action_activate_unactivate($id = null, $state = null)
    {
        if (!\Auth::has_access('administration.maillist[active]')) {
            \Session::set_flash('error', __('_user.message.access_denied'));
            \Response::redirect('admin/maillist');
        }

        (is_null($id) || is_null($state)) && \Session::set_flash('warning', 'Id não encontrado!') && \Response::redirect('admin/maillist');

        // Start Transaction
        $db = \Database_Connection::instance();
        $db->start_transaction();

        try {
            $email = \Admin\Model\MailList::find($id);

            if (!$email) {
                throw new \Exception(__('_user.message.user_notfound'));
            }

            $oldRegistry = $email->to_array();

            $email->active = $state;
            $email->save();

            $newRegistry = $email->to_array();

            $log = \Model\SystemActivity::forge(array(
                'user_id' => $this->getCurrentUser()->id,
                'date' => date('Y-m-d H:i:s'),
                'event' => \Model\SystemActivity::TYPE_DISABLED,
                'module' => 'admin/maillist',
                'old_registry' => json_encode($oldRegistry),
                'new_registry' => json_encode($newRegistry)
            ));

            $log->save();
            $db->commit_transaction();

            $message = 'Desativado';

            if ($state) {
                $message = 'Ativado';
            }

            \Session::set_flash('success', $message . ' com sucesso!');
        } catch (\Exception $e) {
            $db->rollback_transaction();

            \Log::error($e->getMessage());
            \Session::set_flash('error', 'Erro ao desativar!');
        }

        \Response::redirect('admin/maillist');
    }
}
