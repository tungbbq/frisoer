<?php
include 'config.php';
include 'barber.php';

spl_autoload_register(function ($class)
{
    include '../class/' . $class . '.php';
});







