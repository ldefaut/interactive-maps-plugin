<?php

namespace LDefaut\WpPlugin\InteractiveMaps;

use JetBrains\PhpStorm\NoReturn;

function dump(mixed $value, mixed ...$values): void
{
    echo "<pre>";
    var_dump($value, ...$values);
    echo "</pre>";
}

function dd(mixed $value, mixed ...$values): void
{
    dump($value, ...$values);
    die;
}
