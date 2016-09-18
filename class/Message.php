<?php
class Message
{
    private $id;
    private $email;
    private $message;

    function __construct($email, $message)
    {
        $this->email = $email;
        $this->message = $message;
    }

    public function sendMessage()
    {
        Database::insertQuery("INSERT INTO Requests(`email`, `message`) VALUES ('$this->email','$this->message')");
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