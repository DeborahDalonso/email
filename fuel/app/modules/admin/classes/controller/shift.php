<?php

namespace Admin\Controller;

class Shift extends \Controller\Admin
{
    public function before()
    {
        if (!\Auth::has_access('administration.shift[access]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('/');
        }

        parent::before();

        \lang::load('translations');
    }

    public function action_index()
    {
        $data['shifts'] = \Admin\Model\Shift::query()->get();

        $this->template->title = __('_shift.title');
        $this->template->content = \View::forge('shift/index', $data);

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
        if (!\Auth::has_access('administration.shift[create]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/shift');
        }

        if (\Input::method() === 'POST') {
            $shiftData = \Input::post('shift');
            $shifData['description'] = strtoupper($shiftData['description']);

            $shiftCheck = \Admin\Model\Shift::query()
                ->where('description', $shiftData['description'])
                ->get_one();

            if (!empty($shiftCheck)) {
                \Session::set_flash('error', __('_message.error'));
                \Response::redirect("admin/shift");
            }

            $val = \Admin\Model\Shift::validate('create');

            if ($val->run()) {
                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $shiftData['active'] = 1;
                    $shift = \Admin\Model\Shift::forge($shiftData);
                    $shift->save();

                    $log = \Admin\Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Admin\Model\SystemActivity::TYPE_CREATE,
                        'module' => 'admin/shift',
                        'new_registry' => json_encode($shift->to_array())
                    ));

                    $log->save();

                    $db->commit_transaction();

                    \Session::set_flash('success', __('_message.create_success'));
                    \Response::redirect("admin/shift");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', __('_message.error'));
                }
            } else {
                \Session::set_flash('error', __('_message.error'));
            }
        }

        $this->template->title = __('_shift.title_create');
        $this->template->content = \View::forge('shift/create');
    }

    public function action_edit($id = null)
    {
        if (!\Auth::has_access('administration.shift[update]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/shift');
        }

        is_null($id) && \Session::set_flash('warning', 'Turno não encontrado!') && \Response::redirect('admin/shift');

        $shift = \Admin\Model\Shift::find($id);

        if (!$shift) {
            \Session::set_flash('warning', 'Turno não encontrado!');
            \Response::redirect('admin/shift');
        }

        if (\Input::method() === 'POST') {
            $shiftData = \Input::post('shift');
            $shiftCheck = \Admin\Model\Shift::query()
                ->where('description', $shiftData['description'])
                ->where('id', '!=', $id)
                ->get_one();

            if (!empty($shiftCheck)) {
                \Session::set_flash('error', __('_message.error'));
                \Response::redirect("admin/shidt");
            }

            $val = \Admin\Model\Shift::validate('edit');

            if ($val->run()) {
                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $oldShift = $shift->to_array();
                    $shift->set($shiftData);
                    $shift->save();

                    $log = \Admin\Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Admin\Model\SystemActivity::TYPE_UPDATE,
                        'module' => 'admin/shift',
                        'old_registry' => json_encode($oldShift),
                        'new_registry' => json_encode($shift->to_array())

                    ));

                    $log->save();

                    $db->commit_transaction();

                    \Session::set_flash('success', __('_message.update_success'));
                    \Response::redirect("admin/shift");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', __('_message.error'));
                }
            } else {
                \Session::set_flash('error', __('_message.error'));
            }
        }

        $this->template->set_global('shift', $shift);

        $this->template->title = __('_shift.title_update');
        $this->template->content = \View::forge('shift/edit', $shift);
    }

    public function action_activate_unactivate($id = null, $state = null)
    {
        if (!\Auth::has_access('administration.shift[active]')) {
            \Session::set_flash('error', "Acesso negado!");
            \Response::redirect('main');
        }

        (is_null($id) || is_null($state)) && \Session::set_flash('warning', 'Turno não encontrado!') && \Response::redirect('admin/shift');

        // Start Transaction
        $db = \Database_Connection::instance();
        $db->start_transaction();

        try {
            $shift = \Admin\Model\Shift::find($id);

            if (!$shift) {
                throw new \Exception('Turno não encontrado');
            }

            $oldRegistry = $shift->to_array();

            $shift->active = $state;
            $shift->save();

            $newRegistry = $shift->to_array();

            $log = \Model\SystemActivity::forge(array(
                'user_id' => $this->getCurrentUser()->id,
                'date' => date('Y-m-d H:i:s'),
                'event' => isset($state) ? \Model\SystemActivity::TYPE_ACTIVATE : \Model\SystemActivity::TYPE_DISABLED,
                'module' => 'admin/shift',
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

            \Log::error('Disable User - ' . $e->getMessage());
            \Session::set_flash('error', "Não foi possível desativar!");
        }

        \Response::redirect('admin/shift');
    }
}
