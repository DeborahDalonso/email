<?php

namespace Admin\Model;

class Metadata extends \Orm\Model_Soft
{
    protected static $_table_name = 'metadata';
    protected static $_properties = array(
        'id',
        'parent_id',
        'key',
        'value',
        'user_id',
        'created_at',
        'updated_at',
        'deleted'
    );
    
    protected static $_soft_delete = array(
        'deleted_field' => 'deleted',
        'mysql_timestamp' => false,
    );
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_Typing' => array(
            'events' => array('after_load', 'before_save', 'after_save'),
        ),
        'Orm\Observer_Self' => array(
            'events' => array('before_insert', 'before_update'),
            'property' => 'user_id',
        ),
    );

    /**
     * @var array	belongs_to relationships
     */
    protected static $_belongs_to = array(
        'user' => array(
            'model_to' => 'Admin\Model\User',
            'key_from' => 'parent_id',
            'key_to'   => 'id',
        ),
    );

    
}
