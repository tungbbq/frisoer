<?php
include '../frisoer/config.php';

spl_autoload_register(function ($class)
{
    include 'class/' . $class . '.php';
});

$monday = $_POST['monday'];
$week = Termin::getWeek($monday);
$transferredWeek = TransferTermin::getTransferTermine($week);
echo json_encode($transferredWeek);

