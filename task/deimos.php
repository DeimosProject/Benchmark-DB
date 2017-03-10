<?php

$builder = new \Deimos\Builder\Builder();

$database = new \Deimos\Database\Database(new \Deimos\Config\ConfigObject($builder, [
    'adapter'  => 'mysql',
    'database' => 'test',
    'username' => 'root',
    'password' => 'root',
    'options'  => [
//        \PDO::ATTR_EMULATE_PREPARES => false,
    ]
]));

$orm = new \Deimos\ORM\ORM($builder, $database);

return function ($iterator) use ($orm)
{
    global $sql;

    $obj = $orm->database()->query()
        ->select('id')
        ->from('users')
        ->whereOr([
            ['id', $iterator],
            ['id', $iterator + 1],
            ['id', $iterator + 2],
            ['id', $iterator + 3],
            ['id', $iterator + 4]
        ]);

    $sql = (string)$obj;
    $obj->find();

//        ->findOne();

//    $orm->database()
//        ->rawQuery('select * from users where id = ?', [ $iterator ])
//        ->fetch();

//    $orm->repository('user')
//        ->where('id', $iterator)
//        ->findOne();
};