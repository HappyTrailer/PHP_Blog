<?php
class Autoloader
{
    private static $_lastLoadedFile;
    public static function load($class) {
        self::$_lastLoadedFile = $class . ".php";
        require_once (self::$_lastLoadedFile);
    }

    public static function loadAndLog($class) {
        self::load($class);
        Log::info("Клас $class загружен из файла " . self::$_lastLoadedFile);
    }
}