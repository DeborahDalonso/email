<?php

namespace Admin\Model;

class Group extends \Orm\Model_Soft
{

    const GROUPS = ['3' => 'Usuário', '5' => 'Administrador'];

    protected static $_table_name = 'users_groups';

    /**
     * disallowed edit or delete groups_id
     *
     * @var array array of disallowed ids
     */
    protected $disallowed_edit_delete = array(1, 2, 3, 4, 5, 6);
    protected static $_properties = array(
        'id',
        'name',
        'user_id',
        'created_at',
        'updated_at',
        'deleted',
    );
    protected static $_conditions = array(
        'order_by' => array('name' => 'asc')
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
    );

    public static function validate($factory)
    {
        $val = \Validation::forge($factory);
        $val->add_field('name', 'Nome', 'required|max_length[60]|unique[users_groups.name]');

        return $val;
    }

    public function getDisallowedEditDelete()
    {
        return $this->disallowed_edit_delete;
    }
}
