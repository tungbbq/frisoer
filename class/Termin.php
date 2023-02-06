<?php

class Termin
{
    private int $id;
    private object $user;
    private string $slot;
    private int $user_id;

    /**
     * @param string $slot
     * @param int $user_id
     * @param int|NULL $id
     */
    public function __construct(string $slot, int $user_id, int $id = NULL)
    {
        $this->slot = $slot;
        $this->user_id = $user_id;
        $this->user = User::getUserById($user_id);
        $mysqli = Db::connect();
        if (!isset($id)) {
            $sql = "INSERT INTO termin(id, slot, user_id) VALUES (NULL, '$slot', '$user_id')";
            $result = $mysqli->query($sql);
            $this->id = $mysqli->insert_id;
            // If id is given it uses it.
        } else {
            $this->user = User::getUserById($user_id);
            $this->slot = $slot;
            $this->user_id = $user_id;
            $this->id = $id;
        }
    }

    public static function createEmptyWeek(string $monday) : array {
        $date = new DateTime("$monday 09:00:00");
        $emptyWeekArray[] = ['', $date->format('Y-m-d'), $date->format('H')];

        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $newDate = $date->add(new DateInterval('P1D'));
                $emptyWeekArray[] = ['', $newDate->format('Y-m-d'), $newDate->format('H')];
            }
            $newDate = $date->add(new DateInterval('PT1H'));
            $newDate = $date->sub(new DateInterval('P5D'));
            $newDate = $date->add(new DateInterval('P1D'));
            $emptyWeekArray[] = ['', $newDate->format('Y-m-d'), $newDate->format('H')];

        }
        array_pop($emptyWeekArray);
        return $emptyWeekArray;
    }

    public static function getWeek(string $monday): array
    {
        $weekArray = Termin::createEmptyWeek($monday);
        $mysqli = Db::connect();
        $sql = "SELECT id, slot, user_id FROM termin WHERE WEEK('$monday')";
        $result = $mysqli->query($sql);
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = new Termin($row['slot'], $row['user_id'], $row['id']);

        }

        foreach ($appointments as $appointment) {
            foreach ($weekArray as $key => $termin) {
                if (substr($appointment->getSlot(), 0, 10) == $termin[1] && substr($appointment->getSlot(), 11, 2) == $termin[2]) {
                    $weekArray[$key][0] = User::getUserById($appointment->getUserId())->getName();
                    //termin[0] would not work here.
                }
            }
        }
        return $weekArray;
    }


    /**
     * @param object $user
     */
    public function setUser(object $user): void
    {
        $this->user = $user;
    }

    /**
     * @param string $slot
     */
    public function setSlot(string $slot): void
    {
        $this->slot = $slot;
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
    public function getSlot(): string
    {
        return $this->slot;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

}