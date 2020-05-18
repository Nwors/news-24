<?php


// add third parameter in function add called arguments in execute put this array into function.


class Router {
    static $routes = [];

    static function add($url, $function) {
        $newRoute = ['url' => $url,"handler" => $function];
        array_push(self::$routes, $newRoute);
    }

    static function delete($url) {
        $index = 0;
        forEach(self::$routes as $route) {
            if($route['url'] == $url) {
                unset(self::$routes[$index]);
            }
            $index++;
        }
    }

    static function execute($url) {
        forEach(self::$routes as $route) {
            if($route['url'] == $url) {
                call_user_func($route['handler']);
                return true;
            }
        }
        return false;
    }
    static function executeDefault() {
        self::execute("/default");
    }
}

