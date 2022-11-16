<?php

namespace Admin\Controller;

class UsersLog extends \Controller\Admin
{
    public function before()
    {
        parent::before();
        if (!\Auth::has_access('administration.log[access]')) {
            \Session::set_flash('error',__('_user.message.access_denied'));
            \Response::redirect('/');
        }
        \lang::load('translations');
    }

    public function action_index()
    {
        $tplData = [];
        $usersName = [];

        if (\Input::method() === 'POST') {
            $startDate = \Input::post('start_date');
            $endDate = \Input::post('end_date');
            
            $getLogs = \Admin\Model\SystemActivity::query()
                ->related('user')
                ->related('user.metadata')
                ->where('date', '>=', date('Y-m-d 00:00:00', strtotime($startDate)))
                ->where('date', '<= ', date('Y-m-d 23:59:59', strtotime($endDate)))
                ->order_by('date', 'asc')
                ->get();

            foreach ($getLogs as $logs) {
                $date = date('d/m/Y H:i', strtotime($logs->date));

                $data = [
                    'username' => $logs->user->username,
                    'date' =>  $date,
                    'event' => $logs->event,
                    'module' => $logs->module,
                    'new_registry' =>$logs->new_registry,
                    'old_registry' =>$logs->old_registry,
                ];

                array_push($usersName, $data);
            }
        }

        $tplData['usersName'] = $usersName;

        $this->template->title = 'Registro de Atividades';
        $this->template->content = \View::forge('userslog/index', $tplData);

        $this->template->set('extra_js', \Asset::js(
            array(
                'vendor/datatables.min.js',
                'module/admin/userslog/main.js'
            )
        ), false);

        $this->template->set('extra_css', \Asset::css(array(
            'vendor/datatables.min.css',
            'module/admin/userslog/main.css'
        )), false);
    }

    public function post_create_html_modal()
    {
        $newRegistry = \Input::post('new_registry');
        $oldResgitry = \Input::post('old_registry');

        $message = \View::forge()
                ->set(array(
                    'newRegistry' => $newRegistry,
                    'oldRegistry' => $oldResgitry
                        ), null, true)
                ->render('modallog/modal');

        return \Response::forge($message);
    }
}
