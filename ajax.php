<?php
include 'config.php';

spl_autoload_register(function ($class)
{
    include 'class/' . $class . '.php';
});

$monday = $_POST['monday'];
$frisoer = $_POST['frisoer'];

$week = Termin::getWeek($monday, $frisoer);
$transferredWeek = TransferTermin::getTransferTermine($week);
echo json_encode($transferredWeek);

