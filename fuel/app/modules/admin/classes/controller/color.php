<?php

namespace Admin\Controller;

class Color extends \Controller\Admin
{
    public function before()
    {
        if (!\Auth::has_access('administration.color[access]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('/');
        }

        parent::before();

        \lang::load('translations');
    }

    public function action_index()
    {
        $data['colors'] = \Admin\Model\Color::query()->get();

        $this->template->title = 'Cores';
        $this->template->content = \View::forge('color/index', $data);

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
        if (!\Auth::has_access('administration.color[create]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('admin/color');
        }

        if (\Input::method() === 'POST') {
            $colorData = \Input::post('color');

            $colorCheck = \Admin\Model\Color::query()
                ->where('description', $colorData['description'])
                ->get_one();

            if (!empty($colorCheck)) {
                \Session::set_flash('error', __('_message.error'));
                \Response::redirect("admin/color");
            }

            $val = \Admin\Model\Color::validate('create');

            if ($val->run()) {

                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {
                    $colorData['active'] = 1;
                    $color = \Admin\Model\Color::forge($colorData);
                    $color->save();

                    $log = \Admin\Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Admin\Model\SystemActivity::TYPE_CREATE,
                        'module' => 'admin/color',
                        'new_registry' => json_encode($color->to_array())
                    ));

                    $log->save();
                    $db->commit_transaction();

                    \Session::set_flash('success', __('_message.create_success'));
                    \Response::redirect("admin/color");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', __('_message.error'));
                }
            } else {
                \Session::set_flash('error', __('_message.error'));
            }
        }

        $this->template->title = 'Cores | Novo';
        $this->template->content = \View::forge('color/create');
    }

    public function action_edit($id = null)
    {
        if (!\Auth::has_access('administration.color[update]')) {
            \Session::set_flash('error', 'Acesso negado!');
            \Response::redirect('/');
        }

        is_null($id) && \Session::set_flash('warning', 'Cor não encontrado!') && \Response::redirect('admin/color');
        $color = \Admin\Model\Color::find($id);

        if (!$color) {
            \Session::set_flash('warning', 'Cor não encontrado!');
            \Response::redirect('admin/color');
        }

        if (\Input::method() === 'POST') {
            $colorData = \Input::post('color');

            $val = \Admin\Model\Color::validate('edit');

            if ($val->run()) {

                $db = \Database_Connection::instance();
                $db->start_transaction();

                try {

                    $oldColor = $color->to_array();
                    $color->set($colorData);
                    $color->save();

                    $log = \Admin\Model\SystemActivity::forge(array(
                        'user_id' => $this->getCurrentUser()->id,
                        'date' => date('Y-m-d H:i:s'),
                        'event' => \Admin\Model\SystemActivity::TYPE_UPDATE,
                        'module' => 'admin/color',
                        'old_registry' => json_encode($oldColor),
                        'new_registry' => json_encode($color->to_array())

                    ));

                    $log->save();

                    $db->commit_transaction();

                    \Session::set_flash('success', __('_message.update_success'));
                    \Response::redirect("admin/color");
                } catch (Exception $e) {
                    $db->rollback_transaction();
                    \Session::set_flash('error', __('_message.error'));
                }
            } else {
                \Session::set_flash('error', __('_message.error'));
            }
        }

        $this->template->set_global('color', $color);

        $this->template->title = __('_color.title_update');
        $this->template->content = \View::forge('color/edit', $color);
    }

    public function action_activate_unactivate($id = null, $state = null)
    {
        if (!\Auth::has_access('administration.color[active]')) {
            \Session::set_flash('error', "Acesso negado!");
            \Response::redirect('admin/user');
        }

        (is_null($id) || is_null($state)) && \Session::set_flash('warning', 'Cor não encontrado!') && \Response::redirect('admin/color');

        // Start Transaction
        $db = \Database_Connection::instance();
        $db->start_transaction();

        try {
            $color = \Admin\Model\Color::find($id);

            if (!$color) {
                throw new \Exception('Dados não encontrados');
            }

            $oldRegistry = $color->to_array();

            $color->active = $state;
            $color->save();

            $newRegistry = $color->to_array();

            $log = \Model\SystemActivity::forge(array(
                'user_id' => $this->getCurrentUser()->id,
                'date' => date('Y-m-d H:i:s'),
                'event' => isset($state) ? \Model\SystemActivity::TYPE_ACTIVATE : \Model\SystemActivity::TYPE_DISABLED,
                'module' => 'admin/color',
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

        \Response::redirect('admin/color');
    }

}
