<?php
include 'config.php';

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

session_start();
if (isset($_POST)) {
// Variablen empfangen
    $action = $_REQUEST['action'] ?? '';
    $userName = $_POST['userName'] ?? '';
    $pwd = $_POST['pwd'] ?? '';

// Variablen aus session
    $role = $_SESSION['role'] ?? '';
    $barberId = $_SESSION['barberId'] ?? '';
    $userId = $_SESSION['userId'] ?? '';

// desinfizieren
    $userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'login') {
        User::login($userName, $pwd);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'logout') {
        User::logout();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'role') {
        if (in_array($role, ['customer', 'barber', 'admin'])) {
            include 'views/customerPage.php';
        }
    } else {
        include 'views/loginPage.php';
    }
}