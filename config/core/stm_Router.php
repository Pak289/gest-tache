<?php

class stm_Router
{
    public static $DIR = __DIR__ . '/stm/';
    public static $URL = 'http://10.251.64.116/';
    public static $CONFIG = 'config/';
    public static $PUBLIC = 'public/';
    public static $PICTURES = 'public/pictures/';
    public static $TEMPLATES = 'templates/';

    public static function public($file)
    {
        return printf('/' . stm_Router::$PUBLIC . $file);
    }

}
