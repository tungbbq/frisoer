<?php

class Db
{
    private static object $dbh;

    public static function connect()
    {
        try {
            if (!isset(self::$dbh)) {
                    self::$dbh = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWD, DB_NAME);
            }
            return self::$dbh;
        } catch (Exception $exception) {
            http_response_code(400);
            echo $exception->getMessage();
        }
    }
}