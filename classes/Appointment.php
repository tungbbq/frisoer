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
        $stmt = $mysqli->prepare("SELECT id, slotStart, slotEnd, barber_id, user_id FROM appointments WHERE slotStart BETWEEN ? AND ? + INTERVAL 7 DAY AND barber_id=?");
        $stmt->bind_param("ssi", $monday, $monday, $barber_id);
        $stmt->execute();
        $result = $mysqli->query($stmt);

        $appointments = [];

        while ($row = $result->fetch_assoc()) {
            $appointments[] = get_object_vars(new Appointment($row['slotStart'], $row['slotEnd'], $row['barber_id'], $row['user_id'], $row['id']));
        }

        return $appointments;
    }
}