<?php

return array(
    '_shift' => array(
        'title' => 'Turnos',
        'title_create' => 'Turnos | Novo',
        'title_update' => 'Turnos | Editar',
        'no_data' => 'Nenhum dado cadastrado.',
        'table' => array(
            'description' => 'Descrição',
            'actions' => 'Ações'
        ),
        'form' => array(
            'description' => 'Turno',
            'status' => 'Status',
            'select' => 'Selecione...',
            'active' => 'Ativo',
            'disabled' => 'Desativado'
        ),
    ),
    '_stop' => array(
        'title' => 'Paradas',
        'title_create' => 'Paradas | Novo',
        'title_update' => 'Paradas | Editar',
        'no_data' => 'Nenhum dado cadastrado.',
        'table' => array(
            'description' => 'Descrição',
            'actions' => 'Ações'
        ),
        'form' => array(
            'description' => 'Descrição',
            'status' => 'Status',
            'select' => 'Selecione...',
            'active' => 'Ativo',
            'disabled' => 'Desativado'
        )
    ),
    '_machine' => array(
        'title' => 'Máquinas',
        'title_create' => 'Máquinas | Novo',
        'title_update' => 'Máquinas | Editar',
        'no_data' => 'Nenhum dado cadastrado.',
        'table' => array(
            'machine' => 'Máquinas',
            'actions' => 'Ações'
        ),
        'form' => array(
            'machine' => 'Máquina',
            'status' => 'Status',
            'select' => 'Selecione...',
            'active' => 'Ativo',
            'inactive' => 'Inativo'
        )
    ),
    '_scrapEvent' => array(
        'title' => 'Refugos',
        'title_create' => 'Refugos | Novo',
        'title_update' => 'Refugos | Editar',
        'no_data' => 'Nenhum dado cadastrado.',
        'table' => array(
            'scrap' => 'Motivo Refugo',
            'actions' => 'Ações'
        ),
        'form' => array(
            'scrap' => 'Motivos Refugo',
            'status' => 'Status',
            'select' => 'Selecione...',
            'active' => 'Ativo',
            'inactive' => 'Inativo'
        )
    ),
    '_color' => array(
        'title' => 'Cores',
        'title_create' => 'Cores | Novo',
        'title_update' => 'Cores | Editar',
        'no_data' => 'Nenhum dado cadastrado.',
        'form' => array(
            'description' => 'Cores',
            'status' => 'Status',
            'select' => 'Selecione...',
        ),
        'table' => array(
            'description' => 'Descrição',
            'actions' => 'Ações'
        ),
    ),
    'users_log' => array(
        'title' => 'Log',
        'no_data' => 'Procure por um período para visualizar os registros.',
        'filter' => array(
            'start_date' => 'Data inicio',
            'end_date' => 'Data fim',
        ),
        'table' => array(
            'date_and_time' => 'Data e hora',
            'user' => 'Usuário',
            'module' => 'Módulo',
            'event' => 'Evento',
            'actions' => 'Ações',
        ),
        'modal' => array(
            'no_values' => 'Sem valores',
            'old_registry' => 'Registro anterior:',
            'new_registry' => 'Novo registro:',
            'active' => 'Ativo',
            'disabled' => 'Desativado',
            'button_close' => 'Fechar',
        ),
        'button' => array(
            'search' => 'Buscar',
            'detail' => 'Detalhar',
        ),
    ),
    '_message' => array(
        'existing_data' => 'Esse dado já existe!',
        'error' => 'Erro! Tente novamente',
        'create_success' => 'Criado com sucesso',
        'update_success' => 'Atualizado com sucesso',
        'delete_success' => 'Deletado com sucesso',
    ),
    '_user' => array(
        'title' => 'Usuários',
        'title_create' => 'Usuários | Novo',
        'title_edit' => 'Usuários | Editar',
        'no_data' => 'Não há dados cadastrados',
        'no_group' => 'Não há grupo registrado para esse usuário',
        'table' => array(
            'username' => 'Usuário',
            'user_profile' => 'Perfil de usuário',
            'actions' => 'Ações'
        ),
        'form' => array(
            'username' => 'Usuário',
            'useremail' => 'Email',
            'fullname' => 'Nome completo',
            'group' => 'Grupo',
            'select' => 'Selecione'
        ),
        'message' => array(
            'access_denied' => 'Acesso negado!',
            'create_success' => 'Usuário criado com sucesso!',
            'create_fail' => 'Não foi possível criar o usuário, tente novamente',
            'edit_success' => 'Usuário editado com sucesso!',
            'edit_fail' => 'Não foi possível editar o usuário, tente novamente',
            'user_notfound' => 'Usuário não encontrado',
            'user_disabled' => 'Não foi possivel editar pois o usuário encontra-se desativado!',
            'user_deactivation' => 'Desativado com sucesso',
            'user_deactivation_fail' => 'Não foi possível desativar o usuário',
            'user_activation' => 'Ativado com sucesso!',
            'user_activation_fail' => 'Não foi possível ativar o usuário!',
        ),
    ),
);
