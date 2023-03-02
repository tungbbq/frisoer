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

} elseif ($action === "loadUser") {
    $response = '[[{"id":11,"firstName":"Alpha","lastName":"Andy","workStart":"08:00:00","workEnd":"16:00:00"},{"id":12,"firstName":"Beta","lastName":"Bea","workStart":"08:00:00","workEnd":"16:00:00"},{"id":13,"firstName":"Cindy","lastName":"Crawford","workStart":"09:00:00","workEnd":"17:00:00"},{"id":14,"firstName":"Dicke","lastName":"Donna","workStart":"09:00:00","workEnd":"17:00:00"}],[{"id":3,"user":{"id":14,"role":"barber","name":"barber4","firstName":"Blocked","lastName":"Blocked","telephone":"02351753407","workStart":"09:00:00","workEnd":"17:00:00"},"slotStart":"2023-03-01 15:00:00","slotEnd":"2023-03-01 15:30:00","user_id":14,"barber_id":11},{"id":4,"user":{"id":2,"role":"customer","name":"customer1","firstName":"Blocked","lastName":"Blocked","telephone":"06838283528"},"slotStart":"2023-03-01 09:00:00","slotEnd":"2023-03-01 09:30:00","user_id":2,"barber_id":11},{"id":10,"user":{"id":8,"role":"customer","name":"customer7","firstName":"Blocked","lastName":"Blocked","telephone":"02655265108"},"slotStart":"2023-03-03 15:00:00","slotEnd":"2023-03-03 15:30:00","user_id":8,"barber_id":11},{"id":49,"user":{"id":11,"role":"barber","name":"barber1","firstName":"Blocked","lastName":"Blocked","telephone":"0541117929","workStart":"08:00:00","workEnd":"16:00:00"},"slotStart":"2023-03-01 11:00:00","slotEnd":"2023-03-01 11:30:00","user_id":11,"barber_id":11},{"id":51,"user":{"id":3,"role":"customer","name":"customer2","firstName":"Anita","lastName":"Epple","telephone":"0281807502"},"slotStart":"2023-03-03 11:30:00","slotEnd":"2023-03-03 12:30:00","user_id":3,"barber_id":11},{"id":52,"user":{"id":11,"role":"barber","name":"barber1","firstName":"Blocked","lastName":"Blocked","telephone":"0541117929","workStart":"08:00:00","workEnd":"16:00:00"},"slotStart":"2023-03-03 09:00:00","slotEnd":"2023-03-03 09:30:00","user_id":11,"barber_id":11},{"id":53,"user":{"id":3,"role":"customer","name":"customer2","firstName":"Anita","lastName":"Epple","telephone":"0281807502"},"slotStart":"2023-02-28 11:00:00","slotEnd":"2023-02-28 12:00:00","user_id":3,"barber_id":11},{"id":54,"user":{"id":3,"role":"customer","name":"customer2","firstName":"Anita","lastName":"Epple","telephone":"0281807502"},"slotStart":"2023-03-02 10:00:00","slotEnd":"2023-03-02 11:00:00","user_id":3,"barber_id":11}]]';
    echo $response;
} elseif ($action === 'updateUser') {
    $response = User::updateUser($user_id, $roleToSave, $name, $firstName, $lastName, $telephone, $password, $workStart, $workEnd);
} elseif ($action === 'loadUser') {
    $response = User::getAllUsersWithoutPassword();
    echo $response;
} elseif ($action === 'saveUser') {
    $response = User::saveUser($roleToSave, $name, $firstName, $lastName, $telephone, $password, $workStart, $workEnd);
    echo $response;
}
