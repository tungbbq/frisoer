<?php

// incl class
spl_autoload_register(function ($class)
{
    include '../class/' . $class . '.php';
});

// incl config
include '../config.php';

// incl view
include '../view/barber.php';

