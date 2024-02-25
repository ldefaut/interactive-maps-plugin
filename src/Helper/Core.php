<?php

namespace LDefaut\WpPlugin\InteractiveMaps;

use JetBrains\PhpStorm\NoReturn;

function dump($value, ...$values): void
{
    echo "<pre>";
    var_dump($value, ...$values);
    echo "</pre>";
}

function dd($value, ...$values): void
{
    dump($value, ...$values);
    die;
}
