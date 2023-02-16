<?php
session_start();
include './config.php';


spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$monday = $_REQUEST['monday'] ?? '2023-02-06';
$barber_id = $_POST['barber_id'] ?? '';
$appointmentId = $_POST['appointmentId'] ?? '';

// brauche zusätzlich getAllBarbers
if ($barber_id == 'all') {
    $barber_id = User::getNamesOfBarbers()[0]['id'];
}
if ($appointmentId !== ''){
    $deleteAppointmentsReturn = Appointment::deleteAppointments($appointmentId);
    if ($deleteAppointmentsReturn === true){
        echo ('Dein Termin wurde entfernt');
        die();
    } else echo ('unbekannter Fehler');
    die();

}
$transferredWeek = Appointment::getAppointmentsByBarberAndUserId($monday, (int)$barber_id);
//file_put_contents('log.txt', $barber_id);
$transferredBarbers = User::getNamesOfBarbers();
echo json_encode([$transferredBarbers, $transferredWeek]);


