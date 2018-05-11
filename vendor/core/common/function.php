<?php

function U($m = 'index', $c = 'index', $f = 'index', $g = [])
{
    if ($m == '') {
        $m = 'index';
    }
    if ($c == '') {
        $c = 'index';
    }
    if ($f == '') {
        $f = 'index';
    }
    $url = "?m=$m&c=$c&f=$f";
    if ($g) {
        foreach ($g as $k => $v) {
            if ($g[$k]) {
                $url = "$url&$k=$v";
            }
        }
    }
//    $url = '?' . base64_encode($url);
    $url = base64_encode($url);
    return $url;
}

function dbg($var, $n)
{
    if (is_bool($var)) {
        var_dump($var);
    } else if (is_null($var)) {
        var_dump(NULL);
    } else {
        echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9'>";
        var_dump($var, $n);
        echo "</pre>";

    }
}