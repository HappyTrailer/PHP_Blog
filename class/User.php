<?php
class User
{
    private $id;
    private $login;
    private $password;
    private $reset;
    private $name;

    function __construct($login, $password, $reset, $name)
    {
        $this->login = $login;
        $this->password = md5($password);
        $this->reset = $reset;
        $this->name = $name;
    }

    public function registration()
    {
        Database::insertQuery("INSERT INTO `Users`(`login`, `password_hash`, `password_reset`, `name`) VALUES ('$this->login','$this->password','$this->reset','$this->name')");
        Log::info("Добавлен юзер: " . $this->name);
    }

    public static function login($pass, $login)
    {
        $password = md5($pass);
        $result = Database::selectObject("SELECT id FROM Users WHERE login = '$login' AND password_hash = '$password'");
        return $result->id;
    }

    public static function logout()
    {
        unset($_SESSION['authId']);
    }

    public static function getUserName($id)
    {
        $result = Database::selectObject("SELECT `name` FROM Users WHERE id = '$id'");
        return $result->name;
    }

    public static function getCurrentUser()
    {
        return (int)$_SESSION['authId'];
    }

    function __get($name)
    {
        Log::error("Вызвано неизвестное поле класса " . __CLASS__ . " - $name");
        return null;
    }

    function  __set($name, $value)
    {
        Log::error("Присвоение значения " . $value . " неизвестному полю класса " . __CLASS__ . " - $name");
    }

    function __call($name, $arguments)
    {
        Log::error("Вызван неизвесный метод класса " . __CLASS__ . " - " . $name . " с аргументами - " . $arguments);
    }

    function  __toString()
    {
        Log::warning("Вызван вывод объекта класса " . __CLASS__);
        return $this->name . "";
    }
}