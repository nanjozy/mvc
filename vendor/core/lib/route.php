<?php

namespace core\lib;
class route
{
    public $module;
    public $controller;
    public $action;

    public function __construct()
    {
//       dbg($_SERVER["REQUEST_URI"],'1');
        /*
         * 1.获取URL的参数部分
         * 2.获取对应的控制器和方法
         * */
        //获取URL的参数部分
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
            $path = ltrim(trim($_SERVER['REQUEST_URI'], '/'), '?');
            $path = base64_decode($path);

            if ($path != '/') {

                $patharr = explode('&', ltrim(trim($path, '/'), '?'));
                if (isset($patharr[0])) {
                    $this->module = ltrim($patharr[0], 'm=');
                } else {
                    $this->module = 'index';
                }
                if (isset($patharr[1])) {
                    $this->controller = ltrim($patharr[1], 'c=');
                }
                if (isset($patharr[2])) {
                    $this->action = ltrim($patharr[2], 'f=');
                } else {
                    $this->action = 'index';
                }
                //url多余部分转换成GET参数
                $count = count($patharr);
                for ($i = 2; $i < $count; $i++) {
                    $temp = explode('=', $patharr[$i]);
                    if (isset($temp[0]) && (!is_null($temp[0]))) {
                        $_GET[$temp[0]] = $temp[1];
                    }
                }
                unset($_GET['url']);
            }
        } else {
            $this->module = 'index';
            $this->controller = 'index';
            $this->action = 'index';
        }
    }
}