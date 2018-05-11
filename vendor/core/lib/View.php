<?php

namespace core\lib;

class View
{
    public $module = 'index';
    public $assign;

    public function __construct()
    {
        if (func_num_args() == 1) {
            $temp = func_get_args()[0];
            switch (gettype($temp)) {
                case 'string':
                    if ($temp) {
                        $this->module = $temp;
                    }
                    break;
                case 'array':
                    foreach ($temp as $k => $v) {
                        $this->assign[$k] = $v;
                    }
            }
        }
    }

    public function assign()
    {
        if (func_num_args() == 2) {
            $this->assign[func_get_args()[0]] = func_get_args()[1];
        } else if (func_num_args() == 1 && is_array(func_get_args()[0])) {
            $temp = func_get_args()[0];
            foreach ($temp as $k => $v) {
                $this->assign[$k] = $v;
            }
        }
    }

    public function display($file)
    {
        $file = APP . '/' . $this->module . '/view/' . $file;
        if (is_file($file)) {
            if (isset($this->assign)) {
                extract($this->assign);
            }
            require $file;
        }
    }
}