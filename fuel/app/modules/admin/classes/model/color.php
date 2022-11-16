<?php

namespace Admin\Model;

class Color extends \Orm\Model
{
    protected static $_table_name = 'recycling_color';
    protected static $_properties = array(
        'id',
        'description',
        'active'
        );

    public static function validate($factory)
    {
        $val = \Validation::forge($factory);
        // $val->add_field('description', 'description', 'required|max_length[50]|required|unique[stop.description]');
        return $val;
    }
}
