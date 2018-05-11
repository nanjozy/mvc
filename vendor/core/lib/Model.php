<?php

namespace core\lib;
class Model
{
    private static $_instance;
    private $_servername;
    private $_username;
    private $_password;
    private $_dbname;
    private $_conn;

    public function __construct()
    {
        if (isset(func_get_args()[0]) && count(func_get_args()[0]) == 4) {
            $args = func_get_args()[0];
            $this->_servername = $args[0];
            $this->_username = $args[1];
            $this->_password = $args[2];
            $this->_dbname = $args[3];
        } else {
            $this->_servername = "localhost";
            $this->_username = "root";
            $this->_password = "root";
            $this->_dbname = "websocket";
        }
        $this->_conn = mysqli_connect($this->_servername, $this->_username, $this->_password, $this->_dbname);
        $this->query("set names utf8");
    }

    public function query($sql)
    {
        $result = mysqli_query($this->_conn, $sql);
        if (is_bool($result)) {
            return $result;
        } else {
            $row = $rows = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            if (count($rows) > 1) {
                return $rows;
            } else if (count($rows) == 1) {
                return $rows[0];
            } else {
                return null;
            }
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self(func_get_args());
        }
        return self::$_instance;
    }

    public function getSql($tabname, $iden, $n)
    {
        switch ($n) {
            case 1:
                $sql = "SELECT * FROM $tabname WHERE id=$iden";
                break;
            case 2:
                $sql = "SELECT * FROM $tabname WHERE username='$iden'";
                break;
            case 3:
                $sql = "SELECT * FROM $tabname WHERE username='$iden[0]' AND password='$iden[1]'";
                break;
            case 4:
                $sql = "SELECT * FROM $tabname WHERE user='$iden[0]' AND date='$iden[1]'";
                break;
            case 5:
                $sql = "SELECT * FROM $tabname WHERE id='$iden[0]' AND username='$iden[1]' AND password='$iden[2]'";
        }
        $result = $this->query($sql);
        return $result;
    }

    function getSqls($tabname, $iden, $n)
    {
        switch ($n) {
            case 0:
                $sql = "SELECT * FROM $tabname WHERE id > $iden ORDER BY date";
                break;
            case 1:
                $sql = "SELECT * FROM $tabname WHERE id=$iden";
                break;
            case 2:
                $sql = "SELECT * FROM $tabname WHERE username='$iden'";
                break;
            case 3:
                $sql = "SELECT * FROM $tabname WHERE father = $iden ORDER BY date";

        }
        $result = $this->query($sql);
        return $result;
    }

    function getLastSql($tabname)
    {
        $sql = "SELECT * FROM $tabname ORDER BY id DESC limit 1";
        $result = $this->query($sql);
        return $result;
    }

    function inSql($tabname, $message, $n)
    {
        $time = time();
        switch ($n) {
            case 1:
                $sql = "INSERT INTO $tabname (user,message,date) VALUES ('$message[0]','$message[1]',$time)";
                break;
            case 2:
                $sql = "INSERT INTO $tabname (username,password,date) VALUES ('$message[0]','$message[1]',$time)";
                break;
            case 3:
                if ($message[2] > 0) {
                    $sql = "INSERT INTO $tabname (user,note,date,father) VALUES ('$message[0]','$message[1]',$time,2)";
                } else {
                    $sql = "INSERT INTO $tabname (user,note,date,father) VALUES ('$message[0]','$message[1]',$time,1)";
                }
        }
        $result = $this->query($sql);
        return $result;
    }
}