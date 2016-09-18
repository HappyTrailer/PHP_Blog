<?php
require_once 'constants.php';
class Database
{
    private static $connect;

    public static function connect()
    {
        self::$connect = mysqli_connect(HOST, LOGIN, PASS, NAME);
        if(mysqli_connect_errno())
        {
            exit();
        }
    }

    public static function disconnect()
    {
        mysqli_close(self::$connect);
    }

    public static function insertQuery($str)
    {
        self::connect();
        mysqli_query(self::$connect, $str);
        self::disconnect();
    }

    public static function selectAll($str)
    {
        self::connect();
        $query = mysqli_query(self::$connect, $str);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        self::disconnect();
        return $result;
    }

    public static function selectObject($str)
    {
        self::connect();
        $query = mysqli_query(self::$connect, $str);
        $result = mysqli_fetch_object($query);
        self::disconnect();
        return $result;
    }
}