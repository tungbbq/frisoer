<?php
include './config.php';

spl_autoload_register(function ($class)
{
    include 'classes/' . $class . '.php';
});
$monday = $_POST['monday'] ?? '';
$barberId = $_POST['barberId'] ?? '';
$delete = $_POST['delete'] ?? '';
$getAllBarbers = $_POST['getAllBarbers'] ?? '';

$transferredWeek = Appointment::getAppointmentsByBarber($monday, (int)$barberId);

if ($getAllBarbers !== ''){
    $getBarbers = User::getNamesOfBarbers();
    echo json_encode($getBarbers);
} else

echo json_encode($transferredWeek);


