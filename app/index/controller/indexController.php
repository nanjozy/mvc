<?php

namespace app\index\controller;

use core\lib\Model;
use core\lib\View;
use core\myCore;
use index\module\bind;

class indexController extends myCore
{
    public $url = [];

    public function __construct()
    {
        $this->url = require CONFIG . "ind_url.php";
        $this->view = new View();
    }

    public function index()
    {
        $this->checkCook();
        $url['pageName'] = 'index';
        $this->view->assign('title', '首页');
        $this->view->assign($this->url);
        $this->view->display('header.html');
        $this->view->display('index.html');
        $this->view->display('footer.html');
    }

    private function checkCook()
    {
        $uTab = 'users';
        if (isset($_COOKIE["uid"]) && isset($_COOKIE["user"]) && isset($_COOKIE["password"])) {
            $db = Model::getInstance();
            $check = [$_COOKIE["uid"], $_COOKIE["user"], $_COOKIE["password"]];
            $result = $db->getSql($uTab, $check, 5);
            if ($result) {
                $_SESSION['user'] = $_COOKIE["user"];
                $_SESSION['uid'] = $_COOKIE["uid"];
            } else {
                setcookie("uid", '', time() - 24 * 7 * 3600);
                setcookie("user", "", time() - 3600);
                setcookie("password", '', time() - 3600);
            }
        } else if (!isset($_SESSION['user'])) {
            unset($_SESSION["uid"]);
            $_SESSION['user'] = $_SERVER['REMOTE_ADDR'];
            setcookie("uid", '', time() - 24 * 7 * 3600);
            setcookie("user", "", time() - 3600);
            setcookie("password", '', time() - 3600);
        }
    }

    public function bind()
    {
        $bind = new bind();
        $bind->bind();
    }
}