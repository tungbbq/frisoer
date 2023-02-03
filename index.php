<?php
include 'config.php';
include 'view/customer.php';


spl_autoload_register(function ($class)
{
    include 'class/' . $class . '.php';
});

$montag = '2023-01-31';
$week = Termin::getWeek($montag);

echo "<pre>";
print_r($week);
echo "</pre>";

