<?php

namespace Admin\Model;

class ScrapEvent extends \Orm\Model
{
    protected static $_table_name = 'scrap_event';
    protected static $_properties = array(
        'id',
        'description',
        'active'
    );

    public static function validate($scrapEvent)
    {
        $val = \Validation::forge($scrapEvent);
       // $val->add_field('description', 'description', 'required|max_length[50]|required|unique[machine.description]');
        return $val;
    }
}
