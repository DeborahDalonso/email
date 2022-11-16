<?php

namespace Admin\Model;

class MailList extends \Orm\Model
{
    protected static $_table_name = 'mail_list';
    protected static $_properties = array(
        'id',
        'email',
        'active'
    );

    public static function validate($factory)
    {
        $val = \Validation::forge($factory);
        return $val;
    }
}
