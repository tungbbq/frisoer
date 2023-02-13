<?php

class User
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
    public function __construct(string $role, string $name, string $firstName, string $lastName, string $telephone, string $workStart = NULL, string $workEnd = NULL, int $id = NULL)
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
            $this->id = $id;
        }
    }

    /**
     * @param int $primaryKey
     * @return array
     */
    public static function getUserById(int $primaryKey) : array
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("SELECT id, role, name, firstName, lastName, telephone, workStart, workEnd FROM users WHERE id=?");
        $stmt->bind_param("i", $primaryKey);
        $stmt->execute();
        $result = $mysqli->query($stmt);
        $row = $result->fetch_assoc();
        return get_object_vars(new User($row['role'], $row['name'], $row['firstName'], $row['lastName'], $row['telephone'], $row['workStart'], $row['workEnd'], $row['id']));
    }
}