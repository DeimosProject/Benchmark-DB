<?php

class ORM2 extends ORM
{
    public $_values;

    public function _build_select()
    {
        return parent::_build_select();
    }
}

ORM2::configure('caching', false);
ORM2::configure('mysql:host=localhost;dbname=test');
ORM2::configure('username', 'root');
ORM2::configure('password', 'root');

return function ($iterator)
{

    global $sql;

    $obj = ORM2::for_table('users')
        ->select('id')
        ->where_any_is(
            array(
                array('id' => $iterator),
                array('id' => $iterator + 1),
                array('id' => $iterator + 2),
                array('id' => $iterator + 3),
                array('id' => $iterator + 4),
            )
        );

    $sql = (clone $obj)->_build_select();

    $obj->find_many();

};