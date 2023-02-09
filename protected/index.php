<?php
include '../config.php';

spl_autoload_register(function ($class) {
    include 'services/' . $class . '.php';
});

$view = 'customer';
include '../views/' . $view . '.php';


