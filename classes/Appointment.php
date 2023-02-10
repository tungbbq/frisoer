<?php

class Appointment
{
    private int $id;
    private object $user;
    private string $slotStart;
    private string $slotEnd;
    private int $user_id;
    private int $barber_id;

    /**
     * @param string $slotStart
     * @param string $slotEnd
     * @param int $barber_id
     * @param $user_id
     * @param int|NULL $id
     */
    public function __construct(string $slotStart, string $slotEnd, int $barber_id, $user_id, int $id = NULL)
    {
        $this->slotStart = $slotStart;
        $this->slotEnd = $slotEnd;
        $this->barber_id = $barber_id;
        $this->user_id = $user_id;
        $this->user = User::getUserById($user_id);
        $mysqli = Db::connect();
        if (!isset($id)) {
            $sql = "INSERT INTO appointmens(id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '$slotStart', '$slotEnd', '$barber_id', '$user_id')";
            $result = $mysqli->query($sql);
            $this->id = $mysqli->insert_id;
        } else {
            $this->id = $id;
        }
    }

    public static function getAppointmentsByBarber(string $monday, int $barber_id): array
    {
        $mysqli = Db::connect();
        $sql = "SELECT id, slotStart, slotEnd, barber_id, user_id FROM appointments WHERE WEEK('$monday') AND barber_id=$barber_id";
        $result = $mysqli->query($sql);
        $appointments = [];

        while ($row = $result->fetch_assoc()) {
            $appointments[] = new Appointment($row['slotStart'], $row['slotEnd'], $row['barber_id'], $row['user_id'], $row['id']);
        }

        return $appointments;
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
     * @return object
     */
    public function getUser(): object
    {
        return $this->user;
    }

    /**
     * @param object $user
     */
    public function setUser(object $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getSlotStart(): string
    {
        return $this->slotStart;
    }

    /**
     * @param string $slotStart
     */
    public function setSlotStart(string $slotStart): void
    {
        $this->slotStart = $slotStart;
    }

    /**
     * @return string
     */
    public function getSlotEnd(): string
    {
        return $this->slotEnd;
    }

    /**
     * @param string $slotEnd
     */
    public function setSlotEnd(string $slotEnd): void
    {
        $this->slotEnd = $slotEnd;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getBarberId(): int
    {
        return $this->barber_id;
    }

    /**
     * @param int $barber_id
     */
    public function setBarberId(int $barber_id): void
    {
        $this->barber_id = $barber_id;
    }


}