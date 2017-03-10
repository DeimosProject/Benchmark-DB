<?php

$capsule = new Illuminate\Database\Capsule\Manager;

$capsule->addConnection([
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'database' => 'test',
    'username' => 'root',
    'password' => 'root',
]);

return function ($iterator) use ($capsule)
{

    global $sql;

    $obj = $capsule->getConnection()
        ->table('users')
        ->select(['id'])
        ->where('id', $iterator)
        ->orWhere('id', $iterator + 1)
        ->orWhere('id', $iterator + 2)
        ->orWhere('id', $iterator + 3)
        ->orWhere('id', $iterator + 4);

    $sql = $obj->toSql();
    $obj->get();

};