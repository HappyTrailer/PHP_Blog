<?php
class Category
{
    private $id;
    private $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    public function addCategory()
    {
        Database::insertQuery("INSERT INTO Categories(`name`) VALUES ('$this->name')");
    }

    public static function getCategories()
    {
        $result = Database::selectAll("SELECT * FROM Categories");
        return $result;
    }

    public static function delCategory($cat)
    {
        Database::insertQuery("DELETE FROM Categories WHERE id = '$cat'");
    }

    public static function getCategory($cat)
    {
        $result = Database::selectObject("SELECT * FROM Categories WHERE id = '$cat'");
        return $result->name;
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