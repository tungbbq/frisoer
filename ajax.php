<?php
include 'config.php';
spl_autoload_register(function ($class)
{
    include 'class/' . $class . '.php';
});

//$monday = $_POST['monday'];
$monday = '2023-01-31';
$week = Termin::getWeek($monday);
$transferredWeek = TransferTermin::getTransferTermine($week);

echo '<pre>';
print_r($transferredWeek);
echo '</pre>';
