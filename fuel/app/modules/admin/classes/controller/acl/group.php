<?php

namespace Admin\Controller\Acl;

class Group extends \Controller\Admin
{

    protected $disallowedEditDelete = array(1, 2, 3, 4, 5, 6);

    public function before()
    {
        if (!\Input::is_ajax()) {
            if (!\Auth::has_access('administration.group[access]')) {
                \Session::set_flash('error', 'Acesso negado!');
                \Response::redirect('/');
            }
        }

        parent::before();

        \lang::load('group');
        
    }

    public function action_index()
    {
        $data['usersGroups'] = $this->getGroups();
        $data['disallowedEditDelete'] = $this->disallowedEditDelete;

        $this->template->title = "Grupos de Acesso";

        $this->template->content = \View::forge('acl/group/index', $data);
    }

    public function action_create()
    {
        if (!\Auth::has_access('administration.group[create]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/acl/group');
        }

        if (\Input::method() == 'POST') {
            $val = \Admin\Model\Group::validate('create');

            if ($val->run()) {
                $group = \Auth\Model\Auth_Group::forge(array(
                            'name' => trim(\input::post('name'))
                ));

                if ($group and $group->save()) {
                    \Cache::delete(\Config::get('ormauth.cache_prefix', 'auth') . '.groups');

                    $log = \Model\SystemActivity::forge(array(
                                'user_id' => $this->getCurrentUser()->id,
                                'date' => date('Y-m-d H:i:s'),
                                'event' => \Model\SystemActivity::TYPE_CREATE,
                                'module' => 'Acl/Grupo',
                                'new_registry' => json_encode($group->to_array()),
                    ));
                    $log->save();

                    \Session::set_flash('success', 'Inserido com sucesso!');
                    \Response::redirect('admin/acl/group');
                } else {
                    \Session::set_flash('error', 'Não foi possível criar, tente novamente.');
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = "Grupo de Acesso | Novo";
        $this->template->content = \View::forge('acl/group/create');
    }

    public function action_edit($id = null)
    {
        if (!\Auth::has_access('administration.group[update]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/acl/group');
        }

        is_null($id) and \Response::redirect('administration/acl/group');

        if (!$group = \Auth\Model\Auth_Group::find($id)) {
            \Session::set_flash('error', __('could_not_find_group'));
            \Response::redirect('admin/acl/group');
        }

        $val = \Admin\Model\Group::validate('edit');

        $oldRegistry = $group->to_array();
        if ($val->run()) {

            $group->name = trim(\Input::post('name'));

            if ($group->save()) {
                \Cache::delete(\Config::get('ormauth.cache_prefix', 'auth') . '.groups');

                $log = \Model\SystemActivity::forge(array(
                            'user_id' => $this->getCurrentUser()->id,
                            'date' => date('Y-m-d H:i:s'),
                            'event' => \Model\SystemActivity::TYPE_UPDATE,
                            'module' => 'Acl/Grupo',
                            'old_registry' => json_encode($oldRegistry),
                            'new_registry' => json_encode($group->to_array()),
                ));

                $log->save();
                \Session::set_flash('success', __('updated_group'));
                \Response::redirect('admin/acl/group');
            } else {
                Session::set_flash('error', __('could_not_update_group'));
            }
        } else {
            if (\Input::method() == 'POST') {
                $group->name = $val->validated('name');

                \Session::set_flash('error', $val->error());
            }

            $this->template->set_global('usersGroup', $group, false);
        }

        $this->template->title = "- Editar Perfil de Acesso";
        $this->template->content = \View::forge('acl/group/edit');
    }

    public function action_delete($id = null)
    {
        if (!\Auth::has_access('administration.group[delete]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/acl/group');
        }

        is_null($id) and \Response::redirect('admin/acl/group');

        if ($group = \Admin\Model\Group::find($id)) {
            if ($this->hasUsersInGroup($id)) {
                \Session::set_flash('warning', 'Este perfil de acesso não pode ser removido, pois existe usuários cadastrados.');

                \Response::redirect('admin/acl/group');
            }

            $oldRegistry = $group->to_array();
            $group->delete();

            $log = \Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Model\SystemActivity::TYPE_DELETE,
                        'module' => 'Acl/Grupo',
                        'old_registry' => json_encode($oldRegistry),
            ));
            $log->save();
            \Cache::delete('auth.groups');

            \Session::set_flash('success', 'Deletado com sucesso!');            
        } else {
            \Session::set_flash('error', 'Não foi possivel deletar.');
        }

        \Response::redirect('admin/acl/group');        
    }

    /**
     * Verify if exists user that belongs to a group.
     * 
     * @param int $groupId
     * @return bool
     */
    protected function hasUsersInGroup($groupId)
    {
        $user = \Admin\Model\User::query();
        $user->where('group_id', '=', $groupId);

        return $user->get() ? true : false;
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

}
