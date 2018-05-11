<?php
session_start();

use core\MyCore;

/*
 * 入口文件
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 * */
define('ROOT_PATH', __DIR__ . '/..');  //当前框架所在的目录
define('VENDOR', ROOT_PATH . '/vendor');//vendor目录
define('CORE', VENDOR . '/core');  //框架核心文件所在的目录
define('APP', ROOT_PATH . '/app');    //项目文件所在的目录
define('MODULES', 'app');
define('CONFIG', ROOT_PATH . '/config/');//config文件所在的目录
define('PUB', ROOT_PATH . '/public/');//css.js文件所在的目录
define('DEBUG', true);  //开启调试模式
if (DEBUG) {
    //打开显示错误的开关
    ini_set('display_error', 'On');
} else {
    ini_set('display_error', 'Off');
}

require_once CORE . '/common/function.php';   //加载函数库文件
//dbg(DIR, 'dir');
require_once CORE . '/MyCore.php';   //加载框架的核心文件

//当类不存在时触发“spl_autoload_register('MyCore::load');”方法
//spl_autoload_register("core\MyCore::load");
require VENDOR . '/autoload.php';
MyCore::run();