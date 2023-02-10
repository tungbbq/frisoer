<?php

class User
{
    private int $id;
    private string $role;
    private string $name;
    private string $firstName;
    private string $lastName;
    private string $telephone;
    private int $workStart;
    private int $workEnd;

    /**
     * @param string $role
     * @param string $name
     * @param string $firstName
     * @param string $lastName
     * @param string $telephone
     * @param int|null $workStart
     * @param int|null $workEnd
     * @param int|NULL $id
     */
    public function __construct(string $role, string $name, string $firstName, string $lastName, string $telephone, ?int $workStart = NULL, ?int $workEnd = NULL, int $id = NULL)
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
            $result = $mysqli->query($sql);
            $this->id = $mysqli->insert_id;
        } else {
            $this->role = $role;
            $this->name = $name;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->telephone = $telephone;
            $this->id = $id;
        }
    }

    /**
     * @param int $primaryKey
     * @return User
     */
    public static function getUserById(int $primaryKey) : user
    {
        $mysqli = Db::connect();
        $sql = "SELECT id, role, name, firstName, lastName, telephone, workStart, workEnd FROM users WHERE id=$primaryKey";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        return new User($row['role'], $row['name'], $row['firstName'], $row['lastName'], $row['telephone'], $row['workStart'], $row['workEnd'], $row['id']);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return int
     */
    public function getWorkStart(): int
    {
        return $this->workStart;
    }

    /**
     * @param int $workStart
     */
    public function setWorkStart(int $workStart): void
    {
        $this->workStart = $workStart;
    }

    /**
     * @return int
     */
    public function getWorkEnd(): int
    {
        return $this->workEnd;
    }

    /**
     * @param int $workEnd
     */
    public function setWorkEnd(int $workEnd): void
    {
        $this->workEnd = $workEnd;
    }


}