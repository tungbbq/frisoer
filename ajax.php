<?php
include './config.php';

spl_autoload_register(function ($class)
{
    include 'classes/' . $class . '.php';
});

$monday = $_POST['monday'];
$isBarber = $_POST['isBarber'] ?? '';
$week = Termin::getWeek($monday);
$transferredWeek = TransferTermin::getTransferTermine($week);
echo json_encode($transferredWeek);

