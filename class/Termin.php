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

    public static function createEmptyWeek() : Array {
        $date = new DateTime('2023-01-31 09:00:00');
        $emptyWeekArray[] = ['', $date->format('Y-m-d'), $date->format('H')];

        // This is responsible for the 5 days of the week
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
        $weekArray = Termin::createEmptyWeek();
        $mysqli = Db::connect();
        $sql = "SELECT id, slot, user_id FROM termin WHERE WEEK('$monday')";
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
//            $weekArray[] = [User::getUserById($row['user_id'])->getName(), substr($row['slot'], 0,10), substr($row['slot'], 11,2)];
            $weekArray[] = ['BLOCKED', substr($row['slot'], 0,10), substr($row['slot'], 11,2)];
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