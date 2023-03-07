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
    $userId = $_SESSION['userId'] ?? '';
    $firstName = $_SESSION['firstName'] ?? '';
    $lastName = $_SESSION['lastName'] ?? '';

// desinfizieren
    $userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'login') {
        User::login($userName, $pwd);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'logout') {
        User::logout();
        include 'views/loginPage.php';
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $action == 'role') {
        if (in_array($role, ['customer', 'barber', 'admin'])) {
            if ($role === 'admin'){
                include 'views/showCreateUser.php';
            } else include 'views/customerPage.php';
        }
    } else {
        include 'views/loginPage.php';
    }
}
