<?php
include 'config.php';

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

session_start();
// Variablen empfangen
$action = $_REQUEST['action'] ?? '';
$username = $_POST['userName'] ?? '';
$pwd = $_POST['pwd'] ?? '';

// Variablen aus session
$role = $_SESSION['role'] ?? '';
$barberId = $_SESSION['barberId'] ?? '';
$userId = $_SESSION['userId'] ?? '';

// desinfizieren

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'login') {
    User::login($username, $pwd);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'logout') {
    User::logout();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'role') {
    if (in_array($role, ['customer', 'barber', 'admin'])) {
        include 'views/' . $role . 'Page.php';
    }
} else {
    include 'views/loginPage.php';
}