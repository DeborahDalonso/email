<?php

namespace Admin\Model;

class Machine extends \Orm\Model
{
    protected static $_table_name = 'machine';
    protected static $_properties = array(
        'id',
        'description',
        'active'
    );

    public static function validate($machine)
    {
        $val = \Validation::forge($machine);

        return $val;
    }
}
