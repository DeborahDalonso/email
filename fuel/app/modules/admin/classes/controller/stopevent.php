<?php

namespace Admin\Controller;

class StopEvent extends \Controller\Admin
{
    public function before()
    {
        if (!\Input::is_ajax()) {
            if (!\Auth::has_access('administration.stopevent[access]')) {
                \Session::set_flash('error', 'Acesso negado!');
                \Response::redirect('/');
            }
        }

        parent::before();
        \lang::load('translations');
    }

    public function action_index()
    {
        $data['stops'] = \Admin\Model\StopEvent::query()->get();

        $this->template->title = __('_stop.title');
        $this->template->content = \View::forge('stopevent/index', $data);

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
        if (!\Auth::has_access('administration.stopevent[create]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/stopevent');
        }

        if (\Input::method() === 'POST') {
            $stopData = \Input::post('stop');

            $stopCheck = \Admin\Model\StopEvent::query()
                ->where('description', $stopData['description'])
                ->get_one();

            if (!empty($stopCheck)) {
                \Session::set_flash('error', __('_message.error'));
                \Response::redirect("admin/stopevent");
            }

            $val = \Admin\Model\StopEvent::validate('create');

            if ($val->run()) {

                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $stopData['active'] = 1;

                    $stop = \Admin\Model\StopEvent::forge($stopData);

                    $stop->save();

                    $log = \Admin\Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Admin\Model\SystemActivity::TYPE_CREATE,
                        'module' => 'admin/stopevent',
                        'new_registry' => json_encode($stop->to_array())
                    ));

                    $log->save();

                    $db->commit_transaction();

                    \Session::set_flash('success', __('_message.create_success'));
                    \Response::redirect("admin/stopevent");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', __('_message.error'));
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = __('_stop.title_create');
        $this->template->content = \View::forge('stopevent/create');
    }

    public function action_edit($id = null)
    {
        if (!\Auth::has_access('administration.stopevent[update]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/stopevent');
        }

        is_null($id) && \Session::set_flash('warning', 'Evento de parada não encontrado!') && \Response::redirect('admin/stopevent');

        $stop = \Admin\Model\StopEvent::find($id);

        if (!$stop) {
            \Session::set_flash('warning', 'Evento de parada não encontrado!');
            \Response::redirect('admin/stopevent');
        }

        if (\Input::method() === 'POST') {
            $stopData = \Input::post('stop');

            $val = \Admin\Model\StopEvent::validate('edit');

            if ($val->run()) {

                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $oldStop = $stop->to_array();

                    $stop->set($stopData);
                    $stop->save();

                    $log = \Admin\Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Admin\Model\SystemActivity::TYPE_UPDATE,
                        'module' => 'admin/stopevent',
                        'old_registry' => json_encode($oldStop),
                        'new_registry' => json_encode($stop->to_array())

                    ));

                    $log->save();

                    $db->commit_transaction();

                    \Session::set_flash('success', __('_message.update_success'));
                    \Response::redirect("admin/stopevent");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', __('_message.error'));
                }
            } else {
                \Session::set_flash('error', __('_message.error'));
            }
        }

        $this->template->set_global('stop', $stop);

        $this->template->title = __('_stop.title_update');
        $this->template->content = \View::forge('stopevent/edit', $stop);
    }

    public function action_activate_unactivate($id = null, $state = null)
    {
        if (!\Auth::has_access('administration.stopevent[active]')) {
            \Session::set_flash('error', "Acesso negado!");
            \Response::redirect('admin/stopevent');
        }

        (is_null($id) || is_null($state)) && \Session::set_flash('warning', 'Evento de parada não encontrado!') && \Response::redirect('admin/stopevent');

        // Start Transaction
        $db = \Database_Connection::instance();
        $db->start_transaction();

        try {
            $stopEvent = \Admin\Model\StopEvent::find($id);

            if (!$stopEvent) {
                throw new \Exception('Evento de parada não encontrado');
            }

            $oldRegistry = $stopEvent->to_array();

            $stopEvent->active = $state;
            $stopEvent->save();

            $newRegistry = $stopEvent->to_array();

            $log = \Model\SystemActivity::forge(array(
                'user_id' => $this->getCurrentUser()->id,
                'date' => date('Y-m-d H:i:s'),
                'event' => isset($state) ? \Model\SystemActivity::TYPE_ACTIVATE : \Model\SystemActivity::TYPE_DISABLED,
                'module' => 'admin/stopevent',
                'old_registry' => json_encode($oldRegistry),
                'new_registry' => json_encode($newRegistry)
            ));

            $log->save();

            $db->commit_transaction();

            $message = 'Desativado';
            
            if($state){
                $message = 'Ativado';
            }

            \Session::set_flash('success', $message . ' com sucesso!');
        } catch (\Exception $e) {
            $db->rollback_transaction();

            \Log::error($e->getMessage());
            \Session::set_flash('error', "Não foi possível realizar a ação!");
        }

        \Response::redirect('admin/stopevent');
    }
}
