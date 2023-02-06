<?php

class TransferTermin
{
    public string $name;
    public string $day;
    public int $hour;

    /**
     * @param string $name
     * @param string $day
     * @param int $hour
     */
    public function __construct(string $name, string $day, int $hour)
    {
        $this->name = $name;
        $this->day = $day;
        $this->hour = $hour;
    }

    public static function getTransferTermine(array $weekday) : array {
        $transferArray = [];
        foreach ($weekday as $day) {
            $transferArray[] = new TransferTermin($day[0], $day[1], $day[2]);
        }
        return $transferArray;
    }
}




