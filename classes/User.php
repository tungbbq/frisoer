<?php

class User
{
    private int $id;
    private string $role;
    private string $name;
    private string $firstName;
    private string $lastName;
    private string $telephone;
    private String $workStart;
    private String $workEnd;


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


    public function __construct(string $role, string $name, string $firstName, string $lastName, string $telephone, String $workStart = NULL, String $workEnd = NULL, Int $id = NULL)
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


}