<?php

namespace Admin\Controller;

class Machine extends \Controller\Admin
{

    public function before()
    {
        if (!\Input::is_ajax()) {
            if (!\Auth::has_access('administration.machine[access]')) {
                \Session::set_flash('error', 'Acesso negado!');
                \Response::redirect('/');
            }
        }

        parent::before();

        \lang::load('translations');
    }

    public function action_index()
    {
        $machines = \Admin\Model\Machine::find('all');

        $tplData['machines'] = $machines;

        $this->template->title = __('_machine.title');
        $this->template->content = \View::forge('machine/index', $tplData);

        $this->template->set('extra_js', \Asset::js(
            array(
                'vendor/datatables.min.js'
            )

        ), false);

        $this->template->set('extra_css', \Asset::css(array(
            'vendor/datatables.min.css',
        )), false);
    }

    public function action_create()
    {
        if (!\Auth::has_access('administration.machine[create]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/machine');
        }

        if (\Input::method() === 'POST') {
            $machineData = \Input::post('machine');

            $haveMachine = \Admin\Model\Machine::query()
                ->where('description', $machineData['description'])
                ->get_one();

            if (!empty($haveMachine)) {
                \Session::set_flash('error', __('_message.existing_data'));
                \Response::redirect("admin/machine");
            }

            $val = \Admin\Model\Machine::validate('create');

            if ($val->run()) {

                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $machineData['active'] = 1;
                    $machine = \Admin\Model\Machine::forge($machineData);
                    $machine->save();

                    $log = \Admin\Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Model\SystemActivity::TYPE_CREATE,
                        'module' => 'Admin/Machine',
                        'new_registry' => json_encode($machine->to_array())
                    ));

                    $log->save();

                    $db->commit_transaction();

                    \Session::set_flash('success',  __('_message.create_success'));
                    \Response::redirect("admin/machine");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', __('_message.error'));
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = 'Máquina | Novo';
        $this->template->content = \View::forge('machine/create');
    }

    public function action_edit($id = null)
    {
        if (!\Auth::has_access('administration.machine[update]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/machine');
        }

        is_null($id) && \Session::set_flash('warning', 'Máquina não encontrada!') && \Response::redirect('admin/machine');

        $machine = \Admin\Model\Machine::find($id);

        if (!$machine) {
            \Session::set_flash('warning', 'Máquina não encontrada!');
            \Response::redirect('admin/machine');
        }

        if (\Input::method() === 'POST') {
            $machineData = \Input::post('machine');

            $machineCheck = \Admin\Model\Machine::query()
                ->where('description', $machineData['description'])
                ->where('id', '!=', $id)
                ->get_one();

            if (!empty($machineCheck)) {
                \Session::set_flash('error', __('_message.existing_data'));
                \Response::redirect("admin/machine");
            }

            $val = \Admin\Model\Machine::validate('edit');
            if ($val->run()) {
                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $oldMachine = $machine->to_array();
                    $machine->set($machineData);
                    $machine->save();

                    $log = \Admin\Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Model\SystemActivity::TYPE_UPDATE,
                        'module' => 'Admin/Machine',
                        'old_registry' => json_encode($oldMachine),
                        'new_registry' => json_encode($machine->to_array())
                    ));

                    $log->save();

                    $db->commit_transaction();

                    \Session::set_flash('success', __('_message.update_success'));
                    \Response::redirect("admin/machine");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', __('_message.error'));
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->set_global('machine', $machine);
        $this->template->title = 'Máquina | Editar';
        $this->template->content = \View::forge('machine/edit');
    }

    public function action_activate_unactivate($id = null, $state = null)
    {
        if (!\Auth::has_access('administration.machine[active]')) {
            \Session::set_flash('error', "Acesso negado!");
            \Response::redirect('main');
        }

        (is_null($id) || is_null($state)) && \Session::set_flash('warning', 'Máquina não encontrada!') && \Response::redirect('admin/machine');

        // Start Transaction
        $db = \Database_Connection::instance();
        $db->start_transaction();

        try {
            $machine = \Admin\Model\Machine::find($id);

            if (!$machine) {
                throw new \Exception('Maquina não encontrada');
            }

            $oldRegistry = $machine->to_array();

            $machine->active = $state;
            $machine->save();

            $newRegistry = $machine->to_array();

            $log = \Model\SystemActivity::forge(array(
                'user_id' => $this->getCurrentUser()->id,
                'date' => date('Y-m-d H:i:s'),
                'event' => isset($state) ? \Model\SystemActivity::TYPE_ACTIVATE : \Model\SystemActivity::TYPE_DISABLED,
                'module' => 'Admin/Machine',
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
            \Session::set_flash('error', "Não foi possível desativar!");
        }

        \Response::redirect('admin/machine');
    }
}
