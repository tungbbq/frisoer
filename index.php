<?php
include 'config.php';
include 'view/customer.php';

spl_autoload_register(function ($class)
{
    include 'class/' . $class . '.php';
});

//new User("Peter");
//new Termin('2023-01-31 15:00:00', 1);
$montag = '2023-01-31';
$week = Termin::getWeek($montag);

echo "<pre>";
print_r($week);
echo "</pre>";

