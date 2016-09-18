<?php
class Log
{
    public static function info($message){
        self::printLog("Info: ", $message);
    }

    public static function warning($message){
        self::printLog("Warning: ", $message);
    }

    public static function error($message){
        self::printLog("Error: ", $message);
    }

    public  static function printLog($str_log, $message){
        $dt = time();
        $page =  $_SERVER['REQUEST_URI'];
        $str_log = $str_log . $dt . " -> " . $page . " Message: " . $message . "\n";
        $file = fopen('log.txt', 'a');
        fwrite($file, $str_log);
        fclose($file);
    }
}