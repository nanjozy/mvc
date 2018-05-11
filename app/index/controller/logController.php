<?php

namespace app\index\controller;

use app\index\module\user;
use core\lib\View;
use core\myCore;

class logController extends myCore
{
    public $url = [];
    private $user;

    public function __construct()
    {
        $this->user = new user();
        $this->view = new View();
        $this->url = require CONFIG . "ind_url.php";
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->url['pageName'] = 'register';
            $this->view->assign('title', '注册');
            $this->view->assign($this->url);
            $this->view->display('header.html');
            $this->view->display('register.html');
            $this->view->display('footer.html');
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->register();
        }
    }

    public function checkReg()
    {
        switch ($_POST['code']) {
            case 0:
                $this->user->checkuser();
                break;
            case 1:
                $this->user->checkpass();
                break;
            case 2:
                $this->user->checkpass2();
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $url = [
                'pageName' => 'login',
                'url_login' => U('', 'log', 'login'),
                'url_reg' => U('', 'log', 'register'),
                'url_logout' => U('', 'log', 'logout'),
                'url_bind' => U('', '', 'bind'),
                'url_postMsg' => U('', '', 'postMsg'),
            ];
            $this->view->assign('title', '登录');
            $this->view->assign($url);
            $this->view->display('header.html');
            $this->view->display('login.html');
            $this->view->display('footer.html');
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->login();
        }
    }

    public function logout()
    {
        $this->user->logout();
    }
}