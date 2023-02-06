<?php
include 'config.php';

spl_autoload_register(function ($class)
{
    include 'class/' . $class . '.php';
});

$view = 'customer';
include 'view/' . $view . '.php';

