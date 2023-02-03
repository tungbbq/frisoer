<?php
include 'config.php';
include 'view/customer.php';


spl_autoload_register(function ($class)
{
    include 'class/' . $class . '.php';
});

$monday = '2023-01-31';
$week = Termin::getWeek($monday);

echo "<pre>";
print_r($week);
echo "</pre>";

