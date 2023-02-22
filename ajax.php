<?php
session_start();
include './config.php';


spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$action = $_REQUEST['action'] ?? '';
$monday = $_REQUEST['monday'] ?? '';
$appointmentId = $_POST['appointmentId'] ?? '';
$user_id = $_POST['user_id'] ?? '' ;
$barber_id = $_POST['barber_id'] ?? null ; // darf kein Leerstring sein, da Wert optional ist
$slotStart = $_POST['slotStart'] ?? '' ;
$slotEnd = $_POST['slotEnd'] ?? '' ;

if ($action === 'load') {
    $transferredWeek = Appointment::getAppointmentsByBarberAndUserId($monday, $barber_id);
    $transferredBarbers = User::getNamesOfBarbers();
    echo json_encode([$transferredBarbers, $transferredWeek]);
} if ($action === 'save') {
    $response = Appointment::newAppointment($slotStart, $slotEnd, $barber_id, $user_id);
    echo $response;
} elseif ($action === 'delete') {
    $response = Appointment::deleteAppointments($appointmentId);
    echo $response;

}

