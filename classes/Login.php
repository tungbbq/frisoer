<?php

function httpReply($code , $msg)
{
    http_response_code($code);
    echo $msg;
    exit();
}

class Login
{
    private Db $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function login()
    {
        $username = $_POST['userName'];
        $pwd = $_POST['pwd'];

        $sql = "select role, concat(id, name) AS pwd from users where name=?;";
        $stmt = $this->db::connect()->stmt_init();
        if (!$stmt->prepare($sql)) {
            httpReply(400, "Something went wrong");
        }

        $stmt->bind_param('s', $username);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            if (isset($data['pwd'])) {
                $isValid = $pwd === $data['pwd'];
                    if ($isValid) {
                        $_SESSION['role'] = $data['role'];
                        http_response_code(200);
                        echo 'Welcome ' . $username;
                    } else {
                        http_response_code(401);
                        echo "Invalid User name or password";
                    }
            } else {
                http_response_code(401);
                echo "Invalid User name or password";
            }
        }
        exit();
    }

    public function logout()
    {
        unset($_SESSION['role']);
        session_destroy();
        echo "You are logged out!!!";
        exit();
    }
}
