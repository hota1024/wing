<?php
class GlobalVariable{
    private static $variables = [];
    public static $data;

    static function register($name, $value){
        static::$variables[$name] = $value;
        static::$data = (object)static::$variables;
    }
}

function gv(){
    return GlobalVariable::$data;
}