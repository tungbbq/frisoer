<?php
session_start();
include './config.php';


spl_autoload_register(function ($class)
{
    include 'classes/' . $class . '.php';
});

$monday = $_POST['monday'];
$barber_id = $_POST['barber_id'] ?? '';

$transferredWeek = Appointment::getAppointmentsByBarberAndUserId($monday, (int)$barber_id);

echo json_encode($transferredWeek);


