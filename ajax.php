<?php
session_start();
include './config.php';


spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$monday = $_REQUEST['monday'] ?? '';
//$barber_id = $_POST['barber_id'] ?? '';
$appointmentId = $_POST['appointmentId'] ?? '';
$user_id = $_POST['user_id'] ?? '' ;
$barber_id = $_POST['barber_id'] ?? null ; // darf kein Leerstring sein, da Wert optional ist
$slotStart = $_POST['slotStart'] ?? '' ;
$slotEnd = $_POST['slotEnd'] ?? '' ;


// brauche zusätzlich getAllBarbers
//if ($barber_id == 'all') {
//    $barber_id = User::getNamesOfBarbers()[0]['id'];
//}

if ($appointmentId !== ''){
    $deleteOutput = Appointment::deleteAppointments($appointmentId);
    if ($deleteOutput === true){
        echo 'Dein Termin wurde entfernt';
        $appointmentId = '';
    } else echo 'Fehler!';
    $appointmentId = '';
   exit();
}
if ($slotStart !== '' && $slotEnd !== ''){
    $newUpdateOutput = Appointment::newAppointment($slotStart, $slotEnd, $barber_id, $user_id);
    if ($newUpdateOutput === true){
        echo 'Dein Termin wurde angelegt!';
    } else echo 'Fehler2';
    exit();
}

$transferredWeek = Appointment::getAppointmentsByBarberAndUserId($monday, $barber_id);
$transferredBarbers = User::getNamesOfBarbers();
echo json_encode([$transferredBarbers, $transferredWeek]);

