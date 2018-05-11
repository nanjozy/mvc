<?php

namespace app\index\module;

use core\lib\Model;

class user
{
    public function register()
    {
        $re = false;
        $uTab = 'users';
        $db = Model::getInstance();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        if (!preg_match("/^[a-zA-Z][a-zA-Z0-9]{4,8}$/", $username)) {
            $re = false;
        } else {
            try {
                $result = $db->getSql($uTab, $username, 2);
                if ($result) {
                    $re = false;
                } else {
                    $re = true;
                }
            } catch (Exception $e) {
                $re = false;
            }
        }
        if ($re) {
            $re = false;
            if (!preg_match("/^[a-zA-Z0-9]{4,16}$/", $password)) {
                $re = false;
            } else if (!preg_match("/^.*(?=.*\d)(?=.*[a-zA-Z]).*$/", $password)) {
                $re = false;
            } else if ($password == $password2) {
                $re = true;
            } else {
                $re = false;
            }
        }
        if ($re) {
            $user = [$username, md5($password)];
            try {
                $return = $db->inSql($uTab, $user, 2);
                if ($return) {
                    $re = true;
                } else {
                    $re = false;
                }
            } catch (Exception $e) {
                $re = false;
            }
        }
        if (!$re) {
            $re = ['code' => 0, 'msg' => '注册失败'];
            echo json_encode($re);
        } else {
            $re = ['code' => 1, 'msg' => '注册成功'];
            echo json_encode($re);
        }
    }

    public function checkuser()
    {
        $username = $_POST['name'];
        if (!preg_match("/^[a-zA-Z][a-zA-Z0-9]{4,8}$/", $username)) {
            $re = ['code' => -1, 'msg' => '用户名格式错误'];
            echo json_encode($re);
        } else {
            $uTab = 'users';
            try {
                $db = \core\lib\Model::getInstance();
                $result = $db->getSql($uTab, $username, 2);
                if ($result == null) {
                    $re = ['code' => 1, 'msg' => 'success'];
                    echo json_encode($re);
                } else if ($result) {
                    $re = ['code' => 0, 'msg' => '用户已存在'];
                    echo json_encode($re);
                }
            } catch (Exception $e) {
                $re = ['code' => -9, 'msg' => '403'];
                echo json_encode($re);
            }
        }
    }

    public function checkpass()
    {
        $pass = $_POST['pass'];
        if (!preg_match("/^[a-zA-Z0-9]{4,16}$/", $pass)) {
            $re = ['code' => 0, 'msg' => '密码格式错误'];
            echo json_encode($re);
        } else if (!preg_match("/^.*(?=.*\d)(?=.*[a-zA-Z]).*$/", $pass)) {
            $re = ['code' => 1, 'msg' => '密码强度不够'];
            echo json_encode($re);
        } else {
            $re = ['code' => 2, 'msg' => 'success'];
            echo json_encode($re);
        }
    }

    public function checkpass2()
    {
        $pass = $_POST['pass'];
        $pass2 = $_POST['pass2'];
        if ($pass2 == $pass) {
            $re = ['code' => 1, 'msg' => 'success'];
            echo json_encode($re);
        } else {
            $re = ['code' => 0, 'msg' => '两次密码不一致'];
            echo json_encode($re);
        }
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $user = [$username, $password];
        $uTab = 'users';
        $db = \core\lib\Model::getInstance();
        $result = $db->getSql($uTab, $user, 3);
        if ($result) {
            $_SESSION['user'] = $username;
            $_SESSION['uid'] = $result['id'];
            if (isset($_POST['remember_me'])) {
                setcookie("uid", $_SESSION['uid'], time() + 24 * 7 * 3600);
                setcookie("user", $username, time() + 24 * 7 * 3600);
                setcookie("password", $password, time() + 24 * 7 * 3600);
            } else {
                setcookie("uid", $_SESSION['uid'], time() - 24 * 7 * 3600);
                setcookie("user", $username, time() - 3600);
                setcookie("password", $password, time() - 3600);
            }
            $re = ['code' => 1, 'msg' => 'success'];
            echo json_encode($re);
        } else {
            $re = ['code' => 0, 'msg' => 'error'];
            echo json_encode($re);
        }
    }

    public function logout()
    {
        unset($_SESSION["user"]);
        unset($_SESSION["uid"]);
        setcookie("uid", '', time() - 24 * 7 * 3600);
        setcookie("user", "", time() - 3600);
        setcookie("password", '', time() - 3600);
        $re = ['code' => 1, 'msg' => 'finish'];
        echo json_encode($re);
    }
}