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
$role = $_SESSION['role'] ?? '';
$name = $_POST['name'] ?? '';
$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$password = $_POST['password'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$workStart = $_POST['workStart'] ?? '';
$workEnd = $_POST['workEnd'] ?? '';
$roleToSave = $_POST['roleToSave'] ?? '';


if ($action === 'load') {
    $transferredBarbers = User::getNamesOfBarbers();
    $transferredWeek = Appointment::getAppointmentsByBarberAndUserId($monday, $barber_id);
    $transferredCustomers = User::getNamesOfCustomers();
    if ($role === 'barber') {
        echo json_encode([$transferredBarbers, $transferredWeek, $transferredCustomers]);
    } elseif ($role === 'customer') {
        echo json_encode([$transferredBarbers, $transferredWeek]);
    }
} if ($action === 'saveAppointment') {
    $response = Appointment::saveAppointment($slotStart, $slotEnd, $barber_id, $user_id);
    echo $response;
} elseif ($action === 'deleteAppointment') {
    $response = Appointment::deleteAppointments($appointmentId);
    echo $response;
} elseif ($action === 'updateUser') {
    $response = User::updateUser($user_id, $roleToSave, $name, $firstName, $lastName, $telephone, $workStart, $workEnd);

} elseif ($action === 'loadUser') {
    $response = User::getAllUsersWithoutPassword();
    echo json_encode($response);
} elseif ($action === 'saveUser') {
    $response = User::saveUser($roleToSave, $name, $firstName, $lastName, $telephone, $password, $workStart, $workEnd);
    echo $response;
} elseif ($action === 'deleteUser') {
    $response = User::deleteUser($user_id);
    echo $response;
}
