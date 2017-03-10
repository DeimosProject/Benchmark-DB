<?php

$slice    = new \PHPixie\Slice();
$database = new \PHPixie\Database($slice->arrayData([
    'default' => [
        'driver'     => 'pdo',
        'connection' => 'mysql:host=localhost;dbname=test',
        'user'       => 'root',
        'password'   => 'root',
    ]
]));

return function ($iteration) use ($database)
{

    global $sql;

    /**
     * @var $data \PHPixie\Database\Driver\PDO\Query\Type\Select
     */
    $data = $database->get()
        ->selectQuery()
        ->fields('id')
        ->table('users')
        ->_or('id', $iteration)
        ->_or('id', $iteration + 1)
        ->_or('id', $iteration + 2)
        ->_or('id', $iteration + 3)
        ->_or('id', $iteration + 4);

    /**
     * @var $result \PHPixie\Database\Driver\PDO\Result
     */
    $result = $data->execute();
    $result->asArray();

    $sql = $result->statement()->queryString;

};