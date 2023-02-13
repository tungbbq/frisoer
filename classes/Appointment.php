<?php

class Appointment implements JsonSerializable
{
    private int $id;
    private User $user;
    private string $slotStart;
    private string $slotEnd;
    private int $user_id;

    public function jsonSerialize() {
        return array($this->id, $this->user, $this->slotStart, $this->slotEnd, $this->user_id, $this->user);
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return object
     */
    public function getUser(): object
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getSlotStart(): string
    {
        return $this->slotStart;
    }

    /**
     * @return string
     */
    public function getSlotEnd(): string
    {
        return $this->slotEnd;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getBarberId(): int
    {
        return $this->barber_id;
    }
    private int $barber_id;

    /**
     * @param string $slotStart
     * @param string $slotEnd
     * @param int $barber_id
     * @param int $user_id
     * @param int|NULL $id
     */
    public function __construct(string $slotStart, string $slotEnd, int $barber_id, int $user_id, int $id = NULL)
    {
        $this->slotStart = $slotStart;
        $this->slotEnd = $slotEnd;
        $this->barber_id = $barber_id;
        $this->user_id = $user_id;
        $this->user = (object)(User::getUserById($user_id));
        $mysqli = Db::connect();
        if (!isset($id)) {
            $sql = "INSERT INTO appointments(id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '$slotStart', '$slotEnd', '$barber_id', '$user_id')";
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
            $appointments[] = get_object_vars(new Appointment($row['slotStart'], $row['slotEnd'], $row['barber_id'], $row['user_id'], $row['id']));
        }

        return $appointments;
    }
}
