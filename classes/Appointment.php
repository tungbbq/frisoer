<?php

class Appointment implements \JsonSerializable
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
     * @param int $user_id
     * @param int|NULL $id
     */
    public function __construct(string $slotStart, string $slotEnd, int $barber_id, int $user_id, int $id = NULL)
    {
        $this->slotStart = $slotStart;
        $this->slotEnd = $slotEnd;
        $this->barber_id = $barber_id;
        $this->user_id = $user_id;
        $this->user = User::getUserById($user_id);
        $mysqli = Db::connect();
        if (!isset($id)) {
            $sql = "INSERT INTO appointments(id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, '$slotStart', '$slotEnd', '$barber_id', '$user_id')";
            $result = $mysqli->query($sql);
            $this->id = $mysqli->insert_id;
        } else {
            $this->id = $id;
        }
    }

    /**
     * @param string $monday
     * @param int $barber_id
     * @return Appointment[]
     */
    public static function getAppointmentsByBarber(string $monday, int $barber_id): array
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("SELECT id, slotStart, slotEnd, barber_id, user_id FROM appointments WHERE slotStart BETWEEN ? AND ? + INTERVAL 7 DAY AND barber_id=?");
        $stmt->bind_param("ssi", $monday, $monday, $barber_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $appointments = [];

        while ($row = $result->fetch_assoc()) {

            $appointments[] = new Appointment($row['slotStart'], $row['slotEnd'],
                $row['barber_id'], $row['user_id'], $row['id']);
        }

        return $appointments;
    }

    /**
     * @param string $monday
     * @param int $user_id
     * @return array
     */
    public static function getAppointmentsByUser(string $monday, int $user_id): array
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("SELECT id, slotStart, slotEnd, barber_id, user_id FROM appointments WHERE slotStart BETWEEN ? AND ? + INTERVAL 7 DAY AND user_id=?");
        $stmt->bind_param("ssi", $monday, $monday, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $appointmentsByUser = [];

        while ($row = $result->fetch_assoc()) {

            $appointmentsByUser[] = new Appointment($row['slotStart'], $row['slotEnd'],
                $row['barber_id'], $row['user_id'], $row['id']);
        }

        return $appointmentsByUser;
    }

    /**
     * @param string $monday
     * @param int $barber_id
     * @return string[][]
     */
    public static function getAppointmentsByBarberArray(string $monday, int $barber_id): array
    {
        $arr = [];

        foreach (self::getAppointmentsByBarber($monday, $barber_id) as $appointment) {
            $arr[] = $appointment->jsonSerialize();
        }
        return $arr;
    }

    public static function getAppointmentsByUserArray(string $monday, int $user_id): array
    {
        $arr = [];

        foreach (self::getAppointmentsByUser($monday, $user_id) as $appointment) {
            $arr[] = $appointment->jsonSerialize();
        }
        return $arr;
    }

    /**
     * @return string[]
     */
    public function jsonSerialize(): array
    {
        $vars = get_object_vars($this);
        // eingebettete Objekte für JSON-string aufbereiten
        // change User-object to Array
        if (is_object($vars)) {
            $vars = $vars->jsonSerialize();
        }
        return $vars;
    }

    public static function deleteAppointments(int $id): bool
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("DELETE FROM appointments WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * @param string $monday
     * @param int|null $barber_id
     * @return Appointment[]
     */
    public static function getAppointmentsByBarberAndUserId(string $monday, ?int $barber_id = null): array
    {
        if (!isset($barber_id)){
            $barber_id = User::getNamesOfBarbers()[0]['id'];
        }
        $appointments = self::getAppointmentsByBarber($monday,$barber_id);
        $role = $_SESSION['role'];
        if ($role === 'user') {
            $userId = $_SESSION['userId'];
            foreach ($appointments as $key => $appointment) {
                if ($appointment->getUserId() != $userId) {
                    ($appointments[$key]->getUser())->setFirstName('Blocked');
                    ($appointments[$key]->getUser())->setLastName('Blocked');
                }
            }
        }
        return $appointments;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public static function newAppointment(string $slotStart, string $slotEnd, int $barber_id, int $user_id) : bool
    {
        $mysqli = Db::connect();
        $stmt = $mysqli->prepare("INSERT INTO appointments(id, slotStart, slotEnd, barber_id, user_id) VALUES (NULL, ?, ?, ?, ?)");
        $stmt->bind_param("ssii", $slotStart, $slotEnd, $barber_id, $user_id);
        $stmt->execute();
        if ($mysqli->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

}


