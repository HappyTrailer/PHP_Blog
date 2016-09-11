<?php
class Database
{
    private $host;
    private $login;
    private $password;
    private $dbName;
    private $connect;

    function __construct($host, $login, $password, $dbName)
    {
        $this->host = $host;
        $this->login = $login;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    public function connect()
    {
        $this->connect = mysqli_connect($this->host, $this->login, $this->password, $this->dbName);
        if(mysqli_connect_errno())
        {
            exit();
        }
    }

    public function disconnect()
    {
        mysqli_close($this->connect);
    }

    public function insertQuery($str)
    {
        mysqli_query($this->connect, $str);
    }

    public function selectAll($str)
    {
        $query = mysqli_query($this->connect, $str);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        return $result;
    }

    public function selectObject($str)
    {
        $query = mysqli_query($this->connect, $str);
        $result = mysqli_fetch_object($query);
        return $result;
    }
}