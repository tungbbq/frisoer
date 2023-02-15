<?php
include './config.php';


spl_autoload_register(function ($class)
{
    include 'classes/' . $class . '.php';
});
$monday = $_POST['monday'];
$barber_id = $_POST['barber_id'] ?? '';


//print_r($_POST);
$transferredWeek = Appointment::getAppointmentsByBarber($monday, (int)$barber_id);

echo json_encode($transferredWeek);

