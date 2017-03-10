<?php

include_once __DIR__ . '/vendor/autoload.php';

$iterations = 5000;
$rows       = [];

$tasks = scandir('task');

uasort($tasks, function ()
{
    return random_int(-1, 1);
});

foreach ($tasks as $item)
{
    if ($item{0} === '_')
    {
        continue;
    }

    if (is_file(__DIR__ . '/task/' . $item))
    {
        $sql    = null;
        $rows[] = [
            explode('.', $item)[0],
            (function ($item) use ($iterations)
            {
                return \Deimos\MicroBenchmark\Benchmark::task(
                    $iterations,
                    include __DIR__ . '/task/' . $item
                );
            })($item),
            $sql
        ];

    }
}

uasort($rows, function ($a, $b)
{
    return $a[1]->time()['execution'] <=> $b[1]->time()['execution'];
});

foreach ($rows as $row)
{
    var_dump($row);
}