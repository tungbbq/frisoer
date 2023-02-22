<?php

class User implements JsonSerializable
{
    private int $id;
    private string $role;
    private string $name;
    private string $firstName;
    private string $lastName;
    private string $telephone;
    private string $workStart;
    private string $workEnd;

    /**
     * @param string $role
     * @param string $name
     * @param string $firstName
     * @param string $lastName
     * @param string $telephone
     * @param string|null $workStart
     * @param string|null $workEnd
     * @param int|NULL $id
     */

    public function __construct(string $role, string $name, string $firstName, string $lastName, string $telephone, ?string $workStart = NULL, ?string $workEnd = NULL, int $id = NULL)
    {
        $this->role = $role;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->telephone = $telephone;
        if (isset($workStart)) {
            $this->workStart = $workStart;
        }
        if (isset($workEnd)) {
            $this->workEnd = $workEnd;
        }

        $mysqli = Db::connect();
        if (!isset($id)) {
            $sql = "INSERT INTO users(id, role, name, firstName, lastName, telephone, workStart, workEnd) VALUES (NULL, '$role', '$name', '$firstName', '$lastName', '$telephone', '$workStart', '$workEnd')";
            $mysqli->query($sql);
            $this->id = $mysqli->insert_id;
        } else {
            $this->id = $id;
        }
    }

    /**
     * @param int $primaryKey
     * @return User
     */
    public static function getUserById(int $primaryKey) : User
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("SELECT id, role, name, firstName, lastName, telephone, workStart, workEnd FROM users WHERE id=?");
        $stmt->bind_param("i", $primaryKey);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return new User($row['role'], $row['name'], $row['firstName'], $row['lastName'], $row['telephone'], $row['workStart'], $row['workEnd'], $row['id']);
    }

    /**#
     * @return string[]
     */
    public function jsonSerialize(): array
    {
        $vars = get_object_vars($this);
        // change User-object to Array
        if (is_object($vars)){
            $vars = $vars->jsonSerialize();
        }

        return $vars;
    }

    /**
     * @return array
     */
    public static function getAllBarbers() : array
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE role=?");
        $role = "barber";
        $stmt->bind_param("s", $role);
        $stmt->execute();
        $result = $stmt->get_result();
        $barbers = [];

        while ($row = $result->fetch_assoc()) {

            $barbers[] = new User(
                $row['role'],
                $row['name'],
                $row['firstName'],
                $row['lastName'],
                $row['telephone'],
                $row['workStart'],
                $row['workEnd'],
                $row['id']
        );
        }
        return $barbers;
    }

    public static function getNamesOfBarbers() : array
    {
        $barbers = self::getAllBarbers();
        foreach ($barbers as $barber) {
            $barberNames[] = ['id'=>$barber->getId(), 'firstName'=>$barber->getFirstName(), 'lastName'=>$barber->getLastName(), 'workStart'=>$barber->getWorkStart(), 'workEnd'=>$barber->getWorkEnd()];
        }
        return $barberNames;
    }
    public static function getAllBarberArray(): array
    {
        $arr = [];

        foreach (self::getAllBarbers() as $barber){
            $arr[] = $barber->jsonSerialize();
        }
        return $arr;
    }


    /**
     * @return array
     */
    public static function getAllUsers() : array
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE role=?");
        $role = "customer";
        $stmt->bind_param("s", $role);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];

        while ($row = $result->fetch_assoc()) {

            $users[] = new User(
                $row['role'],
                $row['name'],
                $row['firstName'],
                $row['lastName'],
                $row['telephone'],
                $row['workStart'],
                $row['workEnd'],
                $row['id']
            );
        }
        return $users;
    }


    public static function getNamesOfUsers() : array
    {
        $users = self::getAllUsers();
        foreach ($users as $user) {
            $userNames[] = ['id'=>$user->getId(), 'firstName'=>$user->getFirstName(), 'lastName'=>$user->getLastName()];
        }
        return $userNames;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getWorkStart(): string
    {
        return $this->workStart;
    }

    /**
     * @return string
     */
    public function getWorkEnd(): string
    {
        return $this->workEnd;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    // aus Klasse login
    public static function login(string $username, string $pwd)
    {
        $sql = "select users.id, role, concat(users.id, name) AS pwd, barber_id from users LEFT JOIN appointments ON users.id = appointments.user_id where name=?";
        //$sql = "SELECT id, role, concat(id, name) AS pwd FROM users WHERE name=?";
        try {
            if (Db::connect() !== null) {
                $stmt = Db::connect()->stmt_init();

                if (!$stmt->prepare($sql)) {
                    throw new Exception("Etwas ist schief gelaufen", 400);
                }

                $stmt->bind_param('s', $username);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    $data = $result->fetch_assoc();
                    if (isset($data['pwd'])) {
                        $isValid = $pwd === $data['pwd'];
                        if ($isValid) {
                            $_SESSION['role'] = $data['role'];
                            $_SESSION['barberId'] = $data['barber_id'];
                            $_SESSION['userId'] = $data['id'];

                            http_response_code(200);
                            echo 'Welcome ' . $username;
                        } else {
                            throw new Exception("Ungültiges Passwort", 401);
                        }
                    } else {
                        throw new Exception("Ungültiger Benutzername", 401);
                    }
                }
            }
            exit();
        } catch (Exception $exception) {
            http_response_code($exception->getCode());
            echo $exception->getMessage();
        }
    }

    public static function logout()
    {
        unset($_SESSION['role']);
        session_destroy();
        echo "You are logged out!!!";
        exit();
    }

}