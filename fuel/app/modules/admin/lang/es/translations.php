<?php

return array(
    '_shift' => array(
        'title' => 'Turnos',
        'title_create' => 'Turnos | Nuevo',
        'title_update' => 'Turnos | Editar',
        'no_data' => 'no hay datos registrados.',
        'table' => array(
            'description' => 'Descripción',
            'actions' => 'Acción'
        ),
        'form' => array(
            'description' => 'Descripción',
            'status' => 'Estado',
            'select' => 'Seleccione...',
            'active' => 'Activo',
            'disabled' => 'Desactivado'
        )
    ),
    '_stop' => array(
        'title' => 'Paradas',
        'title_create' => 'Paradas | Nuevo',
        'title_update' => 'Paradas | Editar',
        'no_data' => 'no hay datos registrados.',
        'table' => array(
            'description' => 'Descripción',
            'actions' => 'Acción'
        ),
        'form' => array(
            'description' => 'Descripción',
            'status' => 'Estado',
            'select' => 'Seleccione...',
            'active' => 'Activo',
            'disabled' => 'Desactivado'
        ),

    ),
    'users_log' => array(
        'title' => 'Log',
        'no_data' => 'Buscar un período para ver los registros',
        'filter' => array(
            'start_date' => 'Fecha de inicio',
            'end_date' => 'Fecha final',
        ),
        'table' => array(
            'date_and_time' => 'Fecha y hora',
            'user' => 'Pesquisar ',
            'module' => 'Módulo',
            'event' => 'Evento',
            'actions' => 'Comportamiento',
        ),
        'button' => array(
            'search' => 'Búsqueda',
            'detail' => 'Detalle',
        ),
    ),
    '_machine' => array(
        'title' => 'Machines',
        'title_create' => 'Machines | New',
        'title_update' => 'Machines | Edit',
        'no_data' => 'No record found.',
        'table' => array(
            'machine' => 'Machines',
            'actions' => 'Actions'
        ),
        'form' => array(
            'machine' => 'Machine',
            'status' => 'Status',
            'select' => 'Select...',
            'active' => 'Active',
            'inactive' => 'Inactive'
        )
    ),
    '_scrapEvent' => array(
        'title' => 'Scrap',
        'title_create' => 'Scrap | New',
        'title_update' => 'Scrap | Edit',
        'no_data' => 'No record found.',
        'table' => array(
            'scrap' => 'Scrap Type',
            'actions' => 'Actions'
        ),
        'form' => array(
            'scrap' => 'Scrap Type',
            'status' => 'Status',
            'select' => 'Select...',
            'active' => 'Active',
            'inactive' => 'Inactive'
        )
    ),
    '_message' => array(
        'existing_data' => 'This data already exists!',
        'error' => 'Error! Try again',
        'create_success' => 'successfully created',
        'update_success' => 'successfully updated',
        'delete_success' => 'successfully deleted'
    ),
    '_user' => array(
        'title' => 'usuários',
        'title_create' => 'Usuários | Novo',
        'title_edit' => 'Usuários | Editar',
        'no_data' => 'No hay datos registrados',
        'no_group' => 'No hay ningún grupo registrado para este usuario',
        'table' => array(
            'username' => 'Usuario',
            'user_profile' => 'Perfil del usuario',
            'actions' => 'Comportamiento'
        ),
        'form' => array(
            'username' => 'Usuario',
            'useremail' => 'Email',
            'fullname' => 'Nombre completo',
            'group' => 'Grupo',
            'select' => 'Seleccione'
        ),
        'message' => array(
            'access_denied' => '¡No se puede activar el usuario!',
            'create_success' => '¡Usuario creado con éxito!',
            'create_fail' => 'No se pudo crear el usuario, intente nuevamente',
            'edit_success' => 'Usuario editado con éxito!',
            'edit_fail' => 'No se pudo editar el usuario, intente nuevamente',
            'user_notfound' => 'Usuario no encontrado',
            'user_disabled' => 'No se puede editar porque el usuario está desactivado!',
            'user_deactivation' => 'Desactivado correctamente',
            'user_deactivation_fail' => 'No se puede desactivar el usuario',
            'user_activation' => 'Activado con éxito!',
            'user_activation_fail' => '¡No se puede activar el usuario!',
        ),
    ),
);
