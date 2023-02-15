<?php
include 'config.php';

spl_autoload_register(function ($class)
{
    include 'classes/' . $class . '.php';
});

session_start();

$db = new Db();
$login = new Login($db);

$view = $_REQUEST['view'] ?? 'startPage';
$action = $_REQUEST['action'] ?? '';
$role = $_SESSION['role'] ?? '';
$barberId = $_SESSION['barberId'] ?? '';
$userId = $_SESSION['userId'] ?? '';



if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'login') {
    $login->login();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'logout') {
    $login->logout();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'role') {
    if ($role === 'customer') {
        include_once 'views/customerPage.php';
    } elseif ($role === 'barber') {
        include_once 'views/barberPage.php';
    } else {
        include_once 'views/adminPage.php';
    }
} else include 'views/' . $view . '.php';

