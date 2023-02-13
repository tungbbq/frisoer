<?php

class Appointment implements JsonSerializable
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
        $sql = "SELECT id, slotStart, slotEnd, barber_id, user_id FROM appointments WHERE WEEK('$monday') AND barber_id=$barber_id";
        $result = $mysqli->query($sql);
        $appointments = [];

        while ($row = $result->fetch_assoc()) {

            $appointments[] = new Appointment($row['slotStart'], $row['slotEnd'],
                $row['barber_id'], $row['user_id'], $row['id']);
        }

        return $appointments;
    }
    public static function getAppointmentsByBarberArray(string $monday, int $barber_id){
        $arr = [];
        
        foreach (self::getAppointmentsByBarber($monday, $barber_id) as $appointment){
            $arr[] = $appointment->jsonSerialize();
        }
        return $arr;
    }

    /**
     * @param Appointment $appointment
     * @return string[]
     */
    public function jsonSerialize(): array
    {
        $vars = get_object_vars($this);

        return $vars;
    }

}