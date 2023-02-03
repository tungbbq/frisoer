<?php

class User
{
    private int $id;
    private string $name;

    /**
     * @param string $name
     * @param int|NULL $id
     */
    public function __construct(string $name, int $id = NULL)
    {
        $this->name = $name;
        $mysqli = Db::connect();
        if (!isset($id)) {
            $sql = "INSERT INTO user(id, name) VALUES (NULL, '$name')";
            $result = $mysqli->query($sql);
            $this->id = $mysqli->insert_id;
            // If id is given it uses it.
        } else {
            $this->name = $name;
            $this->id = $id;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $pk
     * @return User
     */
    public static function getUserById(int $pk) : user
    {
        $mysqli = Db::connect();
        $sql = "SELECT id, name FROM user WHERE id=$pk";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        return new User($row['name'], $row['id']);
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


}