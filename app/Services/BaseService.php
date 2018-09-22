<?php

namespace App\Services;

class BaseService
{
    private static $obj_error;

    protected static function addError($msg, $code)
    {
        if (!self::$obj_error) {
            self::$obj_error = new class
            {
            };
        }
        self::$obj_error->message = $msg;
        self::$obj_error->code = $code;
        return true;
    }

    public static function getLastError()
    {
        if (self::$obj_error) {
            return self::$obj_error->message;
        }
        return false;
    }

    public static function getLastCode(){
        if (self::$obj_error) {
            return self::$obj_error->code;
        }
        return '服务器异常，请稍后再试';
    }
}