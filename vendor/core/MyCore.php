<?php

namespace core;

use core\lib\route;

class MyCore
{
    public static $classMap = array();
    protected $view = NULL;
    protected $model = NULL;

    //加载控制器
    static public function run()
    {
        $route = new route();
        $module = $route->module;
        $controllerClass = $route->controller;
        $action = $route->action;
        $controllerFile = APP . '/' . $module . '/controller/' . $controllerClass . 'Controller.php';
        $controllerClass = '\\' . MODULES . '\\' . $module . '\\controller\\' . $controllerClass . 'Controller';
        if (is_file($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerClass();
            $controller->$action();
        } else {
            echo '404 NOT FOUND';
        }
    }

    //自动加载类
    /*static public function load($class)
    {
        //自动加载类库
        if (isset($classMap[$class])) {
            return true;
        } else {
            $class = str_replace('\\', '/', $class);
            $file = VENDOR . '/' . $class . '.php';
            if (is_file($file)) {
                require_once $file;
                self::$classMap[$class] = $class;
            } else {
                $file = APP . '/' . $class . '.php';
                if (is_file($file)) {
                    require_once $file;
                    self::$classMap[$class] = $class;
                } else {
                    $file = ROOT_PATH . '/' . $class . '.php';
                    if (is_file($file)) {
                        require_once $file;
                        self::$classMap[$class] = $class;
                    } else {
                        return false;
                    }
                }
            }
        }
    }*/
}