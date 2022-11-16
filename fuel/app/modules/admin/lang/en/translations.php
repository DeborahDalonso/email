<?php

return array(
    '_shift' => array(
        'title' => 'Shifts',
        'title_create' => 'Shifts | New',
        'title_update' => 'Shifts | Edit',
        'no_data' => ' no data recorded. ',
        'table' => array(
            'description' => 'Description',
            'actions' => 'Actions'
        ),
        'form' => array(
            'description' => 'Shift',
            'status' => 'Status',
            'select' => 'Select...',
            'active' => 'Active',
            'disabled' => 'Disabled'
        ),
    ),
    '_stop' => array(
        'title' => 'Event of stop',
        'title_create' => 'Event of stop | New',
        'title_update' => 'Event of stop | Editar',
        'no_data' => 'no data recorded.',
        'table' => array(
            'description' => 'Description',
            'actions' => 'Actions'
        ),
        'form' => array(
            'description' => 'Description',
            'status' => 'Status',
            'select' => 'Select...',
            'active' => 'Active',
            'disabled' => 'Disabled'
        ),
    ),
    '_machine' => array(
        'title' => 'Máquinas',
        'title_create' => 'Máquinas | Nuevo',
        'title_update' => 'Máquinas | Para Editar',
        'no_data' => 'No se encontró registro.',
        'table' => array(
            'machine' => 'Máquinas',
            'actions' => 'Acción'
        ),
        'form' => array(
            'machine' => 'Máquina',
            'status' => 'Estado',
            'select' => 'Seleccione...',
            'active' => 'Activo',
            'inactive' => 'Inactivo'
        )
    ),
    '_scrapEvent' => array(
        'title' => 'Chatarra',
        'title_create' => 'Chatarra | Nuevo',
        'title_update' => 'Chatarra | Para Editar',
        'no_data' => 'No se encontró registro.',
        'table' => array(
            'scrap' => 'Tipo Chatarra',
            'actions' => 'Acción'
        ),
        'form' => array(
            'scrap' => 'Tipo Chatarra',
            'status' => 'Estado',
            'select' => 'Seleccione...',
            'active' => 'Activo',
            'inactive' => 'Inactivo'
        ),
        'users_log' => array(
            'title' => 'Log',
            'no_data' => 'Search for a period to view the records',
            'filter' => array(
                'start_date' => 'Start date',
                'end_date' => 'End date',
            ),
            'table' => array(
                'date_and_time' => 'Date and time',
                'user' => 'User',
                'module' => 'Module',
                'event' => 'Event',
                'actions' => 'Actions',
            ),
            'button' => array(
                'search' => 'Search',
                'detail' => 'Detail',
            ),
        ),
    ),
    '_message' => array(
        'existing_data' => 'Estos datos ya existen!',
        'error' => '¡Error! Inténtalo de nuevo',
        'create_success' => 'Creado con éxito',
        'update_success' => 'Actualizado con éxito',
        'delete_success' => 'Eliminado con éxito'
    ),
    '_user' => array(
        'title' => 'Users',
        'title_create' => 'Usuários | Novo',
        'title_edit' => 'Usuários | Editar',
        'no_data' => 'No data registered',
        'no_group' => 'There is no group registered for this user',
        'table' => array(
            'username' => 'User',
            'user_profile' => 'User Profile',
            'actions' => 'Actions'
        ),
        'form' => array(
            'username' => 'User',
            'useremail' => 'Email',
            'fullname' => 'Fullname',
            'group' => 'Group',
            'select' => 'Select'
        ),
        'message' => array(
            'access_denied' => 'Access denied!',
            'create_success' => 'User created successfully!',
            'create_fail' => 'Could not create user, please try again',
            'edit_success' => 'User successfully edited!',
            'edit_fail' => 'Could not edit user, please try again',
            'user_notfound' => 'User not found',
            'user_disabled' => 'Unable to edit because the user is deactivated!',
            'user_deactivation' => 'Successfully deactivated',
            'user_deactivation_fail' => 'Unable to deactivate user',
            'user_activation' => 'Successfully activated!',
            'user_activation_fail' => 'Unable to activate user!',
        ),
    ),
);
