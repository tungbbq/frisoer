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
    private string $password;

    /**
     * @param string $role
     * @param string $name
     * @param string $firstName
     * @param string $lastName
     * @param string $telephone
     * @param string $password
     * @param string|null $workStart
     * @param string|null $workEnd
     * @param int|NULL $id
     */

    public function __construct(string $role, string $name, string $firstName, string $lastName, string $telephone, string $password, ?string $workStart = NULL, ?string $workEnd = NULL, int $id = NULL)
    {
        $this->role = $role;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->telephone = $telephone;
        $this->password = $password;
        if (isset($workStart)) {
            $this->workStart = $workStart;
        }
        if (isset($workEnd)) {
            $this->workEnd = $workEnd;
        }

        $mysqli = Db::connect();
        if (!isset($id)) {
            $sql = "INSERT INTO users(id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES (NULL, '$role', '$name', '$firstName', '$lastName', '$telephone', '$workStart', '$workEnd', '$password')";
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
    public static function getUserById(int $primaryKey): User
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("SELECT id, role, name, firstName, lastName, telephone, workStart, workEnd, password FROM users WHERE id=?");
        $stmt->bind_param("i", $primaryKey);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return new User($row['role'], $row['name'], $row['firstName'], $row['lastName'], $row['telephone'], $row['password'], $row['workStart'], $row['workEnd'], $row['id']);
    }

    /**
     * @return string[]
     */
    public function jsonSerialize(): array
    {
        $vars = get_object_vars($this);
        // change User-object to Array
        if (is_object($vars)) {
            $vars = $vars->jsonSerialize();
        }

        return $vars;
    }

    /**
     * @return array
     */
    public static function getAllBarbers(): array
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
                $row['password'],
                $row['workStart'],
                $row['workEnd'],
                $row['id']
            );
        }
        return $barbers;
    }

    /**
     * @return array
     */
    public static function getNamesOfBarbers(): array
    {
        $barbers = self::getAllBarbers();
        foreach ($barbers as $barber) {
            $barberNames[] = ['id' => $barber->getId(), 'firstName' => $barber->getFirstName(), 'lastName' => $barber->getLastName(), 'workStart' => $barber->getWorkStart(), 'workEnd' => $barber->getWorkEnd()];
        }
        return $barberNames;
    }

    /**
     * @return array
     */
    public static function getAllCustomers(): array
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
                $row['password'],
                $row['workStart'],
                $row['workEnd'],
                $row['id']
            );
        }
        return $users;
    }

    /**
     * @return array
     */
    public static function getAllUsers() : array
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("SELECT * FROM users");
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
                $row['password'],
                $row['workStart'],
                $row['workEnd'],
                $row['id']
            );
        }
        return $users;
    }

    /**
     * @return array
     */
    public static function getAllUsersWithoutPassword(): array
    {
        $users = self::getAllUsers();
        foreach ($users as $user) {
            $userAsso = [
                'id' => $user->getId(),
                'role' => $user->getRole(),
                'name' => $user->getName(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'telephone' => $user->getTelephone()
            ];
            // nur Frisöre haben Arbeitsanfangs- und -endzeit
            if ($user->getRole() === 'barber') {
                $userAsso['workStart'] = $user->getWorkStart();
                $userAsso['workEnd'] = $user->getWorkEnd();
            }
            $allUsersWithoutPassword[] = $userAsso;
        }

        return $allUsersWithoutPassword;
    }

    /**
     * @return array
     */
    public static function getNamesOfCustomers(): array
    {
        $customers = self::getAllCustomers();
        foreach ($customers as $user) {
            $customersNames[] = ['id' => $user->getId(), 'firstName' => $user->getFirstName(), 'lastName' => $user->getLastName()];
        }
        return $customersNames;
    }

    /**
     * nur Kommentar
     * @param string $username
     * @param string $pwd
     * @return void
     */
    // aus Klasse login
    public static function login(string $username, string $pwd)
    {
        $sql = "
                SELECT users.id, role, password AS pwd, barber_id, firstName, lastName
                FROM users 
                LEFT JOIN appointments ON users.id = appointments.user_id 
                WHERE name=?
            ";

        try {
            $stmt = Db::connect()->stmt_init();

            if (!$stmt->prepare($sql)) {
                throw new Exception("Etwas ist schief gelaufen", 400);
            }

            $stmt->bind_param('s', $username);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
                if (isset($data['pwd'])) {
                    $isValid = password_verify($pwd, $data['pwd']);
                    if ($isValid) {
                        $_SESSION['role'] = $data['role'];
                        $_SESSION['userId'] = $data['id'];
                        $_SESSION['firstName'] = $data['firstName'];
                        $_SESSION['lastName'] = $data['lastName'];

                        http_response_code(200);
                        echo 'Welcome ' . $username;
                    } else {
                        throw new Exception("Ungültiges Passwort", 401);
                    }
                } else {
                    throw new Exception("Ungültiger Benutzername", 401);
                }
            }
            exit();
        } catch (Exception $exception) {
            http_response_code($exception->getCode());
            echo $exception->getMessage();
        }
    }

    /**
     * @return void
     */
    public static function logout()
    {
        unset($_SESSION['role']);
        session_destroy();
        echo "You are logged out!!!";
        exit();
    }

    /**
     * @param int $id
     * @param string $role
     * @param string $name
     * @param string $firstName
     * @param string $lastName
     * @param string $telephone
     * @param string|null $workStart
     * @param string|null $workEnd
     * @return void
     */
    public static function updateUser(int $id, string $role, string $name, string $firstName, string $lastName, string $telephone, ?string $workStart = NULL, ?string $workEnd = NULL)
    {
        $mysqli = Db::connect();
        if ($role === 'customer') {
            $stmt = $mysqli->prepare("UPDATE users SET role=?, name=?, firstName=?, lastName=?, telephone=? WHERE id=?");
            $stmt->bind_param("sssssi", $role, $name, $firstName, $lastName, $telephone, $id);
        } elseif ($role === 'barber' && $workStart !== '' && $workEnd !== '') {
            $stmt = $mysqli->prepare("UPDATE users SET role=?, name=?, firstName=?, lastName=?, telephone=?, workStart=?, workEnd=? WHERE id=?");
            $stmt->bind_param("sssssssi", $role, $name, $firstName, $lastName, $telephone, $workStart, $workEnd, $id);
        }
        $stmt->execute();
        if ($mysqli->affected_rows > 0) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    }

    /**
     * @param string $role
     * @param string $name
     * @param string $firstName
     * @param string $lastName
     * @param string $telephone
     * @param string $password
     * @param string|null $workStart
     * @param string|null $workEnd
     * @return void
     */
    public static function saveUser(string $role, string $name, string $firstName, string $lastName, string $telephone, string $password, ?string $workStart = NULL, ?string $workEnd = NULL)
    {
        $mysqli = Db::connect();
        $password = password_hash($password, PASSWORD_DEFAULT);
        if ($role === 'barber' && $workStart !== '' && $workEnd !== '') {
            $stmt = $mysqli->prepare("INSERT INTO users (id, role, name, firstName, lastName, telephone, workStart, workEnd, password) VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $role, $name, $firstName, $lastName, $telephone, $workStart, $workEnd, $password);
            $stmt->execute();
        } elseif ($role === 'customer') {
            $stmt = $mysqli->prepare("INSERT INTO users (id, role, name, firstName, lastName, telephone, password) VALUES(NULL, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $role, $name, $firstName, $lastName, $telephone, $password);
            $stmt->execute();
        }
        if ($mysqli->affected_rows > 0) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    }

    /**
     * @param int $id
     * @return bool|int
     */
    public static function deleteUser(int $id): bool|int
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($mysqli->affected_rows > 0) {
            //return http_response_code(200);
            return true;
        } else {
            return http_response_code(400);
        }

    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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
}