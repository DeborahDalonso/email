<?php

namespace Admin\Controller;

use Exception;

class ScrapEvent extends \Controller\Admin
{

    public function before()
    {
        if (!\Input::is_ajax()) {
            if (!\Auth::has_access('administration.scrapevent[access]')) {
                \Session::set_flash('error', 'Acesso negado!');
                \Response::redirect('/');
            }
        }

        parent::before();

        \lang::load('translations');
    }

    public function action_index()
    {
        $scrapEvents = \Admin\Model\ScrapEvent::query()
            ->get();

        $tplData['scrapEvents'] = $scrapEvents;

        $this->template->title = __('_scrapEvent.title');
        $this->template->content = \View::forge('scrapevent/index', $tplData);

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
        if (!\Auth::has_access('administration.scrapevent[create]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/scrapevent');
        }

        if (\Input::method() === 'POST') {
            $scrapEventData = \Input::post('scrapEvent');

            $havescrapEvent = \Admin\Model\ScrapEvent::query()
                ->where('description', $scrapEventData['description'])
                ->get_one();

            if (!empty($havescrapEvent)) {
                \Session::set_flash('error', __('_message.existing_data'));
                \Response::redirect("admin/scrapevent");
            }

            $val = \Admin\Model\ScrapEvent::validate('create');

            if ($val->run()) {

                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $scrapEventData['active'] = 1;
                    $scrapEvent = \Admin\Model\ScrapEvent::forge($scrapEventData);
                    $scrapEvent->save();

                    $log = \Admin\Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Model\SystemActivity::TYPE_CREATE,
                        'module' => 'admin/scrapevent',
                        'new_registry' => json_encode($scrapEvent->to_array())
                    ));

                    $log->save();
                    $db->commit_transaction();

                    \Session::set_flash('success', __('_message.create_success'));
                    \Response::redirect("admin/scrapevent");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', $val->error());
                    \Session::set_flash('error',  __('_message.error'));
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = 'Refugos | Novo';
        $this->template->content = \View::forge('scrapevent/create');
    }

    public function action_edit($id = null)
    {
        if (!\Auth::has_access('administration.scrapevent[update]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/scrapevent');
        }

        is_null($id) && \Session::set_flash('warning', 'Evento de refugo não encontrado!') && \Response::redirect('admin/scrapevent');

        $scrapEvent = \Admin\Model\ScrapEvent::find($id);

        if (!$scrapEvent) {
            \Session::set_flash('warning', 'Evento de parada não encontrado!');
            \Response::redirect('admin/scrapevent');
        }

        if (\Input::method() === 'POST') {
            $scrapEventData = \Input::post('scrapEvent');

            $scrapEventCheck = \Admin\Model\ScrapEvent::query()
                ->where('description', $scrapEventData['description'])
                ->where('id', '!=', $id)
                ->get_one();

            if (!empty($scrapEventCheck)) {
                \Session::set_flash('error',  __('_message.existing_data'));
                \Response::redirect("admin/scrapevent");
            }

            $val = \Admin\Model\ScrapEvent::validate('edit');

            if ($val->run()) {

                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $oldScrapEvent = $scrapEvent->to_array();
                    $scrapEvent->set($scrapEventData);
                    $scrapEvent->save();

                    $log = \Admin\Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Model\SystemActivity::TYPE_UPDATE,
                        'module' => 'admin/scrapevent',
                        'old_registry' => json_encode($oldScrapEvent),
                        'new_registry' => json_encode($scrapEvent->to_array())
                    ));

                    $log->save();

                    $db->commit_transaction();

                    \Session::set_flash('success',  __('_message.update_success'));
                    \Response::redirect("admin/scrapevent");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', $val->error());
                    \Session::set_flash('error',  __('_message.error'));
                }
            } else {
                \Session::set_flash('error', $val->error());
            }
        }

        $this->template->set_global('scrapEvent', $scrapEvent);
        $this->template->title = 'Refugos | Editar';
        $this->template->content = \View::forge('scrapevent/edit');
    }

    public function action_activate_unactivate($id = null, $state = null)
    {
        if (!\Auth::has_access('administration.scrapevent[active]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/scrapevent');
        }

        (is_null($id) || is_null($state)) && \Session::set_flash('warning', 'Evento de refugo não encontrado!') && \Response::redirect('admin/scrapevent');

        // Start Transaction
        $db = \Database_Connection::instance();
        $db->start_transaction();

        try {
            $scrapevent = \Admin\Model\ScrapEvent::find($id);

            if (!$scrapevent) {
                throw new \Exception('Evento de refugo não encontrado');
            }

            $oldRegistry = $scrapevent->to_array();

            $scrapevent->active = $state;
            $scrapevent->save();

            $newRegistry = $scrapevent->to_array();

            $log = \Model\SystemActivity::forge(array(
                'user_id' => $this->getCurrentUser()->id,
                'date' => date('Y-m-d H:i:s'),
                'event' => isset($state) ? \Model\SystemActivity::TYPE_ACTIVATE : \Model\SystemActivity::TYPE_DISABLED,
                'module' => 'admin/scrapevent',
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
            \Session::set_flash('error', "Não foi possível realizar a ação!");
        }

        \Response::redirect('admin/scrapevent');
    }
}
