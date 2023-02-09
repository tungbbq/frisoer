<?php
include 'config.php';

spl_autoload_register(function ($class)
{
    include 'classes/' . $class . '.php';
});

$view = 'customer';
echo $view;
include 'views/' . $view . '.php';

