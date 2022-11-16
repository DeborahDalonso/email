<?php

namespace Admin\Model;

class SystemActivity extends \Orm\Model
{
    const TYPE_ACTIVATE = 'activate';
    const TYPE_DISABLED = 'disabled';
    const TYPE_BULKP_UPDATE = 'bulk_update';
    const TYPE_CREATE = 'create';
    const TYPE_UPDATE = 'update';
    const TYPE_DELETE = 'delete';
    const TYPE_CLONE = 'clone';

    protected static $_table_name = 'system_activity';
    protected static $_properties = array(
        'id',
        'user_id',
        'date',
        'event',
        'module',
        'old_registry',
        'new_registry',
        'created_at',
        'updated_at',
    );

    protected static $_belongs_to = [
        'user' => [
            'model_to' => '\Admin\Model\User',
            'key_from' => 'user_id',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ]
    ];

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => false,
        ),
    );

}
