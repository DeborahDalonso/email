<?php

namespace Admin\Controller;

class User extends \Controller\Admin
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
            if (!\Auth::has_access('administration.user[access]')) {
                \Session::set_flash('error', __('_user.message.access_denied'));
                \Response::redirect('/');
            }
        }

        parent::before();

        \lang::load('groups');
        \lang::load('translations');

        $this->isRoot = \Auth::member(\Admin\Model\User::GROUP_ROOT);
        $this->roles = $this->getGroups();
    }

    public function action_index()
    {
        $users = $this->getUserList();

        $this->template->set_global('users', $users, false);
        $this->template->title = __('_user.title');
        $this->template->content = \View::forge('user/index');
    }

    /**
     * Create an user
     */
    public function action_create()
    {
        if (!\Auth::has_access('administration.user[create]')) {
            \Session::set_flash('error', __('_user.message.access_denied'));
            \Response::redirect('admin/user');
        }

        $this->getGroups();

        if (\Input::method() == 'POST') {
            $val = \Admin\Model\User::validate('create');
            $username = \Input::post('user.username');
            $users = \Admin\Model\User::query()
                ->where('username', $username)
                ->get_one();

            if (isset($users)) {
                \Session::set_flash('error', 'Este usuário já existe!');
                \Response::redirect('admin/user');
            }

            if ($val->run()) {

                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $userData = \Input::post('user');
                    $userFullname = \Input::post('usermetadata.fullname');
                    $password = \Helper\Util::randomPasswordGenerator();

                    $userData['password'] = \Auth::hash_password($password);
                    $userData['first_login'] = 1;
                    $userData['last_login'] = 0;
                    $userData['previous_login'] = 0;
                    $userData['login_hash'] = 0;
                    $userData['user_id'] = 0;
                    $userData['active'] = 1;

                    $user = \Admin\Model\User::forge($userData);
                    $user->save();
                    $user->fullname = ucwords($userFullname);
                    $user->save();

                    $log = \Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Model\SystemActivity::TYPE_CREATE,
                        'module' => 'admin/user',
                        'new_registry' => json_encode($user->to_array()),
                    ));

                    $log->save();

                    $db->commit_transaction();

                    \Session::set_flash('success', __('_user.message.create_success'));
                    \Session::set_flash('warning', 'A senha criada é: ' . $password);
                    \Response::redirect("admin/user");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', $val->error());
                    \Session::set_flash('error', __('_user.message.create_fail'));
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $groups = $this->getGroups();

        $this->template->set_global('groups', $groups, true);

        $this->template->title = __('_user.title_create');
        $this->template->content = \View::forge('user/create');
    }

    /**
     * Edit an user
     *
     * @param int $id
     */
    public function action_edit($id = null)
    {

        if (!\Auth::has_access('administration.user[update]')) {
            \Session::set_flash('error', __('_user.message.access_denied'));
            \Response::redirect('admin/user');
        }

        $user = \Admin\Model\User::find($id);

        if (!$user) {
            \Session::set_flash('error', __('_user.message.access_denied'));
            \Response::redirect('admin/user');
        }

        $userMetadata = \Admin\Model\Metadata::query()
            ->where('parent_id', $id)
            ->get_one();

        if (!$user) {
            \Session::set_flash('error', __('_user.message.access_denied'));
            \Response::redirect('admin/user');
        }

        if ($user->active == 0) {
            \Session::set_flash('error', __('_user.message.user_disabled'));
            \Response::redirect('admin/user');
        }

        if (\Input::method() == 'POST') {
            $val = \Admin\Model\User::validate('edit');
            $username = \Input::post('user.username');
            $users = \Admin\Model\User::query()
                ->where('username', $username)
                ->where('id', '!=', $id)
                ->get_one();

            if (isset($users)) {
                \Session::set_flash('error', 'Este usuário já existe!');
                \Response::redirect('admin/user');
            }
            if ($val->run(null, true)) {
                // Start Transaction
                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $userData = \Input::post('user');

                    $userFullname = \Input::post('usermetadata.fullname');

                    $oldUser = $user->to_array();
                    $user->set($userData);
                    $user->fullname = ucwords($userFullname);
                    $user->save();

                    $log = \Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Model\SystemActivity::TYPE_UPDATE,
                        'module' => 'admin/user',
                        'old_registry' => json_encode($oldUser),
                        'new_registry' => json_encode($user->to_array()),
                    ));

                    $log->save();

                    $db->commit_transaction();

                    // flush Auth perms for edited user
                    \Cache::delete(\Config::get('ormauth.cache_prefix', 'auth') . '.permissions.user_' . $id);
                    \Session::set_flash('success', __('_user.message.edit_success'));

                    \Response::redirect('admin/user');
                } catch (Exception $ex) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', __('_user.message.edit_fail'));
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $userFullname = '';

        if (isset($userMetadata) && $userMetadata['key'] == 'fullname') {
            $userFullname =  $userMetadata['value'];
        }

        $groups = $this->getGroups();

        $this->template->set_global('groups', $groups, true);
        $this->template->set_global('user', $user, false);
        $this->template->set_global('fullname', $userFullname, false);

        $this->template->title = __('_user.title_edit');
        $this->template->content = \View::forge('user/edit');
    }

    public function action_delete($id = null)
    {
        if (!\Auth::has_access('administration.user[active]')) {
            \Session::set_flash('error', __('_user.message.access_denied'));
            \Response::redirect('admin/user');
        }

        is_null($id) && \Session::set_flash('error', "Usuario não encontrado!") && \Response::redirect('admin/user');

        // Start Transaction
        $db = \Database_Connection::instance();
        $db->start_transaction();

        try {
            $user = \Admin\Model\User::find($id);

            if (!$user) {
                throw new \Exception(__('_user.message.user_notfound'));
            }


            $oldRegistry = $user->to_array();

            $user->active = 0;
            $user->save();

            $newRegistry = $user->to_array();

            $log = \Model\SystemActivity::forge(array(
                'user_id' => $this->getCurrentUser()->id,
                'date' => date('Y-m-d H:i:s'),
                'event' => \Model\SystemActivity::TYPE_DISABLED,
                'module' => 'admin/user',
                'old_registry' => json_encode($oldRegistry),
                'new_registry' => json_encode($newRegistry)
            ));
            $log->save();

            \Cache::delete(\Config::get('ormauth.cache_prefix', 'auth') . '.permissions.user_' . $id);

            $db->commit_transaction();

            \Session::set_flash('success', __('_user.message.user_deactivation'));
        } catch (\Exception $e) {
            $db->rollback_transaction();

            \Log::error('Disable User - ' . $e->getMessage());
            \Session::set_flash('error', __('_user.message.user_deactivation_fail'));
        }

        \Response::redirect('admin/user');
    }

    public function action_activate_unactivate($id = null, $state = null)
    {
        if (!\Auth::has_access('administration.user[active]')) {
            \Session::set_flash('error', __('_user.message.access_denied'));
            \Response::redirect('admin/user');
        }

        (is_null($id) || is_null($state)) && \Session::set_flash('error', "Usuario não encontrado!") && \Response::redirect('admin/user');

        // Start Transaction
        $db = \Database_Connection::instance();
        $db->start_transaction();

        try {
            $user = \Admin\Model\User::find($id);

            if (!$user) {
                throw new \Exception(__('_user.message.user_notfound'));
            }

            $oldRegistry = $user->to_array();

            $user->active = $state;
            $user->save();

            $newRegistry = $user->to_array();

            $log = \Model\SystemActivity::forge(array(
                'user_id' => $this->getCurrentUser()->id,
                'date' => date('Y-m-d H:i:s'),
                'event' => isset($state) ? \Model\SystemActivity::TYPE_ACTIVATE : \Model\SystemActivity::TYPE_DISABLED,
                'module' => 'admin/user',
                'old_registry' => json_encode($oldRegistry),
                'new_registry' => json_encode($newRegistry)
            ));
            
            $log->save();
            
            $db->commit_transaction();

            $message = 'Desativado';
            
            if($state){
                $message = 'Ativado';
            }

            \Cache::delete(\Config::get('ormauth.cache_prefix', 'auth') . '.permissions.user_' . $id);
            \Session::set_flash('success', $message . ' com sucesso!');
        } catch (\Exception $e) {
            $db->rollback_transaction();

            \Log::error($e->getMessage());
            \Session::set_flash('error', __('_user.message.user_activation_fail'));
        }

        \Response::redirect('admin/user');
    }

    public function action_reset_password($id)
    {
        if (!\Auth::has_access('administration.user[reset]')) {
            \Session::set_flash('error', __('_user.message.access_denied'));
            \Response::redirect('admin/user');
        }

        $user = \Admin\Model\User::find($id);

        is_null($id) && (\Session::set_flash('error', "Usuario não encontrado!") && \Response::redirect('admin/user'));

        $password = \Helper\Util::randomPasswordGenerator();

        $passwordHash = \Auth::hash_password($password);

        $user->password = $passwordHash;
        $user->first_login = 1;
        $user->save();

        \Session::set_flash('success', 'Senha atualizada com sucesso!');
        \Session::set_flash('warning', 'A senha nova é: ' . $password);
        \Response::redirect("admin/user");
    }

    protected function getGroups()
    {
        $isRoot = \Auth::member(\Admin\Model\User::GROUP_ROOT);

        $groups = \Admin\Model\Group::query();

        if ($isRoot) {
            $groups->where('id', '!=', \Admin\Model\User::GROUP_ROOT);
        } else {
            $groups->where('id', '<', \Admin\Model\User::GROUP_ROOT);
        }

        return $groups->get();
    }

    protected function alreadyExistEmail($email, $id = null)
    {
        $userQuery = \Admin\Model\User::query();
        $where = array();

        array_push($where, array('email', '=', $email));

        if ($id) {
            array_push($where, array('id', '!=', $id));
        }
        $user = $userQuery->where($where)
            ->get();

        return $user ? true : false;
    }

    protected function getUserList()
    {
        $userQuery = \Admin\Model\User::query()
            ->related('group')
            ->order_by('username')
            ->where('group_id', '!=', \Admin\Model\User::GROUP_ROOT);

        if (!$this->isRoot) {
            $userQuery->where('group_id', '!=', \Admin\Model\User::GROUP_ADMIN);
        }

        return $userQuery->get();
    }

    protected function getUserByEmail($email)
    {
        $user = \Admin\Model\User::query()
            ->where('email', '=', $email)
            ->get_one();

        if (!$user) {
            return null;
        }

        return $user;
    }
}
