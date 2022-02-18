<?php

require_once 'src/controlers/DefaultController.php';
require_once 'src/controlers/SecurityController.php';
require_once 'src/controlers/MeetingController.php';
require_once 'src/controlers/ProfileController.php';
require_once 'src/controlers/RegisterController.php';
require_once 'src/controlers/SettingsController.php';
require_once 'src/controlers/MoviesController.php';
require_once 'src/controlers/SeriesController.php';

class Routing
{
    public static $routes;

    public static function get($url, $controller)
    {
        self::$routes[$url] = $controller;
    }
    public static function post($url, $controller)
    {
        self::$routes[$url] = $controller;
    }

    public static function run($url){
        $urlParts = explode("/",$url);

        $action = $urlParts[0];

        if(!array_key_exists($action,self::$routes)){
            die("Wrong url!");
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';

        $id = $urlParts[1] ?? '';

        $object->$action($id);
    }
}