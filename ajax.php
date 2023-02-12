<?php
include './config.php';


spl_autoload_register(function ($class)
{
    include 'classes/' . $class . '.php';
});

$monday = $_POST['monday'] ?? '';
$isBarber = $_POST['isBarber'] ?? '';
$transferredWeek = Appointment::getAppointmentsByBarber('2023-02-06', 1);
//echo '<pre>'; print_r($transferredWeek); echo '</pre>';
echo json_encode($transferredWeek);

