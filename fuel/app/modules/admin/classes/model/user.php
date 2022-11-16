<?php

namespace Admin\Model;

class User extends \Orm\Model_Soft {

    const GROUP_ADMIN = 5; 
    const GROUP_USER = 3;
    const GROUP_ROOT = 6;
   

    protected static $_properties = array(
        'id',
        'username',
        'password',
        'first_login',
        'group_id',
        'email',
        'last_login',
        'previous_login',
        'login_hash',
        'user_id',
        'active',
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
    );

    // define the EAV container like so
    protected static $_eav = array(
        'metadata' => array(			// we use the statistics relation to store the EAV data
            'attribute' => 'key',		// the key column in the related table contains the attribute
            'value' => 'value',			// the value column in the related table contains the value
        )
    );

    /**
     * @var array	belongs_to relationships
     */
    
    protected static $_belongs_to = array(
        'group' => array(
            'model_to' => 'Model\\Auth_Group',
            'key_from' => 'group_id',
            'key_to' => 'id',
            'cascade_delete' => false,
        ),
    );

    protected static $_has_many = array(
        'metadata' => array(
            'model_to' => 'Admin\Model\Metadata',
            'key_from' => 'id',
            'key_to' => 'parent_id',
            'cascade_delete' => true,
        ),
    );

    public static function validate($factory)
    {
        $val = \Validation::forge($factory);

        $val->add_field('user.username', 'Usuário', 'required|trim|valid_string[alpha,lowercase,numeric,punctuation]|min_length[2]|max_length[50]');
        $val->set_message('valid_string', 'O campo :label só pode conter letras, números, sublinhados, caracteres não acetuados, letras minusculas e deve ter entre 5 e 50 caracteres.');
        
        $val->add_field('user.email', 'Email', 'valid_email|max_length[255]');
        $val->set_message('valid_string', 'O campo :label deve conter um email valido .');

        $val->add_field('user.group_id', 'Group Id', 'required|valid_string[numeric]');
        $val->set_message('valid_string', 'O campo :label deve possuir um valor valido .');

        return $val;
    }

}
